<?php
$tns = "
(DESCRIPTION=
(ADDRESS_LIST= (ADDRESS=(PROTOCOL=TCP)(HOST=cnusdlab.synology.me)(PORT=1521)))
(CONNECT_DATA= (SERVICE_NAME=XE))
)
";
$dsn = "oci:dbname=" . $tns . ";charset=utf8";
$username = 'c##madang';
$password = 'madang';
$searchWord = $_GET['searchWord'] ?? '';
try {
    $conn = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    echo("에러 내용: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css"
          integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
    <style>
        a {
            text-decoration: none;
        }
    </style>
    <title>BOOK LIST</title>
</head>
<body>


<div class="container">
    <h2 class="text-center">Book List</h2>
    <table class="table table-bordered text-center">
        <thead>
        <tr>
            <th>제목</th>
            <th>출판사</th>
            <th>가격</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $stmt = $conn->prepare("SELECT BOOK_ID, BOOK_NAME, PUBLISHER, PRICE FROM BOOK WHERE LOWER(BOOK_NAME) LIKE '%' || :searchWord ||
'%' ORDER BY BOOK_NAME");
        $stmt->execute(array($searchWord));
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <tr>
                <td><a href="bookview.php?bookId=<?= $row['BOOK_ID'] ?>"><?= $row['BOOK_NAME'] ?></a></td>
                <td><?= $row['PUBLISHER'] ?></td>
                <td><?= $row['PRICE'] ?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
    <div class="d-grid d-md-flex justify-content-md-end">
        <a href="input.php?mode=insert" class="btn btn-primary">등록</a>
    </div>
    <form class="row">
        <div class="col-10">
            <label for="searchWord" class="visually-hidden">Search Word</label>
            <input type="text" class="form-control" id="searchWord" name="searchWord" placeholder="검색어 입력" value="<?=
            $searchWord ?>">
        </div>
        <div class="col-auto text-end">
            <button type="submit" class="btn btn-primary mb-3">검색</button>
        </div>
    </form>
</div>
</body>
</html>