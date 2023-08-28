<?php 
include 'view.php';
?>

<!DOCTYPE html>
<html>
    <form method="post" action="controller.php?action=login">
        <input type="text" name="username" required>
        <input type="text" name="password" required>
        <input type="submit" value="Submit">
    </form>
</html>