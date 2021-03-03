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

    $id = $_GET['id'];

    $task = TaskLogic::getTask($id);
    
    $title = "タスク詳細";
    include('header.php');
?>

<div class="detail-container">
        <h1 class="detail-title">タスク詳細</h1>
        <div class="flex-box">
            <div class="detail-subject">タイトル</div>
            <div class="detail-task"><?php echo($task['title']) ?></div>
        </div>
        <hr>
        <div class="flex-box">
            <div class="detail-subject">内容</div> 
            <div class="detail-task"><?php echo(nl2br($task['content'])) ?></div>
        </div>
        <hr>
        <div class="flex-box">
            <div class="detail-subject">コメント</div> 
            <div class="detail-task"><?php echo(nl2br($task['comment'])) ?></div>
        </div>
        <hr>
        <div class="detail-section">
            <div class="detail-section">
                <div class="detail-subject">優先度 :</div> 
                <div class="detail-task2"><?php echo($task['priority']) ?></div>
            </div>
            <div class="detail-section">
                <div class="detail-subject">状態 :</div> 
                <div class="detail-task2">
                <?php if($task['status'] == 0) :?>
                    <div class="detail-task2　yet" >未完了</td>
                <?php else : ?>
                    <div class="detail-task2 done">完了済</td>
                <?php endif ?> 
                </div>
            </div>
            <div class="detail-section">
                <div class="detail-subject">期限 :</div> 
                <div class="detail-task2"><?php echo($task['deadline']) ?></div>
            </div>
        </div>
</div>
<?php if($task['status'] == 0) : ?>
   
    <form action="done.php?id=<?php echo $task['id']; ?>" method="POST">
        <input type="submit" value="完了済みにする" class="detail-btn done-btn">
    </form>
<?php else : ?>
   
    <form action="not_done.php?id=<?php echo $task['id']; ?>" method="POST">
        <input type="submit" value="完了を取り消す" class="detail-btn done-btn">
    </form>
<?php endif ?>

<?php
    include('footer.php');
?>