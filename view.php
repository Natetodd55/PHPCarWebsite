<?php 
include 'views/css.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <?php if (isLoggedIn() == true):?>
      <ul>
        <li><a href="controller.php">Home</a></li>
        <li><a href="controller.php?action=createpost">Create Post</a></li>
        <li><a href="controller.php?action=secret">Update Post</a></li>
        <li><a href="controller.php?action=logout">Logout</a></li>
      </ul>
    <?php else: ?>
      <ul>
        <li><a href="controller.php">Home</a></li>
        <li><a href="controller.php?action=createuser">Create New User</a></li>
        <li><a href="controller.php?action=login">Login</a></li>
    </ul>
    <?php endif; ?>
    </head>
</html>