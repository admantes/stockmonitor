<?php
include("conf.php");
 
 
 echo $_REQUEST["symbolx"];
 
 exit;
 
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * from t_stocks";
$result = mysqli_query($conn, $sql);
 

mysqli_close($conn);
 
				
  	
?>
