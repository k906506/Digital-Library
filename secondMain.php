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
<div class="container" style="text-align: right">
    <div class="nav-item" style="margin-top : 10px;">
        <a class="nav-link active" aria-current="page" onclick="logout()">로그아웃</a>
    </div>
</div>
<div class="container">
    <h1 style="margin-top:30px; margin-left:30px;"><b>전자 도서관</b></h1><br>
</div>
<h3 style="text-align: center"><b>통합 시스템</b></h3>
<div style="text-align: center;">
    <div class="w-50 ml-auto mr-auto mt-5 mb-5">
        <div style="margin-bottom : 10px;">
            <h6><b>검색 / 대출 / 예약</b></h6>
        </div>
        <div id="search_box" style="text-align: center;">
            <form action="processOfSearchBook.php" method="get">
                <select name="category">
                    <option value="title">제목</option>
                    <option value="name">저자</option>
                    <option value="publisher">출판사</option>
                    <option value="year">발행연도</option>
                </select>
                <input type="text" name="search" size="50%" required="required" placeholder="검색어를 입력해주세요.">
                <button class="btn btn-primary">조회</button>
            </form>
        </div>
    </div>
    <div class="w-50 ml-auto mr-auto mt-5">
        <div class="mb-3">
            <button id="return-button" class="btn btn-primary mb-3">반납하기</button>
            <button id="reservation-button" class="btn btn-primary mb-3">예약 조회</button>
        </div>
    </div>
</div>

<script>
    const searchForm = document.querySelector("#search-form");
    const searchButton = document.querySelector("#search-button");
    const returnButton = document.querySelector("#return-button");
    const reservationButton = document.querySelector("#reservation-button");
    const bookName = document.querySelector('#bookName');

    returnButton.addEventListener("click", function (e) {
        location.href = "processOfReturnBook.php";
    });

    reservationButton.addEventListener("click", function (e) {
        location.href = "processOfSearchReservation.php";
    });

    function logout() {
        const data = confirm("로그아웃 하시겠습니까?");
        if (data) {
            location.href = "processOfLogout.php";
        }
    }
</script>
</script>
</body>
</html>