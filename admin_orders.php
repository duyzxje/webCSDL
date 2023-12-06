<?php
include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
  header('location:login.php');
}

if (isset($_POST['update_order'])) {

  $order_update_id = $_POST['order_id'];
  $update_payment = $_POST['update_payment'];
  mysqli_query($conn, "UPDATE `orders` SET payment_status = 
  '$update_payment' WHERE id = '$order_update_id' ") or die('query failed');
  $message[] = 'payment status has been updated';
}

if (isset($_GET['delete'])) {
  $delete_id = $_GET['delete'];
  mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'")
    or die('query failed');
  header('location:admin_orders.php');
}

function findStreet($str) // $town
{

  global $conn;
  $select_address1 = mysqli_query($conn, "SELECT * FROM `orders`")  or die('query failed');

  if (mysqli_num_rows($select_address1) > 0) {
    while ($fetch_address = mysqli_fetch_assoc($select_address1)) {
      // echo var_dump($fetch_address['address']);
      if ((strpos($fetch_address['address'], $str)) !== false) {
        // echo 'NAISU';
        return true;
      }
    }
  }
  // echo 'NOOOOOOOOOOOOOOOO';
  return false;
};

function findTown($str) // $town
{

  global $conn;
  $select_address2 = mysqli_query($conn, "SELECT * FROM `orders`")  or die('query failed');

  if (mysqli_num_rows($select_address2) > 0) {
    while ($fetch_address = mysqli_fetch_assoc($select_address2)) {
      // echo var_dump($fetch_address['address']);
      if ((strpos($fetch_address['address'], $str)) !== false) {
        // echo 'NAISU';
        return true;
      }
    }
  }
  // echo 'NOOOOOOOOOOOOOOOO';
  return false;
};


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>orders</title>
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" -->
  <!-- integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous"> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <link rel="stylesheet" href="css/admin_style.css">

</head>

<body>
  <?php
  include 'admin_header.php';
  ?>

  <section class="orders">

    <h1 class="title">placed orders</h1>

    <div class="card-body">
      <form action="" method="post">


        <label>From Date:</label>
        <input type="date" name="from_date" class="form-control">



        <label>To Date:</label>
        <input type="date" name="to_date" class="form-control">

        <label>Status:</label>
        <select name="status">
          <option value="" selected></option>
          <option value="pending">pending</option>
          <option value="completed">completed</option>
        </select>

        <label>
          Street:
        </label>
        <input name="street" type="text">

        <label>
          District:
        </label>
        <input name="district" type="text">

        <!-- <label>Click to Filter</label> -->
        <button name="submit_filter" type="submit" class="btn btn-filter">Filter</button>


      </form>
    </div>


    <div class="box-container">
      <?php
      if (isset($_POST['submit_filter'])) {
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $status = $_POST['status'];
        $street = $_POST['street'];
        // var_dump($street);
        $district = $_POST['district'];



        if ($from_date != "" && $to_date != "" && $status != "") {
          $select_orders = mysqli_query($conn, "SELECT * FROM `orders` WHERE payment_status	= '$status' AND placed_on BETWEEN '$from_date' AND ' $to_date'")  or die('query failed');;
        } else if ($from_date != "" && $to_date != "") {
          $select_orders = mysqli_query($conn, "SELECT * FROM `orders` WHERE placed_on BETWEEN '$from_date' AND ' $to_date'")  or die('query failed');;
        } else if ($status != "") {
          $select_orders = mysqli_query($conn, "SELECT * FROM `orders` WHERE payment_status	= '$status'")  or die('query failed');
        } else if (findStreet($street) == true && $street != "" && findTown($district) == true && $district != "") {
          $select_orders =  mysqli_query($conn, "SELECT * FROM `orders` WHERE address LIKE '%$street%$district%' ")  or die('query failed');
        } else if (findStreet($street) == true && $street != "") {
          $select_orders =  mysqli_query($conn, "SELECT * FROM `orders` WHERE address LIKE '%$street%' ")  or die('query failed');
        } else if (findTown($district) == true && $district != "") {
          $select_orders =  mysqli_query($conn, "SELECT * FROM `orders` WHERE address LIKE '%$district%' ")  or die('query failed');
        } else {
          $select_orders = mysqli_query($conn, "SELECT * FROM `orders`")  or die('query failed');
        }
      } else {
        $select_orders = mysqli_query($conn, "SELECT * FROM `orders`")  or die('query failed');
      }




      if (mysqli_num_rows($select_orders) > 0) {
        while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
      ?>
          <div class="box">
            <p>user id : <span><?php echo $fetch_orders['user_id'] ?></span></p>
            <p>placed on : <span><?php echo $fetch_orders['placed_on'] ?></span></p>
            <p>name : <span><?php echo $fetch_orders['name'] ?></span></p>
            <p>number : <span><?php echo $fetch_orders['number'] ?></span></p>
            <p>email : <span><?php echo $fetch_orders['email'] ?></span></p>
            <p>address : <span><?php echo $fetch_orders['address'] ?></span></p>
            <p>total products : <span><?php echo $fetch_orders['total_products'] ?></span></p>
            <p>total price : <span><?php echo $fetch_orders['total_price'] ?></span></p>
            <p>payment method : <span><?php echo $fetch_orders['method'] ?></span></p>
            <form action="" method="post">
              <input type="hidden" name="order_id" value="<?php echo
                                                          $fetch_orders['id'] ?>">
              <select name="update_payment">
                <option value="" selected disabled><?php echo
                                                    $fetch_orders['payment_status'] ?></option>
                <option value="pending">pending</option>
                <option value="completed">completed</option>
              </select>
              <input type="submit" value="update" name="update_order" class="option-btn">
              <a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" onclick="return confirm('delete this order?');" class="delete-btn">
                delete</a>
            </form>
          </div>
      <?php
        }
      } else {
        echo '<p class="empty">no orders placed yet!</p>';
      }
      ?>
    </div>
  </section>

  <!-- admin js file  -->
  <script src="js/admin_script.js"></script>
</body>


</html>