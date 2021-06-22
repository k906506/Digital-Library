<?php
$conn = oci_connect("c##kodo", 1234, "USER_ACCOUNT_INFO"); // USER_ACCOUNT_INFO과 연결한다.
$email = $_POST['email']; // 인자로 들어온 email
$password = $_POST['password']; // 인자로 들어온 비밀번호

// 인자로 들어온 email로 쿼리문을 실행하고 결과를 저장한다.
$sql = "SELECT * FROM USER_ACCOUNT_INFO WHERE email ='{$email}'";
$sql_info = oci_parse($conn, $sql);

$fetch_info = oci_fetch_array($sql_info);
$hashedPassword = $fetch_info['password'];

//foreach ($fetch_info as $key => $r) {
//    echo "{$key} : {$r} <br>";
//}

$passwordResult = password_verify($password, $hashedPassword); // 사용자가 입력한 비밀번호와 등록된 비밀번호(해쉬화된 비밀번호)와 비교한다.
if ($passwordResult == true) { // 입력한 비밀번호가 정상적인 경우 세션에 email을 저장한다.
    session_start();
    $_SESSION['userEmail'] = $fetch_info['email'];
    print_r($_SESSION);
    echo $_SESSION['userEmail'];
    ?>
    <script>
        alert("로그인에 성공하였습니다.")
        location.href = "main.php";
    </script>
    <?php
} else {
    ?>
    <script>
        alert("로그인에 실패하였습니다");
    </script>
    <?php
}
?>