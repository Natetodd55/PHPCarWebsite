<?php 
include 'view.php';
echo "<h1> Hello " . $_SESSION['username'] . ", update your posts here:</h1><br>";
getCurrentPosts(getId($_SESSION['username']));
 ?>

