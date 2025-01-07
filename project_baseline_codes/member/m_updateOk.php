<?php

//    error_reporting(E_ALL);
//    ini_set("display_errors", 1);

    include '../dbconn.php';

    $uid=$_GET['id'];
    $userid=$_POST['custid'];
    $userpwd=$_POST['custpwd'];
    $username=$_POST['custname'];
    $userage=$_POST['custage'];

    $sql="UPDATE info SET id = '$userid', pwd = '$userpwd', name = '$username', age = '$userage' where id = '$uid'";
    mysqli_query($con, $sql);

    echo"
    <script>
    location.href='../main.php';
    </script>
    ";

 ?>
