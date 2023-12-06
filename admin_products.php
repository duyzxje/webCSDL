<?php
include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
  header('location:login.php');
}

if (isset($_POST['add_product'])) {
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $category = $_POST['category'];
  $price = $_POST['price'];

  $code = $_POST['code'];
  $author = $_POST['author'];
  $translator = $_POST['translator'];
  $publisher = $_POST['publisher'];
  $num_page = $_POST['num_page'];
  $size = $_POST['size'];

  $image = $_FILES['image']['name'];
  $image_size = $_FILES['image']['size'];
  $image_tmp_name = $_FILES['image']['tmp_name'];
  $image_folder = 'uploaded_img/' . $image;

  $select_product_name = mysqli_query($conn, "SELECT name FROM `products`
  WHERE name = '$name'") or die('query failed');

  if (mysqli_num_rows($select_product_name) > 0) {
    $message[] = 'product name already added';
  } else {
    $add_product_query = mysqli_query($conn, "INSERT INTO `products`(name, price, image, category_id, 
    code, author, translator, publisher, num_page, size)
    VALUES('$name','$price', '$image', '$category', 
    '$code', '$author', '$translator', '$publisher', '$num_page', '$size')") or die('query failed');

    if ($add_product_query) {

      if ($image_size > 200000) {
        $message[] = 'image size is too large';
      } else {
        move_uploaded_file($image_tmp_name, $image_folder);
        $message[] = 'product added successfully!';
      }
    } else {
      $message[] = 'product could not be added!';
    }
  }
}

if (isset($_GET['delete'])) {
  $delete_id = $_GET['delete'];

  $delete_image_query = mysqli_query($conn, "SELECT image FROM `products` WHERE 
  id = '$delete_id`'") or die('query failed');
  $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
  //Xóa ảnh của product trong thư mục uploađe_img
  unlink('uploaded_img/' . $fetch_delete_image['image']);
  mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'")
    or die('query failed');
  header('location:admin_products.php');
}

if (isset($_POST['update_product'])) {
  $update_p_id = $_POST['update_p_id'];
  $update_name = $_POST['update_name'];
  $updata_category = $_POST['update_category'];
  $update_price = $_POST['update_price'];

  mysqli_query($conn, "UPDATE `products` SET name = '$update_name', price =
  '$update_price', category_id ='$updata_category' WHERE id = '$update_p_id'") or die('query failed');
  $update_image = $_FILES['update_image']['name'];
  $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
  $update_image_size = $_FILES['update_image']['size'];
  $update_folder = 'uploaded_img/' . $update_image;
  $update_old_image = $_POST['update_old_image'];

  //kiểm tra admin có thay đổi ảnh của product đó ko
  if (!empty($update_image)) {
    if ($update_image_size > 2000000) {
      $message[] = 'image file size is too large';
    } else {
      mysqli_query($conn, "UPDATE `products` SET image = '$update_image'
       WHERE id = '$update_p_id'") or die('query failed');
      move_uploaded_file($update_image_tmp_name, $update_folder);
      //Xóa ảnh cũ của product
      unlink('uploaded_img/' . $update_old_image);
    }
  } else {
    header('location:admin_products.php');
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>products</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <link rel="stylesheet" href="css/admin_style.css">

</head>

<body>
  <?php
  include 'admin_header.php';
  ?>
  <section class="add-products">
    <h1 class="title">shop products</h1>
    <form action="" method="post" enctype="multipart/form-data">
      <h3>add product</h3>
      <input type="text" name="name" class="box" placeholder="enter product name" required>
      <select name="category" class="box">
        <?php
        $select_categorys = mysqli_query($conn, "SELECT * FROM `categorys`") or die('query failed');
        if (mysqli_num_rows($select_categorys) > 0) {
          while ($fetch_categorys = mysqli_fetch_assoc($select_categorys)) {
        ?>
        <option value="<?php echo $fetch_categorys['id'] ?>"><?php echo $fetch_categorys['category_name'] ?></option>
        <?php
          }
        }
        ?>
      </select>
      <input type="number" min="0" name="price" class="box" placeholder="enter product price" required>
      <input type="text" name="code" class="box" placeholder="enter product code" required>
      <input type="text" name="author" class="box" placeholder="enter product author" required>
      <input type="text" name="translator" class="box" placeholder="enter product translator" required>
      <input type="text" name="publisher" class="box" placeholder="enter product publisher" required>
      <input type="text" name="num_page" class="box" placeholder="enter product number of page" required>
      <input type="text" name="size" class="box" placeholder="enter product size" required>
      <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
      <input type="submit" value="add product" name="add_product" class="btn">
    </form>
  </section>

  <section class="show-products">
    <div class="box-container">
      <?php
      $select_products = mysqli_query($conn, "SELECT * FROM `products`")
        or die('query failed');
      if (mysqli_num_rows($select_products) > 0) {
        while ($fetch_products = mysqli_fetch_assoc($select_products)) {
      ?>
      <div class="box">
        <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
        <div class="name"><?php echo $fetch_products['name']; ?></div>
        <div class="price">$<?php echo $fetch_products['price']; ?>/-</div>
        <a href="admin_products.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn">update</a>
        <a href="admin_products.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn"
          onclick="return confirm('delete this product?')">delete</a>
      </div>
      <?php
        }
      } else {
        echo '<p class="empty">no product added yet!</p>';
      }

      ?>
    </div>
  </section>

  <section class="edit-product-form">
    <?php

    if (isset($_GET['update'])) {
      $update_id = $_GET['update'];
      $update_query = mysqli_query($conn, "SELECT * FROM `products` WHERE
      id = '$update_id'") or die('query failed');
      if (mysqli_num_rows($update_query) > 0) {
        while ($fetch_update = mysqli_fetch_assoc($update_query)) {
    ?>
    <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
      <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
      <img src="uploaded_img/<?php echo $fetch_update['image'] ?>" alt="">

      <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required
        placeholder="enter product name">
      <select name="update_category" class="box">
        <option value="1" <?= $fetch_update['category_id'] == '1' ? 'selected' : '' ?>>history</option>
        <option value="2" <?= $fetch_update['category_id'] == '2' ? 'selected' : '' ?>>comic</option>
        <option value="3" <?= $fetch_update['category_id'] == '3' ? 'selected' : '' ?>>self-help</option>
        <option value="4" <?= $fetch_update['category_id'] == '4' ? 'selected' : '' ?>>
          science-fiction</option>
        <option value="5" <?= $fetch_update['category_id'] == '5' ? 'selected' : '' ?>>business</option>
        <option value="6" <?= $fetch_update['category_id'] == '6' ? 'selected' : '' ?>>horror</option>
        <option value="7" <?= $fetch_update['category_id'] == '7' ? 'selected' : '' ?>>romance</option>
      </select>
      <input type="number" name="update_price" value="<?php echo $fetch_update['price']; ?>" min="0" class="box"
        required placeholder="enter product price">
      <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
      <input type="submit" value="update" name="update_product" class="btn">
      <input type="reset" value="cancel" id="close_update" class="option-btn">
    </form>

    <?php
        }
      }
    } else {
      echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
    }
    ?>
  </section>


  <!-- admin js file  -->
  <script src=" js/admin_script.js"></script>
</body>


</html>