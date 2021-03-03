<?php

require_once '../config/dbconnect.php';

class TaskLogic
{
    public static function createTask($userdata) 
    {
        $result = false;

         $sql = "INSERT INTO tasks (user_id, title, content, priority, deadline, comment) VALUES (?, ?, ?, ?, ?, ?)";

         $arr = [];

         $arr[] = $userdata['id'];
         $arr[] = $_POST['title'];
         $arr[] = $_POST['content'];
         $arr[] = $_POST['priority'];
         $arr[] = $_POST['deadline'];
         $arr[] = $_POST['comment'];

         try {
             $stmt = connect()->prepare($sql);
             $result = $stmt->execute($arr);
             return $result;

         } catch(\Exception $e) {
             return $result;
         }
        
    }
    
    public static function getTasks($userdata)
    {

        $sql = "SELECT * FROM tasks WHERE user_id = :user_id ORDER BY id DESC";
        try {
            $stmt = connect()->prepare($sql);
            $stmt->bindValue(':user_id', (int)$userdata['id'], PDO::PARAM_INT);
            $stmt->execute();
            $tasks = $stmt->fetchAll();
            return $tasks;
        } catch(\Exception $e) {
            return false;
        }
    }
    
    public static function getTasksByPriority($userdata)
    {

        $sql = "SELECT * FROM tasks WHERE user_id = :user_id ORDER BY priority DESC";
        try {
            $stmt = connect()->prepare($sql);
            $stmt->bindValue(':user_id', (int)$userdata['id'], PDO::PARAM_INT);
            $stmt->execute();
            $tasks = $stmt->fetchAll();
            return $tasks;
        } catch(\Exception $e) {
            return false;
        }
    }
    
    public static function getTasksByDeadline($userdata)
    {

        $sql = "SELECT * FROM tasks WHERE user_id = :user_id ORDER BY deadline ASC";
        try {
            $stmt = connect()->prepare($sql);
            $stmt->bindValue(':user_id', (int)$userdata['id'], PDO::PARAM_INT);
            $stmt->execute();
            $tasks = $stmt->fetchAll();
            return $tasks;
        } catch(\Exception $e) {
            return false;
        }
    }

    public static function getTask($id)
    {

        $sql = "SELECT * FROM tasks WHERE id = :id";
        try {
            $stmt = connect()->prepare($sql);
            $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
            $stmt->execute();
            $task = $stmt->fetch(PDO::FETCH_ASSOC);
            return $task;
        } catch(\Exception $e) {
            return false;
        }
    }
    public static function searchTitle()
    {
        $search = (string)filter_input(INPUT_POST, 'search_title');

        $sql = "SELECT * FROM tasks WHERE title LIKE :like";
        try {
            $stmt = connect()->prepare($sql);
            $stmt->bindValue(':like', '%' . \addcslashes($search, '\_%') . '%', PDO::PARAM_STR);
            $stmt->execute();
            $search_task = $stmt->fetchAll();
            return $search_task;
        } catch(\Exception $e) {
            return false;
        }
    }
    public static function deleteTask($id)
    {

        $sql = "DELETE FROM tasks WHERE id = :id";
        try {
            $stmt = connect()->prepare($sql);
            $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
            $stmt->execute();
        } catch(\Exception $e) {
            return false;
        }
    }
    public static function doneTask($id)
    {
        $sql = "UPDATE tasks SET status = 1 WHERE id = :id";
        try {
            $stmt = connect()->prepare($sql);
            $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
            $stmt->execute();
        } catch(\Exception $e) {
            return false;
        }
    }
    public static function notDoneTask($id)
    {
        $sql = "UPDATE tasks SET status = 0 WHERE id = :id";
        try {
            $stmt = connect()->prepare($sql);
            $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
            $stmt->execute();
        } catch(\Exception $e) {
            return false;
        }
    }
}