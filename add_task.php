<?php
//code 
//add_task.php
include('database_connection.php');


if($_POST["task_name"])
{
 $data = array(
  ':user_id'  => $_POST['user_id'],
  ':task_details' => trim($_POST["task_name"]),
  ':task_status' => 'no',
  ':username' => $_POST["username"],
 
 );
 
//  $username =trim($_SESSION["username"]);
//  echo $_POST["task_name"];
 $query = "
 INSERT INTO task_list 
 (user_id, task_details, task_status,username) 
 VALUES (:user_id, :task_details, :task_status,:username)
 ";
 
 $statement = $connect->prepare($query);

 if($statement->execute($data))
 {
  $task_list_id = $connect->lastInsertId();
//    echo $task_list_id;
   echo '<a href="#" class="list-group-item" id="list-group-item-'.$task_list_id.'" data-id="'.$task_list_id.'">'.$_POST["task_name"].' <span class="badge" data-id="'.$task_list_id.'">delete</span></a>';
 }
}

?>

