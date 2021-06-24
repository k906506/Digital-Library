<?php
session_start();
?>
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
    <style>
        .container {
            margin: auto;
        }
    </style>
</head>
<body>
<?php
if (isset($_SESSION['userCno'])) { // 세션이 있는 경우
    ?>
    <div class="container" style="text-align: right">
        <div class="nav-item" style="margin-top : 10px;">
            <a class="nav-link active" aria-current="page" onclick="logout()">로그아웃</a>
        </div>
    </div>
    <div class="container">
        <h1 style="margin-top:30px; margin-left:30px;"><b>전자 도서관</b></h1><br>
        <div style="text-align: center;">
            <p><a class="btn btn-primary pull-center" href="secondMain.php" role="button">통합 시스템 바로가기</a>
            </p>
        </div>
    </div>
    <?php
} else {
    ?>
    <div class="container" style="text-align: right">
        <li class="nav-item" style="margin-top : 10px; float:right; list-style:none;">
            <a class="nav-link active" aria-current="page" href="signup.php">회원가입</a>
        </li>
        <li class="nav-item" style="margin-top : 10px; float:right; list-style:none;">
            <a class="nav-link" href="login.php">로그인</a>
        </li>
    </div>
    <div class="container" style="clear : right">
        <h1 style="margin-bottom: 100px"><b>전자 도서관</b></h1><br>
    </div>
    <div class="container" style="text-align: center">
        <h4><b>전자 도서관을 이용하시려면</b></h4><br>
        <h4><b>로그인부터 해주세요</b></h4><br>
    </div>
    <?php
}
?>

<script>
    function logout() {
        const data = confirm("로그아웃 하시겠습니까?");
        if (data) {
            location.href = "processOfLogout.php";
        }
    }
</script>
</body>
</html>