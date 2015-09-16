<?php
session_start();
require('dbconnect.php');

$id = 1;

if (!empty($_POST)){
  if ($_POST[Message] != ''){
    $sql = sprintf('INSERT INTO Task SET User_ID= %d, TaskType="%s", Worker="%s", Message="%s"',
			mysqli_real_escape_string($db, $id),
			mysqli_real_escape_string($db, $_POST['taskType']),
      mysqli_real_escape_string($db, $_POST['worker']),
      mysqli_real_escape_string($db, $_POST['Message'])
			);
		mysqli_query($db, $sql) or die(mysqli_error($db));

		header('Location: TaskList.php');
		exit();
  }
}

$sql = sprintf('SELECT * FROM Task ORDER BY Task_ID DESC');
$posts = mysqli_query($db, $sql) or die(mysqli_error($db));

function h($value){
  return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <title>TaskList</title>
  </head>
  <body>
    頼みたいお使いを書いて下さい<hr>
    種類<br>
    <form name="form" action="" method="POST">
    <input name="taskType" type="checkbox" value="Buy">買い物<br>
    <input name="taskType" type="checkbox" value="Delivery">お届け<br>
    頼む相手を選択しますか？<br>
    <input name="worker" type="radio" value="Sonoda">Yes<br>
    <input name="worker" type="radio" value="Mori">No<br>
    お使い内容を書いて下さい<br>
    <textarea name="Message" placeholder="内容を書いて下さい" type="textarea" cols=40 rows=4></textarea><br>
    <input type="submit" name="Submit" value="送信">
    </form>
    <HR color="blue">
    <?php
    while($post = mysqli_fetch_assoc($posts)):
    ?>
    Task_ID:<?php echo h($post['Task_ID']); ?>
    User_ID:<?php echo h($post['User_ID']); ?><br>
    Task:<?php echo h($post['TaskType']); ?>
    Worker:<?php echo h($post['Worker']); ?><br>
    Message:<?php echo h($post['Message']); ?>
    </p>
    <?php
    endwhile;
    ?>
  </body>
</html>
