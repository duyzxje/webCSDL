<?php
include 'config.php';
session_start(); // khởi tạo  session
session_unset(); //loại bỏ tất cả các biến session
session_destroy(); //phá hủy session

header('location:login.php');