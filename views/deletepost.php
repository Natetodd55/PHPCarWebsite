<?php
include 'view.php';
if($_SERVER['REQUEST_METHOD'] == "GET"){
    $id = isset($_GET['id']) ? $_GET['id'] : '';
}
?>

<!DOCTYPE html>
<html>
    <body>
    <h1>Confirm Deletion?:</h1><br>
    <form method="post" action=<?php echo "controller.php?action=deletepost"; ?>>
    <input type="hidden" name="deleteid" value=<?php echo $id; ?>>
    <input type="submit" value="Delete Post">
</form>
</body>
</html>