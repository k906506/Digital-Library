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

// 실행
$conn = oci_connect('d201701971', "rhehgus1019", $dsn); // DB와 연동
// $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT); -> 암호화를 위한 과정이지만 암호화를 진행할 경우 자리수가 늘어나서 DB에 INSERT가 되지 않음

// 1. EMAIL이 이미 사용 중인 경우 가입 불가
$sqlFindPk = "SELECT * FROM CUSTOMER WHERE CNO = '{$_POST['cno']}'"; // 입력한 CNO가 이미 사용 중인지 검색
$resultFindPk = oci_parse($conn, $sqlFindPk);
oci_execute($resultFindPk);
$storedPassword = oci_fetch_array($resultFindPk)[0]; // 이미 사용 중인 경우 storedPassWord에 값이 존재
oci_free_statement($resultFindPk); // 메모리 반환
if ($storedPassword) { // 이미 있는 경우
    ?>
    <script>
        alert("이미 존재하는 계정이거나 형식이 잘못되었습니다. 다시 시도해주세요.");
        location.href = "signUp.php"; // 가입 페이지로 리턴
    </script>
    <?php
}

// 2. EMAIL이 사용 중이 아닌 경우 가입 가능
$sql = "INSERT INTO CUSTOMER (CNO, NAME, PASSWD, EMAIL) VALUES ('{$_POST['cno']}', '{$_POST['name']}', '{$_POST['password']}', '{$_POST['email']}')";
$result = oci_parse($conn, $sql);
oci_execute($result);
oci_free_statement($result); // 메모리 반환
oci_close($conn) // 오라클 종료
?>
<script>
    alert("회원가입이 완료되었습니다");
    location.href = "main.php"; // 메인 페이지로 리턴
</script>
