<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>도서 대여</title>
</head>
<body>

<?php
include '../session.php';
?>

<div class="form-container">
  <form name='review_table' method='post' onsubmit="return checkform();">
    <b>도서 대여</b><br><br>
    <label>도서 번호: </label><input type="text" name="b_num" class="box" />
    <input type="submit" value="검색" />
  </form>
  <div id="searchResults"></div> <!-- 검색 결과 표시할 영역 -->
</div>

<script>
function checkform() {
  var userLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
  if (!userLoggedIn) {
    alert('회원만 대여가 가능합니다.');
    window.location.href = '../member/login_form.php'; // 사용자를 로그인 페이지로 리다이렉션
    return false;
  }

  var input = document.review_table.b_num;
  if (!input.value) {
    alert('도서번호가 입력되지 않았습니다.');
    input.focus();
    return false; // 폼 제출 중단
  }

  // AJAX 요청 생성 및 전송
  var xhr = new XMLHttpRequest();
  xhr.open('POST', './checkout_search.php', true);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhr.onload = function() {
    if (this.status == 200) {
      document.getElementById('searchResults').innerHTML = this.responseText;
    } else {
      document.getElementById('searchResults').innerHTML = 'Error loading results.';
    }
  };
  xhr.send('b_num=' + encodeURIComponent(input.value));
  return false; // 폼이 실제로 제출되는 것을 방지
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
    h2.title a {
      text-decoration: none;
      color: inherit;
    }
    .form-container {
      text-align: center;
      margin-top: 50px;
    }
    .form-container b {
      font-size: 24px;
      color: #333;
    }
    .form-container form {
      margin-top: 20px;
    }
    .form-container input[type="text"] {
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
      width: 300px;
      font-size: 16px;
    }
    .form-container input[type="submit"] {
      padding: 10px 20px;
      border: none;
      background-color: #5C67F2;
      color: white;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
    }
    .form-container input[type="submit"]:hover {
      background-color: #6e7bff;
    }
    #searchResults {
      margin-top: 20px;
      text-align: center;
    }
    .search-results {
      display: inline-block;
      text-align: left;
    }
    .search-results table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    .search-results th, .search-results td {
      padding: 10px;
      border: 1px solid #ddd;
    }
    .search-results th {
      background-color: #5C67F2;
      color: white;
    }
  </style>
</body>
</html>
