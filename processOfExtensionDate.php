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

// 이미 예약된 경우 연장 불가
$sql = "SELECT * FROM RESERVATION WHERE ISBN = '{$_GET['isbn']}'";
$sql_info = oci_parse($conn, $sql);
oci_execute($sql_info);
if (oci_fetch_row($sql_info)) {
    oci_free_statement($sql_info); // 메모리 반환
    oci_close($conn); // 오라클 종료
    ?>
    <script>
        alert("예약된 도서입니다. 반납을 진행해주세요.");
        location.href = history.back();
    </script>
    <?php
} else { // 예약된 도서가 아니고 연장 횟수가 2회 이하일 때 연장 가능
    $sql = "SELECT EXTTIMES FROM EBOOK WHERE ISBN = '{$_GET['isbn']}'";
    $sql_info = oci_parse($conn, $sql);
    oci_execute($sql_info);
    $row = oci_fetch_row($sql_info)[0];
    if ($row <= 2) { // 해당 도서가 연장 횟수가 2회 이하일 때 연장 가능
        $sql = "UPDATE PREVIOUSRENTAL SET DATERETURNED = DATERETURNED + 10 WHERE ISBN = '{$_GET['isbn']}'";
        $sql_info = oci_parse($conn, $sql);
        oci_execute($sql_info);
        oci_free_statement($sql_info); // 메모리 반환

        $sql = "UPDATE EBOOK SET EXTTIMES = EXTTIMES + 1 WHERE ISBN = '{$_GET['isbn']}'";
        $sql_info = oci_parse($conn, $sql);
        oci_execute($sql_info);
        ?>
        <script>
            alert("기한이 10일 연장되었습니다.");
        </script>
        <?php
    } else {
        oci_free_statement($sql_info); // 메모리 반환
        oci_close($conn); // 오라클 종료
        ?>
        <script>
            alert("연장은 2번까지만 가능합니다.");
            location.href = history.back();
        </script>
        <?php
    }
}
?>