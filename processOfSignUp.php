<?php
$conn = oci_connect('c##kodo', 1234); // USER_ACCOUNT_INFO에 email과 password를 등록한다,
$hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
$sql = "INSERT INTO USER_ACCOUNT_INFO (email, password) VALUES('{$_POST['email']}', '{$hashedPassword}')";
$result = oci_parse($conn, $sql);

if ($result === false) {
    echo "이미 존재하는 계정이거나 형식이 잘못되었습니다. 다시 시도해주세요.";
    echo oci_connect($conn);
} else {
    ?>
    <script>
        alert("회원가입이 완료되었습니다");
        location.href = "main.php";
    </script>
    <?php
}
?>