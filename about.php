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
  <div class="heading">
    <h3>about us</h3>
    <p><a href="home.php">home</a>/ about</p>
  </div>


  <section class="about">

    <div class="flex">
      <div class="image">
        <img src="images/about-img.jpg" alt="">
      </div>
      <div class="content">
        <h3>why choose us</h3>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Numquam maiores nemo, nulla possimus sapiente
          libero enim ratione aliquid, vel nam dolorum blanditiis sint necessitatibus molestias consequatur. Amet minima
          doloremque quis.</p>
        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sint exercitationem commodi, vero minima
          perferendis inventore quaerat officiis quos consequatur porro!</p>
        <a href="contact.php" class="btn">contact us</a>
      </div>
    </div>
  </section>

  <section class="reviews">
    <h1 class="title">client's reviews</h1>

    <div class="box-container">

      <div class="box">
        <img src="images/pic-1.png" alt="">
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum officia unde recusandae! Fuga, sequi? At
          sit esse voluptates illo cumque.</p>
        <div class="stars">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star-half-alt"></i>
        </div>
        <h3>john nguyen</h3>
      </div>

      <div class="box">
        <img src="images/pic-2.png" alt="">
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum officia unde recusandae! Fuga, sequi? At
          sit esse voluptates illo cumque.</p>
        <div class="stars">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star-half-alt"></i>
        </div>
        <h3>john nguyen</h3>
      </div>

      <div class="box">
        <img src="images/pic-3.png" alt="">
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum officia unde recusandae! Fuga, sequi? At
          sit esse voluptates illo cumque.</p>
        <div class="stars">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star-half-alt"></i>
        </div>
        <h3>john nguyen</h3>
      </div>

      <div class="box">
        <img src="images/pic-4.png" alt="">
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum officia unde recusandae! Fuga, sequi? At
          sit esse voluptates illo cumque.</p>
        <div class="stars">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star-half-alt"></i>
        </div>
        <h3>john nguyen</h3>
      </div>

      <div class="box">
        <img src="images/pic-5.png" alt="">
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum officia unde recusandae! Fuga, sequi? At
          sit esse voluptates illo cumque.</p>
        <div class="stars">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star-half-alt"></i>
        </div>
        <h3>john nguyen</h3>
      </div>

      <div class="box">
        <img src="images/pic-6.png" alt="">
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum officia unde recusandae! Fuga, sequi? At
          sit esse voluptates illo cumque.</p>
        <div class="stars">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star-half-alt"></i>
        </div>
        <h3>john nguyen</h3>
      </div>


    </div>
  </section>

  <section class="authors">

    <h1 class="title">greate authors</h1>
    <div class="box-container">

      <div class="box">
        <img src="images/author-1.jpg" alt="">
        <div class="share">
          <a href="" class="fab fa-facebook-f"></a>
          <a href="" class="fab fa-twitter"></a>
          <a href="" class="fab fa-instagram"></a>
          <a href="" class="fab fa-linkedin"></a>
        </div>
        <h3>con tu hu</h3>
      </div>

      <div class="box">
        <img src="images/author-2.jpg" alt="">
        <div class="share">
          <a href="" class="fab fa-facebook-f"></a>
          <a href="" class="fab fa-twitter"></a>
          <a href="" class="fab fa-instagram"></a>
          <a href="" class="fab fa-linkedin"></a>
        </div>
        <h3>con tu hu</h3>
      </div>

      <div class="box">
        <img src="images/author-3.jpg" alt="">
        <div class="share">
          <a href="" class="fab fa-facebook-f"></a>
          <a href="" class="fab fa-twitter"></a>
          <a href="" class="fab fa-instagram"></a>
          <a href="" class="fab fa-linkedin"></a>
        </div>
        <h3>con tu hu</h3>
      </div>

      <div class="box">
        <img src="images/author-4.jpg" alt="">
        <div class="share">
          <a href="" class="fab fa-facebook-f"></a>
          <a href="" class="fab fa-twitter"></a>
          <a href="" class="fab fa-instagram"></a>
          <a href="" class="fab fa-linkedin"></a>
        </div>
        <h3>con tu hu</h3>
      </div>

      <div class="box">
        <img src="images/author-5.jpg" alt="">
        <div class="share">
          <a href="" class="fab fa-facebook-f"></a>
          <a href="" class="fab fa-twitter"></a>
          <a href="" class="fab fa-instagram"></a>
          <a href="" class="fab fa-linkedin"></a>
        </div>
        <h3>con tu hu</h3>
      </div>

      <div class="box">
        <img src="images/author-6.jpg" alt="">
        <div class="share">
          <a href="" class="fab fa-facebook-f"></a>
          <a href="" class="fab fa-twitter"></a>
          <a href="" class="fab fa-instagram"></a>
          <a href="" class="fab fa-linkedin"></a>
        </div>
        <h3>con tu hu</h3>
      </div>
    </div>


  </section>

  <?php
  include 'footer.php';
  ?>
  <script src="js/script.js"></script>
</body>

</html>