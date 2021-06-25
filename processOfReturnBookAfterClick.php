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

// 이미 예약된 경우
$sql = "DELETE FROM PREVIOUSRENTAL WHERE ISBN = '{$_GET['isbn']}'";
$sql_info = oci_parse($conn, $sql);
oci_execute($sql_info);
?>
<script>
    alert("반납되었습니다.");
    location.href = history.back();
</script>
