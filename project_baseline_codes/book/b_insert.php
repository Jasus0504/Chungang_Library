<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!DOCTYPE html>
<html lang="en">
<head>
  <title>신규 도서 추가</title>
</head>
<body>
  <div class="center">
    <div class="form-container">
      <h2>신규 도서 추가</h2>
      <form action='./b_insertOk.php' name='b_insertOk' method='post' enctype="multipart/form-data">
        <label>도서 이름 :</label>
        <input type="text" name="b_name" class="box"/><br />
        <label>도서 작가 :</label>
        <input type="text" name="b_author" class="box"/><br />
        <label>장르 :</label>
        <select name="b_genre" class="box" required>
          <option value="">--장르 선택--</option>
          <option value="fantasy">판타지</option>
          <option value="sci-fi">과학 소설 (SF)</option>
          <option value="mystery">미스터리</option>
          <option value="thriller">스릴러</option>
          <option value="romance">로맨스</option>
          <option value="nonfiction">논픽션</option>
          <option value="comedy">코미디</option>
          <option value="horror">호러</option>
          <option value="historical">역사</option>
          <option value="personalwriting">수필</option>
        </select><br />
        <label>위치 :</label>
        <select name="b_location" class="box" required>
          <option value="">--위치 선택--</option>
          <option value="A">브랜드책방(A)</option>
          <option value="B">외국어(B)</option>
          <option value="C1">여행,취미</option>
          <option value="C2">예술</option>
          <option value="D">기술,과학,건강</option>
          <option value="E1">경영,자기개발</option>
          <option value="E2">경제,정치사회</option>
          <option value="E3">취업,수험서</option>
          <option value="F1">인문,역사,문화</option>
          <option value="F2">종교</option>
          <option value="G1">소설</option>
          <option value="G2">만화,잡지,청소년</option>
          <option value="G3">시,에세이</option>
        </select><br />
        <input type="file" name="b_image" required><br>
        <input type="submit" value="추가하기" onclick="submitbook();" />
      </form>
    </div>
  </div>

  <script>
    function submitbook() {
      if (!document.forms['b_insertOk'].b_name.value) {
        alert('도서 이름이 입력되지 않았습니다.');
        document.forms['b_insertOk'].b_name.focus();
        return false;
      }
      if (!document.forms['b_insertOk'].b_genre.value) {
        alert('도서 장르가 입력되지 않았습니다.');
        document.forms['b_insertOk'].b_genre.focus();
        return false;
      }
      if (!document.forms['b_insertOk'].b_location.value) {
        alert('도서 위치가 입력되지 않았습니다.');
        document.forms['b_insertOk'].b_location.focus();
        return false;
      }
      alert('입력이 완료되었습니다.');
      document.forms['b_insertOk'].submit();
      return true;
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
    .form-container {
      width: 300px;
      margin: 0 auto;
      background: #fff;
      padding: 20px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      border-radius: 10px;
    }
    .form-container h2 {
      margin-bottom: 20px;
      font-size: 24px;
      color: #333;
    }
    .form-container label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
    }
    .form-container input[type="text"],
    .form-container select,
    .form-container input[type="file"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }
    .form-container input[type="submit"] {
      width: 100%;
      padding: 10px;
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
  </style>
</body>
</html>
