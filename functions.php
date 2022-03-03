<?php


function connect_to_db()
{
    $dbn = 'mysql:dbname=gsacf_d10_06;charset=utf8mb4;port=3306;host=localhost';
    $user = 'root';
    $pwd = '';

    try {
        return new PDO($dbn, $user, $pwd);
    } catch (PDOException $e) {
        echo json_encode(["db error" => "{$e->getMessage()}"]);
        exit();
    }
}

// ログイン状態のチェック関数
function check_session_id()
{
    if (!isset($_SESSION["session_id"]) || $_SESSION["session_id"] != session_id()) {
        header("Location:top.php");
        exit();
    } else {
        session_regenerate_id(true);
        $_SESSION["session_id"] = session_id();
    }
}

// ファイルデータを保存
// $filename, ファイル名
// $save_path, 保存先のパス
// $caption、投稿の説明

function fileSave($filename, $save_path, $caption)
{
    $result = False;

    $sql = "INSERT INTO file_table (file_name, file_path, description) VALUE(?, ?, ?)";

    try{
    $stmt = connect_to_db()->prepare($sql);
    $stmt->bindValue(1, $filename, PDO::PARAM_STR);
    $stmt->bindValue(2, $save_path, PDO::PARAM_STR);
    $stmt->bindValue(3, $caption, PDO::PARAM_STR);
    $result = $stmt->execute();
    return $result;
    }catch(PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    return $result;

    }

}

// ファイルデータを取得

function getAllFile()
{
    $sql = "SELECT * FROM file_table";

    $fileData = connect_to_db()->query($sql);

    return  $fileData;
}

function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}