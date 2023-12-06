<?php
include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
  header('location:login.php');
}



if (isset($_POST['add_to_cart'])) {
  $product_id = $_POST['product_id'];
  $product_quantity = $_POST['product_quantity'];

  $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` 
  WHERE product_id = '$product_id' AND user_id = '$user_id'") or die('query failed');

  if (mysqli_num_rows($check_cart_numbers) > 0) {
    $message[] = 'already added to cart';
  } else {
    mysqli_query($conn, "INSERT INTO `cart`(user_id, product_id, quantity) 
    VALUES('$user_id', '$product_id','$product_quantity')")
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

    <h1 class="title">latest products</h1>

    <div class="box-container">

      <?php
      $select_products = mysqli_query($conn, "SELECT * FROM `products` 
      LIMIT 6")
        or die('query failed');
      if (mysqli_num_rows($select_products) > 0) {
        while ($fetch_products = mysqli_fetch_assoc($select_products)) {

      ?>
          <form action="" method="post" class="box">
            <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
            <div class="name"><?php echo $fetch_products['name']; ?></div>
            <div class="price">$<?php echo $fetch_products['price']; ?>/-</div>
            <input type="number" min="1" name="product_quantity" value="1" class="qty">
            <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">

            <input type="submit" value="add to cart" name="add_to_cart" class="btn">
          </form>
      <?php
        }
      } else {
        echo '<p class="empty">no products added yet!</p>';
      }
      ?>
    </div>
    <div class="load-more" style="margin-top: 2rem; text-align: center;">
      <a href="shop.php" class="option-btn">load more</a>
    </div>
  </section>


  <div class="about">

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
  </div>
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