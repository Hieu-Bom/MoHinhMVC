<!DOCTYPE html>
<html>
    <head>
        <title>Phan Trang</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>

        <?php
        $host = "localhost";
        $user = "root";
        $password = "";
        $database = "danguitar";
        $con = mysqli_connect($host, $user, $password, $database);
        if (mysqli_connect_errno()){
            echo "Connection Fail: ".mysqli_connect_errno();exit;
        }
        $item_per_page = !empty($_GET['per_page'])?$_GET['per_page']:8;
        $current_page = !empty($_GET['page'])?$_GET['page']:1; //Trang hiện tại
        $offset = ($current_page - 1) * $item_per_page;
        $products = mysqli_query($con, "SELECT * FROM `tbl_product` ORDER BY `pro_id` ASC  LIMIT " . $item_per_page . " OFFSET " . $offset);
        $totalRecords = mysqli_query($con, "SELECT * FROM `tbl_product`");
        $totalRecords = $totalRecords->num_rows;
        $totalPages = ceil($totalRecords / $item_per_page);
        ?>
        <?php
            $conn1 = mysqli_connect("localhost","root","","danguitar");
                mysqli_query($conn1,"SET NAMES 'utf8'");
                //tạo chuỗi sql
                $sql1 = "SELECT * FROM tbl_category";
                //Thực hiện query truy vấn
                $kq1=mysqli_query($conn1,$sql1);
            ?>
        <ul class="menu">
        <?php
                while($row1 = mysqli_fetch_array($kq1))
                {   
                ?>
                <li>
                    <a href="">
                        <?php
                            echo $row1['cat_name'];
                        ?>
                    </a>
                </li>
            <?php           
                }
        ?>
        </ul>
        <div class="container">
            <h1>Danh sách sản phẩm</h1>
            <div class="product-items">
                <?php
                while ($row = mysqli_fetch_array($products)) {
                    ?>
                    <div class="product-item">
                        <div class="product-img">
                            <img src="<?= $row['image'] ?>" title="<?= $row['pro_name'] ?>" />
                        </div>
                        <strong><?= $row['pro_name'] ?></strong><br/>
                        <label>Giá: </label><span class="product-price"><?= number_format($row['price'], 0, ",", ".") ?> đ</span><br/>
                        <p><?= $row['description'] ?></p>
                        <div class="buy-button">
                            <a href="./add_cart.php">Mua sản phẩm</a>
                        </div>
                    </div>
                <?php } ?>
                <div class="clear-both"></div>
                <?php
                if ($current_page > 3) {
    $first_page = 1;
    ?>
    <a class="page-item" href="?per_page=<?= $item_per_page ?>&page=<?= $first_page ?>">First</a>
    <?php
        }
        if ($current_page > 1) {
            $prev_page = $current_page - 1;
            ?>
            <a class="page-item" href="?per_page=<?= $item_per_page ?>&page=<?= $prev_page ?>">Prev</a>
        <?php }
        ?>
        <?php for ($num = 1; $num <= $totalPages; $num++) { ?>
            <?php if ($num != $current_page) { ?>
                <?php if ($num > $current_page - 3 && $num < $current_page + 3) { ?>
                    <a class="page-item" href="?per_page=<?= $item_per_page ?>&page=<?= $num ?>"><?= $num ?></a>
                <?php } ?>
            <?php } else { ?>
                <strong class="current-page page-item"><?= $num ?></strong>
            <?php } ?>
        <?php } ?>
        <?php
        if ($current_page < $totalPages - 1) {
            $next_page = $current_page + 1;
            ?>
            <a class="page-item" href="?per_page=<?= $item_per_page ?>&page=<?= $next_page ?>">Next</a>
        <?php
        }
        if ($current_page < $totalPages - 3) {
            $end_page = $totalPages;
            ?>
            <a class="page-item" href="?per_page=<?= $item_per_page ?>&page=<?= $end_page ?>">Last</a>
            <?php
        }
                ?>
                <div class="clear-both"></div>
            </div>
        </div>
    </body>
</html>