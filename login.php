; 로그인 파라미터 확인

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css"
          integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js"
            integrity="sha384-BOsAfwzjNJHrJ8cZidOg56tcQWfp6y72vEJ8xQ9w6Quywb24iOsW913URv1IS4GD"
            crossorigin="anonymous"></script>
</head>

<body>
<form method="POST" action="processOfLogin.php" id="login-form">
    <div class="w-50 ml-auto mr-auto mt-5">
        <div class="mb-3 ">
            <label for="exampleFormControlInput1" class="form-label">아이디 (이메일 형식)</label>
            <input name="email" type="text" class="form-control" id="email"
                   placeholder="아이디를 입력해주세요.">
        </div>
        <div class="mb-3 ">
            <label for="exampleFormControlInput1" class="form-label">비밀번호</label>
            <input name="password" type="password" class="form-control" id="password"
                   placeholder="비밀번호를 입력해주세요.">
        </div>
        <button type="button" id="login-button" class="btn btn-primary mb-3">로그인</button>
    </div>
</form>
<script>
    const loginForm = document.querySelector("#login-form");
    const loginButton = document.querySelector("#login-button");
    const email = document.querySelector('#email');
    const password = document.querySelector("#password");
    loginButton.addEventListener("click", function (e) {
        if (!email.value || !password.value) { // 두 개의 인자 값 중 하나라도 비어있으면 false
            alert("공백을 허용하지 않습니다. 모든 정보를 입력해주세요!")
        } else {
            loginForm.submit();
        }
    });
</script>
</body>
</html>