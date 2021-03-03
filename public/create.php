<?php 
    session_start();
    $userdata = $_SESSION['login_user'];
    require_once '../classes/TaskLogic.php';
    require_once '../classes/UserLogic.php';

       //ログインチェック
    $result = UserLogic::checkLogin();
    if(!$result) {
            header('Location: login.php');
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        // 入力値を取得
        $title = trim($_POST['title']);
        $content = trim($_POST['content']);
        $comment = trim($_POST['comment']);
        $deadline = $_POST['deadline'];
        $priority = $_POST['priority'];

        // バリデーション
        $err = array();
        if(!$title){
            $err['title'] = "タイトルを入力してください。";
        }
        if(!$content){
            $err['content'] = "内容を入力してください。";
        } 
        if (!$deadline) {
            $err['deadline'] = "期限を指定してください。";
        }
        
        if(count($err) === 0) {
            // ユーザー登録処理
            $hasCreated = TaskLogic::createTask($userdata);
            if(!$hasCreated) {
                $err['fail'] = "登録に失敗しました。";
            } else {
                header('Location: index.php');
            }

        }

    }
    $title = "タスク登録";
    include('header.php');
?>

<div class="create-form">
        <h1 class="create-title">新規タスク</h1>
        <form action="create.php" method="POST">
            <div class="create-conteiner">
                <div class="form-section1">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">タイトル</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="title">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputTextarea1" class="form-label">内容</label>
                        <textarea class="form-control" id="exampleInputTextarea1" name="content" cols="20" rows="5"></textarea>
                    </div>
                </div>
                <label for="exampleInputTextarea2" class="form-label">コメント</label>
                <textarea class="form-control" id="exampleInputTextarea2" name="comment" id="" cols="30" rows="2"></textarea>
                <div class="form-section2">
                    <div class="priority-form">
                        <div class="input-group mb-3">
                            <label class="input-group-text " for="inputGroupSelect01">優先度</label>
                            <select class="form-select" id="inputGroupSelect01" name="priority">
                                <option value="1" selected>1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>
                    <div class="input-group mb-3 deadline-form">
                        <label class="input-group-text" for="inputDatetime">期限</label>
                        <input class="form-select" type="datetime-local" id="inputDatetime" name="deadline">
                    </div>
                    <button type="submit" class="btn btn-primary create-btn">登録</button>
                </div>
            </div>
        </form>
    </div>

<?php
    include('footer.php');
?>