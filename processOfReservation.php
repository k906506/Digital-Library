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
$sql = "SELECT * FROM RESERVATION WHERE CNO = '{$_SESSION['userCno']}' AND ISBN = '{$_GET['isbn']}'";
$sql_info = oci_parse($conn, $sql);
oci_execute($sql_info);
if (oci_fetch_row($sql_info)) {
    ?>
    <script>
        alert("같은 도서는 한번만 예약할 수 있습니다!");
        location.href = history.back();
    </script>
    <?php
}

// 사용자가 예약한 총 도서를 확인
$sql = "SELECT * FROM RESERVATION WHERE CNO = '{$_SESSION['userCno']}'";
$sql_info = oci_parse($conn, $sql);
oci_execute($sql_info);
$data = array();
while ($row = oci_fetch_row($sql_info)) {
    $data[] = [$row[0], $row[1], $row[2]];
}
$countReservation = sizeof($data); // 쿼리문 실행 결과의 크기

if ($countReservation <= 2) { // 현재 예약된 건수가 2권 이하인 경우 예약 가능
    $sql = "INSERT INTO RESERVATION (ISBN, CNO, RESERVATIONTIME) VALUES ('{$_GET['isbn']}', '{$_SESSION['userCno']}', SYSDATE)";
    $sql_info = oci_parse($conn, $sql);
    oci_execute($sql_info);
    oci_free_statement($sql_info); // 메모리 반환
    oci_close($conn) // 오라클 종료
    ?>
    <script>
        alert("예약이 완료되었습니다.");
        location.href = "secondMain.php";
    </script>
    <?php
} else {
    oci_free_statement($sql_info); // 메모리 반환
    oci_close($conn) // 오라클 종료
    ?>
    <script>
        alert("최대 3권까지 예약할 수 있습니다.");
        location.href = history.back();
    </script>
    <?php
}
?>