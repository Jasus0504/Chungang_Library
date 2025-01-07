<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<html>
<head>
  <title>로그인</title>
</head>
<body>
  <div class="center">
    <div class="form-container">
      <h2>로그인</h2>
      <form action='./login.php' name='login_form' method='post'>
        <label>아이디 :</label>
        <input type="text" name="user_id" class="box"/>
        <label>비밀번호 :</label>
        <input type="password" name="user_password" class="box"/>
        <input type="button" value="로그인" onclick="checkform();"/>
      </form>
    </div>
  </div>

  <script>
    function checkform() {
      if (!document.login_form.user_id.value) {
        alert('아이디가 입력되지 않았습니다.');
        document.login_form.user_id.focus();
        return;
      } else if (!document.login_form.user_password.value) {
        alert('비밀번호가 입력되지 않았습니다.');
        document.login_form.user_password.focus();
        return;
      }

      document.login_form.submit();
    }
  </script>
</body>
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
  .form-container label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
  }
  .form-container input[type="text"],
  .form-container input[type="password"] {
    width: 100%;
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
</style>
</html>
