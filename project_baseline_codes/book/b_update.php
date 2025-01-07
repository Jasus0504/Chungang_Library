
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php

    include '../dbconn.php';

    $cb_num=$_GET['b_num'];

    $sql="SELECT * FROM book_list where b_num = '$cb_num'";
    //echo $query;
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result)

?>

    <center><h2> 도서정보 </h2></center>
    <form name="frm_content" method="post" action="b_updateOk.php?b_num=<?php echo $cb_num; ?>">
      <table align="center" width= "300" border="1" cellspacing="0" cellpadding="5">
      <tr align="center">
        <td bgcolor="#cccccc">도서번호</td>
        <td><input type="text" name="cb_num" value="<?php echo $row['b_num']; ?>"></td>
      </tr>
      <tr align="center">
        <td bgcolor="#cccccc">제목</td>
        <td><input type="text" name="cb_name" value="<?php echo $row['b_name']; ?>"></td>
      </tr>
      <tr align="center">
        <td bgcolor="#cccccc">작가</td>
        <td><input type="text" name="cb_author" value="<?php echo $row['b_author']; ?>"></td>
      </tr>
      <tr align="center">
        <td bgcolor="#cccccc">장르</td>
        <td><input type="text" name="cb_genre" value="<?php echo $row['b_genre']; ?>"></td>
      </tr>
      <tr align="center">
        <td bgcolor="#cccccc">위치</td>
        <td><input type="text" name="cb_location" value="<?php echo $row['b_location']; ?>"></td>
      </tr>
      <tr align="center">
        <td colspan="2" bgcolor="#cccccc">
            <input type="submit" value="수정">
        </td>
      </tr>
    </form>
