<?php 
include 'view.php';
?>
<!DOCTYPE html>
<html>
    <body>
    <h1>Create A Post:</h1><br>
    <form method="post" action="controller.php?action=createpost">
    Make:<input type="text" name="make" required><br>
    Model:<input type="text" name="model" required><br>
    Year:<input type="number" name="year" required><br>
    Asking Price:<input type="number" name="price" required><br>
    Description of Vehicle: <br>
    <textarea name="desc" rows="5" cols="50" maxlength="250" required></textarea><br>
    <input type="submit" value="Create Post">
</form>
</body>
</html>