<?php 
    session_start();  
    
   require_once '../classes/UserLogic.php';
   require_once '../classes/TaskLogic.php';
   require_once '../config/security_function.php';

   //ログインチェック
   $result = UserLogic::checkLogin();
   if(!$result) {
        header('Location: login.php');
   }

   //タスク取得
    $userdata = $_SESSION['login_user'];
    $url_str = "";
   
    $sortset = (string)filter_input(INPUT_GET, 'sort');
     if ($sortset === "") {
         $sortset = "newer";
     } else {
         $sortset = (string) filter_input(INPUT_GET, 'sort');
     }

    if($sortset === "newer"){
        $tasks = TaskLogic::getTasks($userdata);
    }
    if($sortset === "priority"){
        $tasks = TaskLogic::getTasksByPriority($userdata);
    }
    if($sortset === "deadline"){
        $tasks = TaskLogic::getTasksByDeadline($userdata);
    }
    if(isset($_POST["search_title"])) {
        $search_task = TaskLogic::searchTitle();
    }
    
   $title = "ホーム";
   include('header.php');
?>
<div class="home-menu">
    <form action="index.php" method="post" class="search-form">
        <input type="text" name="search_title" class="form-control search" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="タイトル検索">
        <input type="submit" name="submit" class="btn btn-primary ms-1" value="検索">
    </form>

    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
        <?php if($sortset === "newer") : ?>
            新しい順
        <?php elseif($sortset === "priority") : ?>
            優先度順
        <?php elseif($sortset === "deadline") : ?>
            締切日順
        <?php endif ?>
        </button>

        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">          
            <li>
                <form action="<?php echo $url_str ?>" method="get">
                    <input type="hidden" name="sort" value="newer">
                    <input class="dropdown-item" type="submit" value="新しい順">
                </form>
            </li>
            <li>
                <form action="<?php echo $url_str ?>" method="get">
                    <input type="hidden" name="sort" value="priority">
                    <input class="dropdown-item" type="submit" value="優先度">
                </form>
            </li>
            <li>
                <form action="<?php echo $url_str ?>" method="get">
                    <input type="hidden" name="sort" value="deadline">
                    <input class="dropdown-item" type="submit" value="締切日">
                </form>
            </li>
        </ul>
    </div>
</div>
<?php if(isset($search_task)) : ?>
<p class="search-title">"<?php echo $_POST["search_title"]; ?>" の検索結果</p>
<table class="table table-striped table-bordered table-hover">
  <thead class="table-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">タイトル</th>
      <th scope="col">状態</th>
      <th scope="col">優先度</th>
      <th scope="col">期限</th>
      <th scope="col">操作</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach((array)$search_task as $stask) : ?>
            <tr>
                <td scope="row"><?php echo $stask['id']; ?></th>
                <td><?php echo $stask['title']; ?></td>
        
                <?php if($stask['status'] == 0) :?>
                    <td class="yet">未</td>
                <?php else : ?>
                    <td class="done">済</td>
                <?php endif ?>   
            
                <td><?php echo $stask['priority']; ?></td>
                <td><?php echo $stask['deadline']; ?></td>
                <td>
                    <a class="detail-btn" href="detail.php?id=<?php echo $stask['id']; ?>">詳細</a> 
                    <a class="detail-btn" href="delete.php?id=<?php echo $stask['id']; ?>">削除</a>
                </td>
            </tr>
    <?php endforeach ?>
  </tbody>
</table>
<?php endif ?>

<table class="table table-striped table-bordered table-hover">
  <thead class="table-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">タイトル</th>
      <th scope="col">状態</th>
      <th scope="col">優先度</th>
      <th scope="col">期限</th>
      <th scope="col">操作</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach((array)$tasks as $task) : ?>
            <tr>
                <td scope="row"><?php echo $task['id']; ?></th>
                <td><?php echo $task['title']; ?></td>
        
                <?php if($task['status'] == 0) :?>
                    <td class="yet">未</td>
                <?php else : ?>
                    <td class="done">済</td>
                <?php endif ?>   
            
                <td><?php echo $task['priority']; ?></td>
                <td><?php echo $task['deadline']; ?></td>
                <td>
                    <a class="detail-btn" href="detail.php?id=<?php echo $task['id']; ?>">詳細</a> 
                    <a class="detail-btn" href="delete.php?id=<?php echo $task['id']; ?>">削除</a>
                </td>
            </tr>
    <?php endforeach ?>
  </tbody>
</table>

<?php
    include('footer.php');
?>