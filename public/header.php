<!doctype html>
<html lang="ja">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <!-- original css -->
    <link href="../css/styles.css" rel="stylesheet" >

    <title><?php echo $title; ?></title>
  </head>
  <body>
    <header>
      <div class="header-container">
        <a href="index.php"><h3 class="app-title">TASKS</h3></a>
        <div class="login-menu">
          <?php if(isset($_SESSION['login_user']['id'])) : ?>
            <a href="create.php"　class="create-btn">タスク作成</a>
            <a href="logout.php" class="logout-btn">ログアウト</a>
          <?php else : ?>
            <a href="login.php" class="login-btn">ログイン</a>
          <?php endif ?>
          </div>
      </div>
    </header> 
