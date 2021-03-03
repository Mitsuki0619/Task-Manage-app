<?php 
session_start();
$_SESSION = array();

require_once '../classes/UserLogic.php';


if($_SERVER['REQUEST_METHOD'] == 'POST') {
        // 入力値を取得
        $username = $_POST['username'];
        $password = $_POST['password'];

        // バリデーション
        $err = array();
        if(!$username){
            $err['username'] = "ユーザーネームを入力してください。";
        }
        if(!$password){
            $err['password'] = "パスワードを入力してください。";
        } 
    
        
        if(count($err) === 0) {
            $result = UserLogic::login($username, $password);
            if($result){
                header('Location: index.php');
                return;
            } else {
                $err["msg"] = "ユーザーネーム、またはパスワードが一致しません。";
            }
        }

    } else {
        $username = "";
        $password = "";
    }

    $title = "ログイン";
    include('header.php');
?>
    <div class="login-form">
        <h1 class="login-title">ログイン</h1>
        <form action="login.php" method="POST">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">ユーザーネーム</label>
                <input type             = "text" 
                       class            = "form-control" 
                       id               = "exampleInputEmail1" 
                       aria-describedby = "emailHelp"　
                       name             = "username" 
                       value            = "<?php echo $username ?>">
            </div> 

            <!-- エラーメッセージ -->
            <?php if(isset($err['username'])) : ?>
            <div class="err-container">
                <p class="err-message"><?php echo $err['username']; ?></p>
            </div>
            <?php endif ?>
            <!-- -->
            
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">パスワード</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="password">
            </div>

            <!-- エラーメッセージ -->
            <?php if(isset($err['password'])) : ?>
            <div class="err-container">
                <p class="err-message"><?php echo $err['password']; ?></p>
            </div>
            <?php endif ?>
            <!-- -->
            <!-- エラーメッセージ -->
            <?php if(isset($err["msg"])) : ?>
            <div class="err-container">
                <p class="err-message"><?php echo $err["msg"]; ?></p>
            </div>
            <?php endif ?>
            <!-- -->

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
            <button type="submit" class="btn btn-primary">ログイン</button>
        </form>
    </div>
<?php
    include('footer.php');
?>