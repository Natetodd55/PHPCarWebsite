<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cs_350";

try {
    $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

function createNewUser($uname, $pword){
  $insert = "INSERT INTO users (username, password) VALUES (:username, :password)";
  try {
      $db = $GLOBALS['db'];
      $stmt = $db->prepare($insert);
      $stmt->bindValue(':username', $uname);
      $stmt->bindValue(':password', $pword);
      $stmt->execute();
      $stmt->closeCursor();
  } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
  }
}

function loginUser($uname, $unhashed){
  $select = "SELECT password FROM users WHERE username = ?";
  try {
    $db = $GLOBALS['db'];
    $stmt = $db->prepare($select);
    $stmt->bindValue(1, $uname);
    $stmt->execute();
    $userpword = $stmt->fetchColumn();
    if(password_verify($unhashed, $userpword) == true){
      return true;
    }else{
      return false;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
}


function createNewPost($make, $model, $year, $price, $desc, $currUserId){
  $insert = "INSERT INTO cars (make, model, year, price, description, ownerId) VALUES (:make, :model, :year, :price, :description, :ownerId)";
  try {
      $db = $GLOBALS['db'];
      $stmt = $db->prepare($insert);
      $stmt->bindValue(':make', $make);
      $stmt->bindValue(':model', $model);
      $stmt->bindValue(':year', $year);
      $stmt->bindValue(':price', $price);
      $stmt->bindValue(':description', $desc);
      $stmt->bindValue(':ownerId', $currUserId);
      $stmt->execute();
      $stmt->closeCursor();
  } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
  }
}

function getID($currname){
  $select = "SELECT id FROM users WHERE username = ?";
  try {
    $db = $GLOBALS['db'];
    $stmt = $db->prepare($select);
    $stmt->bindValue(1, $currname);
    $stmt->execute();
    $userid = $stmt->fetchColumn();
    $stmt->closeCursor();
    return $userid;
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

function isLoggedIn(){
  if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true){
    return true;
  }else{
    return false;
  }
}


function getOwnerName($ownerid){
  $select = "SELECT username FROM users JOIN cars ON cars.ownerId = users.id WHERE cars.ownerId = ?";
  try {
    $db = $GLOBALS['db'];
    $stmt = $db->prepare($select);
    $stmt->bindValue(1, $ownerid);
    $stmt->execute();
    $name = $stmt->fetchColumn();
    $stmt->closeCursor();
    return $name;
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}


function getData(){
  $db = $GLOBALS['db'];
  $stmt = $db->prepare("SELECT * FROM cars");
  $stmt->execute();
  while ($row = $stmt->fetch()) {
    $postby = getOwnerName($row['ownerId']);
    echo "<table class='displayPost'>";
    echo "<tr>";
    echo "<td> Posted By: " . $postby . "</td>";
    echo "<td> Make </td>";
    echo "<td> Model </td>";
    echo "<td> Year </td>";
    echo "<td> Price </td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td class='description'> Description:<br>" . $row['description'] . "</td>";
    echo "<td>" . $row['make'] . "</td>";
    echo "<td>" . $row['model'] . "</td>";
    echo "<td>" . $row['year'] . "</td>";
    echo "<td>$" . $row['price'] . "</td>";
    echo "</tr>";
    echo "</table><br><br>";
  }
  $stmt->closeCursor();
}


function getCurrentPosts($userid){
  $select = "SELECT * FROM cars  WHERE ownerId = ?";
  try {
    $db = $GLOBALS['db'];
    $stmt = $db->prepare($select);
    $stmt->bindValue(1, $userid);
    $stmt->execute();
    while ($row = $stmt->fetch()) {
      $postby = getOwnerName($row['ownerId']);
      echo "<table class='displayPost'>";
      echo "<tr>";
      echo "<td> Posted By: " . $postby . "</td>";
      echo "<td> Make </td>";
      echo "<td> Model </td>";
      echo "<td> Year </td>";
      echo "<td> Price </td>";
      echo "</tr>";
  
      echo "<tr>";
      echo "<td class='description'> Description:<br>" . $row['description'] . "</td>";
      echo "<td>" . $row['make'] . "</td>";
      echo "<td>" . $row['model'] . "</td>";
      echo "<td>" . $row['year'] . "</td>";
      echo "<td>$" . $row['price'] . "</td>";
      echo "</tr>";
      echo "<a href='controller.php?action=updatepost&id=" . $row['id'] . "'>Update</a><br>";
      echo "<a href='controller.php?action=deletepost&id=" . $row['id'] . "'>Delete</a>";
      echo "</table><br><br>";
    }
    $stmt->closeCursor();
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

function getCarInfo($userid){
  $select = "SELECT * FROM cars WHERE id = ?";
  try {
    $db = $GLOBALS['db'];
    $stmt = $db->prepare($select);
    $stmt->bindValue(1, $userid);
    $stmt->execute();
    $row = $stmt->fetch();
    $stmt->closeCursor();
    return $row;
  }catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

function updatePost($make, $model, $year, $price, $desc, $id){
  $update = "UPDATE cars SET make = ?, model = ?, year = ?, price = ?, description = ? WHERE id = ?";
  try {
      $db = $GLOBALS['db'];
      $stmt = $db->prepare($update);
      $stmt->bindValue(1, $make);
      $stmt->bindValue(2, $model);
      $stmt->bindValue(3, $year);
      $stmt->bindValue(4, $price);
      $stmt->bindValue(5, $desc);
      $stmt->bindValue(6, $id);
      $stmt->execute();
      $stmt->closeCursor();
  } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
  }
}

function deletePost($id){
  $delete = "DELETE FROM cars WHERE id = ?";
  try{
    $db = $GLOBALS['db'];
    $stmt = $db->prepare($delete);
    $stmt->bindValue(1, $id);
    $stmt->execute();
    $stmt->closeCursor();
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}


function getUserID($carid){
  $query = "SELECT users.id FROM users JOIN cars ON cars.ownerId = users.id WHERE cars.id = ?";
  try{
    $db = $GLOBALS['db'];
    $stmt = $db->prepare($query);
    $stmt->bindValue(1, $carid);
    $stmt->execute();
    $ownerofpost = $stmt->fetchColumn();
    $stmt->closeCursor();
    return $ownerofpost;
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}


function checkUnique($uname){
  $query = "SELECT COUNT(username) AS numNames FROM users WHERE username = ?";
  try{
    $db = $GLOBALS['db'];
    $stmt = $db->prepare($query);
    $stmt->bindValue(1, $uname);
    $stmt->execute();
    $numNames = $stmt->fetchColumn();
    $stmt->closeCursor();
    if ($numNames == 0){
      return true;
    }else{
      return false;
    }
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}