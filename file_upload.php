<?php


include("functions.php");

// ファイル関連の取得
$file = $_FILES["img"];
$filename = basename($file["name"]);
$tmp_path = $file["tmp_name"];
$file_err = $file["error"];
$filesize = $file["size"];
$upload_dir = "images/";
// $upload_dir = "/Applications/XAMPP/xamppfiles/htdocs/gs/file_upload/images/";
$save_filename = date("YmdHis") . $filename;
$err_msgs = array();
$save_path = $upload_dir . $save_filename;

// キャプション取得
$caption = filter_input(INPUT_POST, "caption", FILTER_SANITIZE_SPECIAL_CHARS);

// キャプションのバリデーション
if (empty($caption)) {
    array_push($err_msgs, "キャプションを入力してください");
    echo "<br>";
}

if (strlen($caption) > 140) {
    array_push($err_msgs, "キャプションは140文字以内で入力してください。");
    echo "<br>";
}

// ファイルのバリデーション
if ($filesize > 1048576 || $file_err == 2) {
    echo "ファイルサイズを１MB未満にしてください。";
    echo "<br>";
}

// 拡張子が画像かどうか
$allow_ext = array("jpg", "jpeg", "png");
$file_ext = pathinfo($filename, PATHINFO_EXTENSION);

if (!in_array(strtolower($file_ext), $allow_ext)) {
    array_push($err_msgs, "画像ファイルを添付してください。");
    echo "<br>";
}

if (count($err_msgs) === 0) {
    // ファイルがあるかどうか
    if (is_uploaded_file($tmp_path)) {
        if (move_uploaded_file($tmp_path, $save_path)) {
            echo $filename . "を" . $upload_dir . "にアップしました。";

            // DBに保存：ファイル名・ファイルパス・キャプション
            $result = fileSave($filename, $save_path, $caption);

            if ($result) {
                echo "データベースに保存しました！";
            } else {
                echo "データベースへの保存が失敗しました。";
            }
        } else {
            echo "ファイルが保存できませんでした。";
            // var_dump($file);
            // exit;
        }
    } else {
        echo "ファイルが選択されていません。";
        echo "<br>";
    }
} else {
    foreach ($err_msgs as $msg) {
        echo $msg;
        echo "<br>";
    }
}

?>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>アップロードフォーム</title>
    <link rel="stylesheet" href="upload.css">
</head>

<br><br>

<h2 style="text-align:center;margin-top: 2em;margin-bottom: 1em;" class="h1_log">
    投稿ページはこちら
</h2>

<div style="text-align:center;margin-top: 2em;margin-bottom: 1em;">
    <p class="btn"><a href="upload_form.php">戻る</a></p>
    <!-- <button href="upload_form.php" type="submit" class="btn">戻る</button> -->
</div>