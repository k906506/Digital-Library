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
// 세션 시작
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
// 실행
$conn = oci_connect('d201701971', "rhehgus1019", $dsn); // DB와 연동
$reservationSql = "SELECT E.ISBN, E.TITLE, PR.DATERENTED, PR.DATERETURNED, E.EXTTIMES FROM EBOOK E INNER JOIN PREVIOUSRENTAL PR ON (E.ISBN = PR.ISBN) WHERE PR.CNO = '{$_SESSION['userCno']}' ORDER BY PR.DATERETURNED";
$resultSql = oci_parse($conn, $reservationSql);
oci_execute($resultSql);

$data = array();

while ($row = oci_fetch_row($resultSql)) {
    $data[] = [$row[0], $row[1], $row[2], $row[3], $row[4]];
}

$countReservation = sizeof($data); // 쿼리문 실행 결과의 크기

oci_free_statement($resultSql); // 메모리 반환

$findNameSql = "SELECT NAME FROM CUSTOMER WHERE CNO ='{$_SESSION['userCno']}'";
$resultSql = oci_parse($conn, $findNameSql);
oci_execute($resultSql);

$storedInfo = oci_fetch_array($resultSql); // 쿼리문 실행 결과
$userName = $storedInfo[0]; // 사용자 이름

oci_free_statement($resultSql); // 메모리 반환
oci_close($conn); // 오라클 종료
?>

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
        <h1><b> ".$userName." 대출 기록</b></h1><br>
        <table class="table table-striped" style="text-align: center; border: 1px solid #ddddda">
            <tr>
                <th style="background-color: #eeeeee; text-align: center;">ISBN</th>
                <th style="background-color: #eeeeee; text-align: center;">책 제목</th>
                <th style="background-color: #eeeeee; text-align: center;">대여 일자</th>
                <th style="background-color: #eeeeee; text-align: center;">반납 일자</th>
                <th style="background-color: #eeeeee; text-align: center;">반납일 연장</th>
                <th style="background-color: #eeeeee; text-align: center;">반납</th>
            </tr>
            <?php
            for ($i = 0; $i < $countReservation; $i++) {
                ?>
                <!-- 글 목록 가져오기 -->
                <tbody>
                <tr style="vertical-align: middle">
                    <td width="70"><?= $data[$i][0]; ?></td>
                    <td width="200"><?= $data[$i][1]; ?></td>
                    <td width="100"><?= $data[$i][2]; ?></td>
                    <td width="100"><?= $data[$i][3]; ?></td>
                    <td width="100">
                        <button type="button" id="extension-button" class="btn btn-primary m-10">연장</button>
                    </td>
                    <td width="100">
                        <button type="button" id="return-button" class="btn btn-primary">반납</button>
                    </td>
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

