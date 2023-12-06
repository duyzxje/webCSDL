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
    VALUES('$user_id', '$product_id','$product_quantity', )")
      or die('query failed');
    $message[] = 'product added to cart!';
  }
}
// define how many results you want per page
$results_per_page = 6;

if (!isset($_GET['category'])) {
  $sql = 'SELECT * FROM products';
  $result = mysqli_query($conn, $sql);
  $number_of_results = mysqli_num_rows($result);
} else {
  $category = $_GET['category'];
  $sql = "SELECT * FROM `products`,`categorys` WHERE products.category_id = categorys.id AND categorys.category_name = '$category'";
  $result = mysqli_query($conn, $sql);
  $number_of_results = mysqli_num_rows($result);
}



// determine number of total pages available
$number_of_pages = ceil($number_of_results / $results_per_page);

// determine which page number visitor is currently on
if (!isset($_GET['page'])) {
  $page = 1;
} else {
  $page = $_GET['page'];
}

$this_page_first_result = ($page - 1) * $results_per_page;


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>shop</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <?php
  include 'header.php';
  ?>
  <div class="heading">
    <h3>our shop</h3>
    <p><a href="shop.php">home</a> / shop</p>
  </div>



  <div class="category-container">
    <div class="card">
      <div class="title-menu">
        <h3>Category</h3>
      </div>
      <div class="category-link">
        <ul>
          <?php
          $select_categorys = mysqli_query($conn, "SELECT * FROM `categorys`") or die('query failed');
          if (mysqli_num_rows($select_categorys) > 0) {
            while ($fetch_categorys = mysqli_fetch_assoc($select_categorys)) {
          ?>
          <a href="shop.php?category=<?= $fetch_categorys['category_name'] ?>"
            value="<?php echo $fetch_categorys['id'] ?>">
            <li><?php echo $fetch_categorys['category_name'] ?></li>
          </a>
          <?php
            }
          }
          ?>
        </ul>
      </div>
    </div>
  </div>

  <section class="products">

    <h1 class="title">lastest products</h1>


    <div class="box-container">

      <?php
      if (isset($_GET['category'])) {
        $category = $_GET['category'];
        $select_products = mysqli_query($conn, "SELECT * FROM `products`,`categorys` 
        WHERE products.category_id = categorys.id 
        AND categorys.category_name = '$category' 
        LIMIT $results_per_page OFFSET  $this_page_first_result ")  or die('query failed');;
      } else {
        $select_products = mysqli_query($conn, "SELECT * FROM `products` 
        LIMIT $results_per_page OFFSET  $this_page_first_result ")  or die('query failed');;
      }

      if (mysqli_num_rows($select_products) > 0) {
        while ($fetch_products = mysqli_fetch_assoc($select_products)) {

      ?>
      <form action="" method="post" class="box">
        <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
        <a href="product_detail.php?idSp=<?= $fetch_products['id'] ?>"><img class="image"
            src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt=""></a>
        <div class="name"><?php echo $fetch_products['name']; ?></div>
        <div class="price">$<?php echo $fetch_products['price']; ?>/-</div>
        <input type="number" min="1" name="product_quantity" value="1" class="qty">
        <input type="submit" value="add to cart" name="add_to_cart" class="btn">
      </form>
      <?php
        }
      } else {
        echo '<p class="empty">no products added yet!</p>';
      }
      ?>
    </div>

    <div class="pagination">
      <?php
      if (!isset($_GET['category'])) {
        echo '<a name="prev-btn" href="shop.php?page=1">&laquo;</a>';
      } else {
        $category = $_GET['category'];
        echo '<a name="prev-btn" href="shop.php?category=' . $category . '&page=1">&laquo;</a>';
      }


      for ($page = 1; $page <= $number_of_pages; $page++) {
        $active = ($page == 1) ? 'active' : '';
        if (isset($_GET['page'])) {
          if ($_GET['page'] == $page) {
            $active = 'active';
          } else {
            $active = '';
          }
        }
        if (!isset($_GET['category'])) {
          echo '<a class="' . $active . '"id="num_page" href="shop.php?page=' . $page . '">' . $page . '</a> ';
        } else {
          $category = $_GET['category'];
          echo '<a class="' . $active . '"id="num_page" href="shop.php?category=' . $category . '&page=' . $page . '">' . $page . '</a> ';
        }
      }

      if (!isset($_GET['category'])) {
        echo '<a class="next-btn" href="shop.php?page=' . $number_of_pages . '">&raquo;</a>';
      } else {
        $category = $_GET['category'];
        echo '<a class="next-btn" href="shop.php?category=' . $category . '&page=' . $number_of_pages . '">&raquo;</a>';
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