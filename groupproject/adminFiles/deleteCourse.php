<?php
  error_reporting(E_ALL & ~E_NOTICE);
  include '../connection.php';
 

  $id = $_GET['courseID'];

  $sql = 'DELETE FROM `course_table` WHERE `courseID` = '.$id;

  $stmt = $dbConn -> prepare ($sql);
  $stmt->execute();
  header("Location: courseRecords.php");
?>