<?php

//    error_reporting(E_ALL);
//    ini_set("display_errors", 1);

    include '../dbconn.php';

    $b_num=$_GET['b_num'];
    $b_name=$_POST['cb_name'];
    $b_author=$_POST['cb_author'];
    $b_genre=$_POST['cb_genre'];
    $b_location=$_POST['cb_location'];

    $sql="UPDATE book_list SET b_name = '$b_name', b_author = '$b_author',
     b_genre = '$b_genre', b_location = 'b_location' where b_num = '$b_num'";
    mysqli_query($con, $sql);

    echo"
    <script>
    location.href='../main.php';
    </script>
    ";

 ?>
