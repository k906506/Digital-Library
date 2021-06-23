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

// 실행
$conn = oci_connect('d201701971', "rhehgus1019", $dsn); // DB와 연동
$email = $_POST['email']; // 인자로 들어온 email
$password = $_POST['password']; // 인자로 들어온 비밀번호

// 인자로 들어온 email로 쿼리문을 실행하고 결과를 저장
$sql = "SELECT CNAME, EMAIL, PASSWORD FROM USER_ACCOUNT_INFO WHERE EMAIL ='{$email}'";
$sql_info = oci_parse($conn, $sql);

//
oci_execute($sql_info);

// DB에 저장된 비밀번호와 현재 입력한 비밀번호를 비교해서 같으면 로그인 성공
$storedInfo = oci_fetch_array($sql_info); // 쿼리문 실행 결과
$storedName = $storedInfo[0]; // CNAME
$storedPassword = $storedInfo[2]; // PASSWORD

if ($password == $storedPassword) { // 입력한 비밀번호가 정상적인 경우 세션에 EMAIL 저장
    session_start();
    $_SESSION['userName'] = $storedName;
    oci_free_statement($sql_info); // 메모리 반환
    oci_close($conn) // 오라클 종료
    ?>
    <script>
        alert("로그인에 성공하였습니다.")
        location.href = "main.php";
    </script>
    <?php
} else {
    oci_free_statement($sql_info); // 메모리 반환
    oci_close($conn) // 오라클 종료
    ?>
    <script>
        alert("로그인에 실패하였습니다");
        location.href = "login.php"; // 로그인 페이지로 리턴
    </script>
    <?php
}
?>