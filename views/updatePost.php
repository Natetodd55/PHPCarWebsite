<?php
include 'view.php';
if($_SERVER['REQUEST_METHOD'] == "GET"){
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $info = getCarInfo($id);
}

?>

<!DOCTYPE html>
<html>
    <body>
    <h1>Update A Post:</h1><br>
    <form method="post" action=<?php echo "controller.php?action=updatepost"; ?>>
    <input type="hidden" name="updateid" value=<?php echo "'" . $info['id'] . "'"; ?>>
    Make:<input type="text" name="make" value=<?php echo "'" . $info['make'] . "'"; ?> required><br>
    Model:<input type="text" name="model" value=<?php echo "'" . $info['model'] . "'"; ?> required><br>
    Year:<input type="number" name="year" value=<?php echo "'" . $info['year'] . "'"; ?> required><br>
    Asking Price:<input type="number" name="price" value=<?php echo $info['price']; ?> required><br>
    Description of Vehicle: <br>
    <textarea name="desc" rows="5" cols="50" maxlength="250" required><?php echo $info['description']; ?></textarea><br>
    <input type="submit" value="Update Post">
</form>
</body>
</html>