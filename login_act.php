<?php
// データ受け取り
// var_dump($_POST);
// exit;
session_start();
// DB接続

include("functions.php");

$username = $_POST["username"];
$password = $_POST["password"];

$pdo = connect_to_db();
// SQL実行
$sql = "SELECT * FROM users_table WHERE username=:username AND password=:password AND is_deleted=0";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

// ユーザ有無で条件分岐
$val = $stmt->fetch(PDO::FETCH_ASSOC);
// var_dump($val);
// exit;
if(!$val){
    echo"<p>usernameかpasswordが間違っています。</p>";
  echo "<a href=top.php>ログイン画面へ</a>";
  exit();

}else{
    $_SESSION = array();
    $_SESSION['user_id'] = $val['id'];
    $_SESSION['session_id'] = session_id();
    $_SESSION['is_admin'] = $val['is_admin'];
    $_SESSION['username'] = $val['username'];
    header("Location:upload_form.php");
    exit();
}

?>