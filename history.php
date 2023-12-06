<?php
include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
    header('location:login.php');
}


?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    include 'header.php';
    ?>


    <section class="home">
        <div class="content">
            <h3>Hand Picked Book to ur door.</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste vel ex omnis voluptatem expedita vitae illo odit
                id? Magnam, delectus!</p>
            <a href="about.php" class="white-btn">discover more</a>

        </div>
    </section>

    <section class="products">

        <h1 class="title">purchase history</h1>

        <!-- <div class="box-container"> -->


        <?php
        if (isset($_POST['history'])) {
            $user_id = $_POST['user_id'];
        }

        // Thay thế giá trị này bằng ID của người dùng cần xem

        $sql = "SELECT * FROM `orders` WHERE user_id = '$user_id'; 
-- ORDER BY place_on DESC";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo '<table class="order-history">';
            echo '<thead><tr><th>Mã đơn hàng</th><th>Ngày đặt hàng</th><th>Tên</th><th>Giá</th></tr></thead>';
            echo '<tbody>';
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td class="order-id">' . $row["id"] . '</td>';
                echo '<td class="order-date">' . $row["placed_on"] . '</td>';
                echo '<td class="order-name">' . $row["name"] . '</td>';
                echo '<td class="order-price">' . $row["total_price"] . '</td>';
                echo '</tr>';
            }
            echo '</tbody></table>';
        } else {
            echo "Không tìm thấy đơn hàng.";
        }

        ?>






        <!-- <div class="about">

            <section class="flex">
                <div class="image">
                    <img src="images/about-img.jpg" alt="">
                </div>
                <div class="content">
                    <h3>about us</h3>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sint exercitationem commodi, vero minima
                        perferendis inventore quaerat officiis quos consequatur porro!</p>
                    <a href="about.php" class="btn">read more</a>
                </div>
        </div> -->
    </section>

    <section class="home-contact">
        <div class="content">
            <h3>have any questions?</h3>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dicta impedit nostrum expedita odit aut cupiditate!
            </p>
            <a href="contact.php" class="white-btn">contact us</a>
        </div>
    </section>

    <?php
    include 'footer.php';
    ?>
    <script src="js/script.js"></script>
</body>

</html>