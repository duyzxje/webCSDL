<?php
include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
  header('location:login.php');
}

$products_data = mysqli_query($conn, "SELECT * FROM `products`");


if (isset($_POST['add_to_cart'])) {
  $product_id = $_POST['product_id'];
  $product_quantity = $_POST['product_quantity'];

  $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` 
  WHERE product_id = '$product_id' AND user_id = '$user_id'") or die('query failed');

  if (mysqli_num_rows($check_cart_numbers) > 0) {
    $message[] = 'already added to cart';
  } else {
    mysqli_query($conn, "INSERT INTO `cart`(user_id, product_id, quantity) 
    VALUES('$user_id', '$product_id','$product_quantity', )")
      or die('query failed');
    $message[] = 'product added to cart!';
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>product-detail</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <?php
  include 'header.php';
  ?>


  <section class="container">
    <div class="bookdetailwrap">

      <form action="" method="post" class="productdetail-info clearfix">
        <?php if (mysqli_num_rows($products_data) > 0) {
          while ($fetch_products = mysqli_fetch_assoc($products_data)) {

            if ($_GET['idSp'] == $fetch_products['id']) {

        ?>
        <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
        <img src="./uploaded_img/<?= $fetch_products['image'] ?>" alt="">
        <div class="info">
          <h1><?= $fetch_products['name'] ?></h1>
          <div class="intro clearfix">
            <div class="attributes">
              <ul>
                <li>
                  <span>Product code:</span>
                  <a href="#"><?= $fetch_products['code'] ?></a>
                </li>
                <li>
                  <span>Author:</span>
                  <a href="#"><?= $fetch_products['author'] ?></a>
                </li>
                <li>
                  <span>Translator:</span>
                  <a href="#"><?= $fetch_products['translator'] ?></a>
                </li>
                <li>
                  <span>Publisher:</span>
                  <a href="#"><?= $fetch_products['publisher'] ?></a>
                </li>
              </ul>
              <ul>
                <li>
                  Number of pages: <?= $fetch_products['num_page'] ?>
                </li>
                <li>
                  Size: <?= $fetch_products['size'] ?>
                </li>

                <li>
                  Release date: <?= $fetch_products['release_date'] ?>
                </li>
              </ul>
            </div>
            <div class="action">
              <div class="price">
                <p>Price: <span>$<?= $fetch_products['price'] ?>/-</span></p>
              </div>
              <div class="quantitytext">Quantity:</div>
              <div class="quantity">
                <input type="number" min="1" value="1" name="product_quantity" class="qty">
              </div>
              <input type="submit" value="add to cart" name="add_to_cart" class="btn">
            </div>
          </div>
        </div>
      </form>

      <div class="productdetail-slide">
        <h1>You Might Also Enjoy</h1>
        <div class="productslider">
          <div class="box_wrapper">

            <ul class="clearfix listproduct">
              <?php
              $select_product_images = mysqli_query($conn, "SELECT * FROM `products` LIMIT 6") or die('query failed');
              if (mysqli_num_rows($select_product_images) > 0) {
                while ($fetch_images = mysqli_fetch_assoc($select_product_images)) {
              ?>
              <li class="product">
                <a href="product_detail.php?idSp=<?= $fetch_images['id'] ?>" class="image"><img
                    src="./uploaded_img/<?= $fetch_images['image'] ?>" alt=""></a>
              </li>
              <?php
                }
              }
              ?>
            </ul>
          </div>

          <a class="prev" href="#" style="display: block;">
            < </a>
              <a class="next" href="#" style="display: block;">
                >
              </a>
        </div>
      </div>

      <?php
            }
          }
        } else {
          echo '<p class="empty">product not found !</p>';
        }
?>
    </div>
  </section>






  <?php
  include 'footer.php';
  ?>
  <script src="js/script.js"></script>
</body>

</html>