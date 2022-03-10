<?php

// var_dump($_GET);
// exit;

session_start();
include("functions.php");
check_session_id();

$user_id = $_GET['user_id'];
$file_id = $_GET['file_id'];

$pdo = connect_to_db();

// $sql = 'INSERT INTO like2_table (id, user_id, file_id, insert_time) VALUES (NULL, :user_id, :file_id, now())';
$sql = "SELECT COUNT(*) FROM like2_table WHERE user_id =:user_id AND file_id=:file_id";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':file_id', $file_id, PDO::PARAM_STR);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

$like_count = $stmt->fetchColumn();
// var_dump($like_count);
// exit();
if($like_count != 0){
    $sql = 'DELETE FROM like2_table WHERE user_id=:user_id AND file_id=:file_id';

} else {
    $sql = 'INSERT INTO like2_table (id, user_id, file_id, insert_time) VALUES (NULL, :user_id, :file_id, sysdate())';
}

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':file_id', $file_id, PDO::PARAM_STR);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}


header("Location:upload_form.php");
exit();


// $sql = 'INSERT INTO like2_table (id, user_id, file_id, created_at) VALUES (NULL, :user_id, :file_id, now())';

// $stmt = $pdo->prepare($sql);
// $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
// $stmt->bindValue(':file_id', $file_id, PDO::PARAM_STR);

// try {
//     $status = $stmt->execute();
// } catch (PDOException $e) {
//     echo json_encode(["sql error" => "{$e->getMessage()}"]);
//     exit();
// }

// header("Location:upload_form.php");
// exit();


?>
