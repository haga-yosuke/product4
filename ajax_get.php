<?php

// var_dump($_GET);
// exit();

include("functions.php");

$pdo = connect_to_db();

$searchWord = $_GET["searchword"];

$sql = "SELECT * FROM file_table  WHERE description LIKE :search_word";
$stmt = $pdo->prepare($sql);

$stmt->bindValue(':search_word', "%{$search_word}%", PDO::PARAM_STR);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($result);
exit();
