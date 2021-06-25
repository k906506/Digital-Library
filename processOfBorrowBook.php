<?php
// 인코딩
putenv("NLS_LANG=KOREAN_KOREA.UTF8");

// HOST 값은 C:\Windows\System32\drivers\etc 에서 확인 가능
$dsn = "
(DESCRIPTION=
(ADDRESS_LIST= (ADDRESS=(PROTOCOL=TCP)(HOST=127.0.0.1)(PORT=1521))) 
(CONNECT_DATA= (SERVICE_NAME=XE))
)
";
session_start();

// 실행
$conn = oci_connect('d201701971', "rhehgus1019", $dsn); // DB와 연동

// 이미 대여된 경우
$sql = "SELECT * FROM PREVIOUSRENTAL WHERE ISBN = '{$_GET['isbn']}'";
$sql_info = oci_parse($conn, $sql);
oci_execute($sql_info);
if (oci_fetch_row($sql_info)) { // 대여 불가
    ?>
    <script>
        alert("이미 대여된 도서입니다. 예약을 진행해주세요.");
        location.href = "secondMain.php";
    </script>
    <?php
} else { // 대여 가능
    $sql = "INSERT INTO PREVIOUSRENTAL (ISBN, DATERENTED, DATERETURNED, CNO) VALUES ('{$_GET['isbn']}', SYSDATE, SYSDATE + 10,'{$_SESSION['userCno']}')";
    ?>
    <script>
        alert("대여가 완료되었습니다.");
        location.href = "secondMain.php";
    </script>
    <?php
}
?>