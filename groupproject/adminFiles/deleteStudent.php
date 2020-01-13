<?php
  error_reporting(E_ALL & ~E_NOTICE);
  include '../connection.php';
 

  $id = $_GET['studentID'];

  $sql = 'DELETE FROM `student_table` WHERE `studentID` = '.$id;

  $stmt = $dbConn -> prepare ($sql);
  $stmt->execute();
  header("Location: studentRecords.php");
?>