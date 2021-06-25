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

// 반납이 완료되면 연장 횟수는 0으로
$sql = "UPDATE EBOOK SET EXTTIMES = 0 WHERE ISBN = '{$_GET['isbn']}'";
$sql_info = oci_parse($conn, $sql);
oci_execute($sql_info);

// 반납이 완료되면 CNO는 0으로
$sql = "UPDATE EBOOK SET CNO = NULL WHERE ISBN = '{$_GET['isbn']}'";
$sql_info = oci_parse($conn, $sql);
oci_execute($sql_info);

// PRIVIOUSRENTAL에 대여일자를 저장하기 위해 대여일자를 다른 변수에 저장
$sql = "SELECT DATERENTED FROM EBOOK WHERE ISBN = '{$_GET['isbn']}'";
$sql_info = oci_parse($conn, $sql);
oci_execute($sql_info);
$RENTED = oci_fetch_row($sql_info)[0];

// 저장한 대여일자를 PREVIOUSRENTAL에 저장
$sql = "INSERT INTO PREVIOUSRENTAL (ISBN, DATERENTED, DATERETURNED, CNO) VALUES ('{$_GET['isbn']}', '{$RENTED}' , SYSDATE, '{$_SESSION['userCno']}')";
$sql_info = oci_parse($conn, $sql);
oci_execute($sql_info);
?>
<script>
    alert("반납되었습니다.");
    location.href = history.back();
</script>
