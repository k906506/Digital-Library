<?php
// 인코딩
putenv("NLS_LANG=KOREAN_KOREA.UTF8");

// C:\Windows\System32\drivers\etc 에서 확인 가능
$dsn = "
(DESCRIPTION=
(ADDRESS_LIST= (ADDRESS=(PROTOCOL=TCP)(HOST=127.0.0.1)(PORT=1521))) 
(CONNECT_DATA= (SERVICE_NAME=XE))
)
";

session_start();

// 실행
$conn = oci_connect('d201701971', "rhehgus1019", $dsn); // DB와 연동
$category = $_GET["category"];
$search = $_GET["search"];
?>
<!DOCTYPE html>
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
<div class="container" style="text-align: right">
    <div class="nav-item" style="margin-top : 10px;">
        <a class="nav-link active" aria-current="page" onclick="logout()">로그아웃</a>
    </div>
</div>
<div class="container">
    <h1 style="margin-top:30px; margin-left:30px;"><b>전자 도서관</b></h1><br>
</div>
<div class="container">
    <div id="board_area">
        <!-- 어떤 검색 카테고리로 들어왔는지 확인하기 위한 조건문 -->
        <?php
        if ($category == 'title') {
            $keyword = '제목';
            $type = 'TITLE';
        } else if ($category == 'name') {
            $keyword = '저자';
            $type = 'AUTHORS.AUTHOR';
        } else if ($category == 'publisher') {
            $keyword = '출판사';
            $type = 'PUBLISHER';
        } else {
            $keyword = '발행연도';
            $type = 'YEAR';
        }
        ?>
        <h3 style="text-align: center">'<b><?= $keyword ?></b>'에서 '<b><?= $search ?></b>' 검색결과</h3><br>
        <table class="table table-striped" style="text-align: center; border: 1px solid #ddddda">
            <tr>
                <th style="background-color: #eeeeee; text-align: center;">ISBN</th>
                <th style="background-color: #eeeeee; text-align: center;">제목</th>
                <th style="background-color: #eeeeee; text-align: center;">저자</th>
                <th style="background-color: #eeeeee; text-align: center;">출판사</th>
                <th style="background-color: #eeeeee; text-align: center;">발행연도</th>
                <th style="background-color: #eeeeee; text-align: center;">대여</th>
                <th style="background-color: #eeeeee; text-align: center;">예약</th>
            </tr>
            <!-- 검색한 결과 페이징 구현 -->
            <?php
            $sql = "SELECT EBOOK.ISBN, TITLE, AUTHORS.AUTHOR, PUBLISHER, YEAR FROM EBOOK INNER JOIN AUTHORS ON (AUTHORS.ISBN = EBOOK.ISBN) WHERE {$type} LIKE '%{$search}%'";
            $resultSql = oci_parse($conn, $sql);
            oci_execute($resultSql);

            $data = array();
            while ($row = oci_fetch_row($resultSql)) {
                $data[] = [$row[0], $row[1], $row[2], $row[3], $row[4]];
            }

            $countReservation = sizeof($data); // 쿼리문 실행 결과의 크기
            for ($i = 0; $i < $countReservation; $i++) {
                ?>
                <!-- 글 목록 가져오기 -->
                <tbody>
                <tr style="vertical-align: middle">
                    <td width="70"><?= $data[$i][0]; ?></td>
                    <td width="200"><?= $data[$i][1]; ?></td>
                    <td width="100"><?= $data[$i][2]; ?></td>
                    <td width="100"><?= $data[$i][3]; ?></td>
                    <td width="100"><?= $data[$i][4]; ?></td>
                    <td width ="100"><a href="processOfBorrowBook.php?isbn=<?= $data[$i][0] ?>">대여</a></td>
                    <td width ="100"><a href="processOfReservation.php?isbn=<?= $data[$i][0] ?>">예약</a></td>
                </tr>
                </tbody>
            <?php } ?>
        </table>
    </div>
</div>
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