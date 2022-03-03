<?php

session_start();
include("functions.php");
check_session_id();
// var_dump(getAllFile());
// exit();
$files = getAllFile();
$user_id = $_SESSION["user_id"];

$pdo = connect_to_db();


$sql = "SELECT * FROM file_table LEFT OUTER JOIN (SELECT file_id,
COUNT(id) AS like_count FROM like2_table GROUP BY file_id) AS result_table
ON  file_table.id = result_table.file_id";

$stmt = $pdo->prepare($sql);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$output = "";

$output .= "
    <tr>
      <br>
      <td><a href='like_create.php?user_id={$user_id}&file_id={$record["id"]}'>お気に入り{$record["like_count"]}</a></td>
      
      <td><a href='file_delete.php?id={$record["id"]}'>削除</a></td>
    </tr>
  ";

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>アップロードフォーム</title>
  <link rel="stylesheet" href="upload.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>

  <header>

    <nav class="navbar navbar-dark bg-dark">
      <div class="modal"></div>
      <ul class="main_ul">
        <li class="top_link"><a href="upload_form.php">X HOUND</a></li>

        <!-- <li><a class="post_window" href="#">投稿</a></li> -->
        <li><a href="index.php">ログアウト</a></li>
      </ul>
    </nav>

  </header>

  <div class="form">
    <form enctype="multipart/form-data" action="file_upload.php" method="POST">
      <div class="file-up">
        <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
        <input name="img" type="file" accept="image/*" />
      </div>
      <div>
        <textarea name="caption" placeholder="投稿内容を入力ください。（140文字以下）" id="caption"></textarea>
      </div>
      <div class="submit">
        <input type="submit" value="送信" class="btn" />
      </div>
    </form>

    <div class="wrap">
      <div class="item">
        <?php foreach ($files as $file) : ?>
          <fieldset>
            <p class="bun"><?php echo h("{$file["description"]}"); ?></p>
            <img src="<?php echo "{$file["file_path"]}"; ?>" alt="">
            <br>
            <?= $output ?>
          </fieldset>
          <br>
        <?php endforeach; ?>

      </div>
    </div>

    <footer>
      <div class="footer">
        <small>copyrights 2021-2022 G`s Academy Fukuoka All RIghts Reserved.</small>
      </div>
    </footer>

  </div>

</body>

<!-- <script>
$(document).on('click', '.post_window', function() {
//背景をスクロールできないように&スクロール場所を維持
scroll_position = $(window).scrollTop();
$('body').addClass('fixed').css({ 'top': -scroll_position });
// モーダルウィンドウを開く
$('.post_process').fadeIn();
$('.modal').fadeIn();
});
</script> -->

</html>