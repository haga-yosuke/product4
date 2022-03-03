<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ユーザー登録画面</title>
  <link rel="stylesheet" href="style.css">
</head>

<body id="index">

  <div class="content">
    <form action="register_act.php" method="POST" class="form_log">


      <h1 style="text-align:center;margin-top: 0em;margin-bottom: 1em;">ユーザー登録画面</h1>

      <div class="control">
        <input type="name" name="username" class="textbox un" placeholder="ユーザー名"><br>
      </div>
      <?php if (!empty($error["name"]) && $error['name'] === 'blank') : ?>
        <p class="error">＊ユーザー名を入力してください</p>
      <?php endif ?>
      <br><br>
      <input type="password" name="password" class="textbox pass" placeholder="パスワード"><br>
      <?php if (!empty($error["password"]) && $error['password'] === 'blank') : ?>
        <p class="error">＊パスワードを入力してください</p>
      <?php endif ?>

      <br><br>

      <div>
        <button type="submit" class="btn">新規登録する</button>
      </div>

      <br><br>

      <a href="top.php" class="edit">ログイン画面に戻る</a>

      <br>

    </form>
  </div>

</body>

</html>