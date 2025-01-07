<!DOCTYPE html>
<html lang="ko">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>DB 입출력 테스트</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
  <div class="center">
    <div class="form-container">
      <h2>DB 입출력 테스트</h2>
      <form action='./m_insertOk.php' name='review_table' method='post'>
        <label>아이디 :</label>
        <div class="input-group">
          <input type="text" name="custom_id" class="box"/>
          <button type="button" onclick="checkId()">ID 체크</button>
        </div>
        <label>비번 :</label>
        <input type="password" name="custom_pwd" class="box"/>
        <label>이름 :</label>
        <input type="text" name="custom_name" class="box"/>
        <label>나이 :</label>
        <input type="text" name="custom_age" class="box"/>
        <label>전화번호 :</label>
        <input type="text" name="custom_number" class="box"/>
        <div class="gender-group">
          <label>성별 :</label>
          <label>
            <input type="radio" name="custom_gender" value="male"> 남자
          </label>
          <label>
            <input type="radio" name="custom_gender" value="female"> 여자
          </label>
        </div>
        <input type="button" value="회원가입" OnClick="checkform();"/>
      </form>
    </div>
  </div>

  <script>
    var isIdChecked = false;  // 아이디 중복 검사 성공 여부를 추적하는 전역 변수

    function checkId() {
      var custom_id = document.review_table.custom_id.value;
      if (!custom_id) {
        alert('아이디가 입력되지 않았습니다.');
        document.review_table.custom_id.focus();
        return;
      }

      // AJAX 요청을 사용하여 ID 중복 검사 수행
      $.ajax({
        url: 'check_id.php',  // ID 중복 검사를 수행할 서버의 URL
        type: 'POST',
        data: { 'id': custom_id },
        success: function(response) {
          if(response == 'ok') {
            alert('사용가능한 아이디입니다.');
            document.review_table.custom_id.readOnly = true;  // 아이디 필드를 읽기 전용으로 설정
            isIdChecked = true;  // 아이디 검사가 성공했음을 표시
          } else {
            alert('이미 사용중인 아이디입니다.');
            isIdChecked = false;  // 실패 상태 업데이트
          }
        },
        error: function() {
          alert('ID 중복 검사에 실패했습니다. 다시 시도해 주세요.');
          isIdChecked = false;  // 에러 상태 업데이트
        }
      });
    }

    function checkform() {
      if (!isIdChecked) {
          alert('아이디 중복 검사를 완료해주세요.');
          return false;
      }
      var custom_id = document.review_table.custom_id.value;
      if (!custom_id) {
          alert('아이디가 입력되지 않았습니다.');
          document.review_table.custom_id.focus();
          return false;
      }
      if (custom_id.length > 10) {
          alert('아이디는 10글자 이하로 입력해주세요.');
          document.review_table.custom_id.focus();
          return false;
      }

      var custom_pwd = document.review_table.custom_pwd.value;
      if (!custom_pwd) {
          alert('비밀번호가 입력되지 않았습니다.');
          document.review_table.custom_pwd.focus();
          return false;
      }
      if (custom_pwd.length > 15) {
          alert('비밀번호는 15글자 이하로 입력해주세요.');
          document.review_table.custom_pwd.focus();
          return false;
      }

      var custom_name = document.review_table.custom_name.value;
      if (!custom_name) {
          alert('이름이 입력되지 않았습니다.');
          document.review_table.custom_name.focus();
          return false;
      }
      if (custom_name.length > 7) {
          alert('이름은 7글자 이하로 입력해주세요.');
          document.review_table.custom_name.focus();
          return false;
      }

      var age = document.review_table.custom_age.value;
      if (!age || isNaN(age)) {
          alert('나이는 숫자만 입력 가능합니다.');
          document.review_table.custom_age.focus();
          return false;
      }
      if (parseInt(age) > 150) {
          alert('나이는 150세 이하로 입력해주세요.');
          document.review_table.custom_age.focus();
          return false;
      }

      var custom_number = document.review_table.custom_number.value;
      if (!custom_number || isNaN(custom_number)) {
          alert('전화번호는 숫자만 입력 가능합니다.');
          document.review_table.custom_number.focus();
          return false;
      }
      if (custom_number.length > 11) {
          alert('전화번호는 11자리 이하로 입력해주세요.');
          document.review_table.custom_number.focus();
          return false;
      }

      // 모든 검사가 통과되면 폼을 제출합니다.
      document.review_table.submit();
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
      width: 400px;
      margin: 0 auto;
      background: #fff;
      padding: 20px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      border-radius: 10px;
    }
    .form-container label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
    }
    .input-group {
      margin-bottom: 10px;
      display: flex;
      align-items: center;
    }
    .input-group input[type="text"],
    .input-group input[type="password"] {
      flex: 1;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
      margin-right: 10px;
    }
    .input-group button {
      padding: 10px;
      background-color: #5C67F2;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .input-group button:hover {
      background-color: #6e7bff;
    }
    .gender-group {
      display: flex;
      align-items: center;
    }
    .gender-group label {
      margin-right: 20px;
    }
    .gender-group input[type="radio"] {
      margin-right: 5px;
    }
    .form-container input[type="text"],
    .form-container input[type="password"],
    .form-container input[type="radio"] {
      width: calc(100% - 22px);
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }
    .form-container input[type="button"] {
      width: 100%;
      padding: 10px;
      border: none;
      background-color: #5C67F2;
      color: white;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
    }
    .form-container input[type="button"]:hover {
      background-color: #6e7bff;
    }
    .success-message {
      color: green;
      font-weight: bold;
      margin-bottom: 20px;
    }
    .error-message {
      color: red;
      font-weight: bold;
      margin-bottom: 20px;
    }
  </style>
</body>
</html>
