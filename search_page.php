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
  <title>order</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <?php
  include 'header.php';
  ?>
  <div class="heading">
    <h3>search page</h3>
    <p><a href="home.php">order</a>/ search</p>
  </div>
  <!-- search  -->
  <section class="search-form">
    <form action="" method="get">
      <input type="text" name="search" placeholder="search products..." class="box" value="<?php if (isset($_GET['search'])) echo $_GET['search'] ?>">
      <select id="category" name="category" class="box-price">
        <option value="">Category</option>
        <!-- categories -->
        <?php
        $categories = mysqli_query($conn, "SELECT * FROM `categorys`");
        if (mysqli_num_rows($categories) > 0) {
          $s = "";
          while ($fetch_categories = mysqli_fetch_assoc($categories)) {
            if (!empty($_GET['category']) && $_GET['category'] == $fetch_categories['id'])
              $s .= sprintf('<option value="%s" selected>%s</option>, ', $fetch_categories['id'], $fetch_categories['category_name']);
            $s .= sprintf('<option value="%s">%s</option>, ', $fetch_categories['id'], $fetch_categories['category_name']);
          }
          echo $s;
        }
        ?>
      </select>
      <input type="number" name="minPrice" placeholder="min price" class="box-price" value="<?php if (isset($_GET['minPrice'])) echo $_GET['minPrice'] ?>"><br>
      <input type="number" name="maxPrice" placeholder="max price" class="box-price" value="<?php if (isset($_GET['maxPrice'])) echo $_GET['maxPrice'] ?>"><br>
      <input type="submit" name="submit" value="search" class="btn">
    </form>
  </section>

  <section class="products" style="padding-top: 0;">
    <div class="box-container" id="product-container">
      <?php
      if (isset($_GET['submit']) || isset($_GET['page'])) {
        $results_per_page = 6;
        $number_of_results = 0;
        $number_of_pages = 0;
        if (isset($_GET['search']))
          $searchItem = $_GET['search'];
        else
          $searchItem = "";
        // LIMIT $results_per_page OFFSET  $this_page_first_result
        if (!empty($_GET['category'])) {
          $sql = "SELECT p.* FROM `products` as p, `categorys` as c
          WHERE p.name LIKE '%$searchItem%' AND p.category_id = c.id and c.id = {$_GET['category']}";
          if (!empty($_GET['minPrice']) && !empty($_GET['maxPrice'])) {
            $minPrice = $_GET['minPrice'];
            $maxPrice = $_GET['maxPrice'];
            $sql .= " AND p.price BETWEEN $minPrice AND $maxPrice";
          }
        } else {
          $sql = "SELECT * FROM `products` WHERE name LIKE '%$searchItem%'";
          if (!empty($_GET['minPrice']) && !empty($_GET['maxPrice'])) {
            $minPrice = $_GET['minPrice'];
            $maxPrice = $_GET['maxPrice'];
            $sql .= " AND price BETWEEN $minPrice AND $maxPrice";
          }
        }
        $result = mysqli_query($conn, $sql) or die('query failed');

        $number_of_results = mysqli_num_rows($result);
        $number_of_pages = ceil($number_of_results / $results_per_page);
        if (!isset($_GET['page'])) {
          $page = 1;
        } else {
          $page = $_GET['page'];
        }
        $this_page_first_result = ($page - 1) * $results_per_page;
        $sql .= " LIMIT $results_per_page OFFSET  $this_page_first_result ";
        $result = mysqli_query($conn, $sql) or die('query failed');
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
      ?>
            <form action="" method="POST" class="box">
              <img class="image" src="uploaded_img/<?php echo $row['image']; ?>" alt="">
              <div class="name"><?php echo $row["name"]; ?></div>
              <div class="price">$<?php echo $row["price"]; ?>/-</div>
              <input type="number" min="1" name="product_quantity" value="1" class="qty">
              <input type="hidden" name="product_name" value="<?php echo $row["name"]; ?>">
              <input type="hidden" name="product_price" value="<?php echo $row["price"]; ?>">
              <input type="hidden" name="product_image" value="<?php echo $row["image"]; ?>">
              <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
              <input type="submit" value="add to cart" name="add_to_cart" class="btn">
            </form>
      <?php
          }
        } else {
          echo '<p class="empty">no result found!</p>';
        }
      } else {
        echo '<p class="empty">search something!</p>';
      }
      ?>
    </div>
    <div class="pagination">
      <?php
      if (isset($_GET['submit']) || isset($_GET['page'])) {
        echo '<a name="prev-btn" href="search_page.php?page=1">&laquo;</a>';
        for ($page = 1; $page <= $number_of_pages; $page++) {
          $active = ($page == 1) ? 'active' : '';
          if (isset($_GET['page'])) {
            if ($_GET['page'] == $page) {
              $active = 'active';
            } else {
              $active = '';
            }
          }
          $s = '<a class="' . $active . '"id="num_page" href="search_page.php?page=' . $page . '';
          if (!empty($_GET['search'])) {
            $s .= '&search=' . $_GET['search'] . '';
          }
          if (!empty($_GET['category'])){
            $s .= '&category=' . $_GET['category'] . '';
          }
          if(!empty($_GET['minPrice']) && !empty($_GET['maxPrice'])){
            $s .= '&minPrice=' . $_GET['minPrice'] . '&maxPrice='. $_GET['maxPrice'] .'';
          }
          echo $s . '">' . $page . '</a> ';
        }
        $s = '<a class="next-btn" href="search_page.php?page=' . $number_of_pages . '';
        if (!empty($_GET['search'])) {
          $s .= '&search=' . $_GET['search'] . '';
        }
        if (!empty($_GET['category'])){
          $s .= '&category=' . $_GET['category'] . '';
        }
        if(!empty($_GET['minPrice']) && !empty($_GET['maxPrice'])){
          $s .= '&minPrice=' . $_GET['minPrice'] . '&maxPrice='. $_GET['maxPrice'] .'';
        }
        echo $s .'">&raquo;</a>';
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