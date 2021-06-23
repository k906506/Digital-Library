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
<h1 style = "margin-top:30px; margin-left:30px;"><b>전자 도서관</b></h1><br>
<h3 style = "text-align: center"><b>통합 시스템</b></h3>
<div style="text-align: center;">
    <form method="POST" action="processOfSearchBook.php" id="search-form">
        <div class="w-50 ml-auto mr-auto mt-5 mb-5">
            <div style="margin-bottom : 10px;">
                <h6><b>검색 / 대출 / 예약</b></h6>
            </div>
            <input type="text" name="search" size="50%" placeholder="도서명을 입력해주세요.">
            <button id="search-button" class="btn btn-primary">조회</button>
        </div>
    </form>
    <div class="w-50 ml-auto mr-auto mt-5">
        <div class="mb-3">
            <button id="return-button" class="btn btn-primary mb-3">반납</button>
        </div>
    </div>
</div>

<script>
    const searchForm = document.querySelector("#search-form");
    const searchButton = document.querySelector("#search-button");
    const returnButton = document.querySelector("#return-button");
    const bookName = document.querySelector('#bookName');
    searchButton.addEventListener("click", function (e) {
        if (!bookName.value) { // 두 개의 인자 값 중 하나라도 비어있으면 false
            alert("공백을 허용하지 않습니다. 모든 정보를 입력해주세요!")
        } else {
            searchForm.submit();
        }
    });
    returnButton.addEventListener("click", function (e) {
        location.href = "processOfReturnBook.php";
    });
</script>
</body>
</html>