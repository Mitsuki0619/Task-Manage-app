<?php 
    require_once '../classes/UserLogic.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        // 入力値を取得
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password_conf = $_POST['password_conf'];

        // バリデーション
        $err = array();
        if(!$username){
            $err['username'] = "ユーザーネームを入力してください。";
        }
        if(!$password){
            $err['password'] = "パスワードを入力してください。";
        } elseif(!preg_match("/\A[a-z\d]{8,100}+\z/i", $password)){
            $err['password'] = "パスワードは８文字以上100文字以下の英数字にしてください。";
        }

        if ($password_conf !== $password) {
            $err['password_conf'] = "確認用パスワードが一致しません。";
        }
        
        if(count($err) === 0) {
            // ユーザー登録処理
            $hasCreated = UserLogic::createUser($_POST);
            if(!$hasCreated) {
                $err['fail'] = "登録に失敗しました。ユーザーネームを変更してください。";
            } else {
                header('Location: index.php');
            }
    
        }

    }
    $title = "新規登録";
    include('header.php');
?>
    <div class="register-form">
        <h1 class="register-title">新規登録</h1>
        <form action="register.php" method="POST">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">ユーザーネーム</label>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="username">
            </div>

            <?php if(isset($err['username'])) : ?>
            <div class="err-container">
                <p class="err-message"><?php echo $err['username']; ?></p>
            </div>
            <?php endif ?>
            <?php if(isset($err['fail'])) : ?>
            <div class="err-container">
                <p class="err-message"><?php echo $err['fail']; ?></p>
            </div>
            <?php endif ?>

            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">パスワード</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="password">
            </div>

            <?php if(isset($err['password'])) : ?>
            <div class="err-container">
                <p class="err-message"><?php echo $err['password']; ?></p>
            </div>
            <?php endif ?>

            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">確認用パスワード</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="password_conf">
            </div>

            <?php if(isset($err['password_conf'])) : ?>
            <div class="err-container">
                <p class="err-message"><?php echo $err['password_conf']; ?></p>
            </div>
            <?php endif ?>

            <button type="submit" class="btn btn-primary">登録</button>
        </form>
    </div>
<?php
include('footer.php');
?>