<?php 
include 'view.php';
?>
<!DOCTYPE html>
<html>
    <body>
    <form method="post" action="controller.php?action=createuser">
        <input type="text" name="username" required>
        <input type="text" name="password" required>
        <input type="submit" value="Create">
    </form>
</body>
</html>