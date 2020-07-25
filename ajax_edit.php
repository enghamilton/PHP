<?php
$conn_sql = mysql_connect("localhost", "root", "");
mysql_select_db("gpapp");
session_start();
$username_sql_decode = $_POST['username'];
$username = utf8_decode($username_sql_decode);
$phone = $_POST['phone'];
$last_phone = $_POST['last-phone'];
$id = $_SESSION['id_of_user'];
rename("images/".$last_phone,"images/".$phone);
$sqlUpdate = mysql_query("UPDATE gpappuser SET username='$username', phone='$phone' WHERE id='$id' LIMIT 1");
mysql_close($conn_sql);
echo "received POST data : ".$_POST['username']." phone : ".$_POST['phone']." last-phone : ".$_POST['last-phone'];
?>