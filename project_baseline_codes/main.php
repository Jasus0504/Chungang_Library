<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<html>
<head>
  <title>지식 도서관</title>
  <link rel="stylesheet" type="text/css" href="style.css"> <!-- 스타일시트 연결 -->
</head>
<body>

<?php
include './session.php';
?>
<div class="center">
  <h2 class="title">지식 도서관</h2>
  <form action='./post.php' name='review_table' method='post'>
    <?php if (isset($_SESSION['user_id'])): ?>
        <input type="button" class="btn" value="로그아웃" onclick="goLogout();"/>
    <?php else: ?>
        <input type="button" class="btn" value="회원가입" onclick="addmember();"/>
        <input type="button" class="btn" value="로그인" onclick="goLoginform();"/>
    <?php endif; ?>

    <!-- 일반 사용자에게만 보여주는 버튼 -->
    <?php if (!isset($userAuthority) || $userAuthority !== 'admin'): ?>
        <input type="button" class="btn" value="대여하기" onclick="bookcheckout();"/>
        <input type="button" class="btn" value="반납하기" onclick="bookcheckin();"/>
        <input type="button" class="btn" value="도서 목록" onclick="ubooklist();"/>
    <?php endif; ?>

    <!-- 관리자에게만 보여주는 버튼 -->
    <?php if (isset($userAuthority) && $userAuthority === 'admin'): ?>
        <input type="button" class="btn" value="신규 도서 추가" onclick="addbook();"/>
        <input type="button" class="btn" value="도서 목록 보기" onclick="booklist();"/>
        <input type="button" class="btn" value="회원 목록 보기" onclick="memberlist();"/>
    <?php endif; ?>
  </form>
</div>


  <ul>
    <?php
    include './dbconn.php';  // 데이터베이스 연결
    include './main_sidebar.php';  
    ?>
  </ul>


<div class="map-container">
  <img src="./Images/book_map.png" alt="Library Map" class="library-map">
</div>

<script>

  function goLoginform() {
    location.href='./member/login_form.php';
  }

  function goLogout() {
    location.href='./member/logout.php';
  }

  function addbook() {
    location.href='./book/b_insert.php';
  }

  function booklist() {
    location.href='./book/b_selectAll.php';
  }

  function ubooklist() {
    location.href='./book/ub_selectAll.php';
  }

  function addmember() {
    location.href='./member/m_insert.php';
  }

  function memberlist() {
    location.href='./member/m_selectAll.php';
  }

  function bookcheckout() {
    <?php
      if (isset($_SESSION['user_id'])) {
        echo 'location.href="./book/b_checkout.php";';  // 로그인 상태면 대여 페이지로 이동
      } else {
        echo 'alert("로그인인 후 대여가 가능합니다.");';  // 로그인 상태가 아니면 경고 메시지 출력
      }
    ?>
  }

  function bookcheckin() {
    location.href='./book/b_checkinList.php';
  }

</script>

<style>
  body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
  }
  .center {
    text-align: center;
    margin-top: 50px;
  }
  .title {
    color: #333;
  }
  .btn {
    padding: 10px 20px;
    margin: 10px;
    border: none;
    background-color: #5C67F2;
    color: white;
    border-radius: 5px;
    cursor: pointer;
  }
  .btn:hover {
    background-color: #6e7bff;
  }
  .sidebar {
    margin-top: 20px;
  }
  .map-container {
    text-align: center;
    margin-top: 20px;
  }
  .library-map {
    max-width: 30%;
    height: auto;
    border: 1px solid #ccc;
    border-radius: 10px;
  }
</style>

</body>
</html>
