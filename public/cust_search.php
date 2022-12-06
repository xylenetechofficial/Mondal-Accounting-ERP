<?php
require_once "includes/crud.php";
if (isset($_GET['term'])) {
     
   $query = "SELECT DISTINCT id, name, mobile FROM cust WHERE name LIKE '{$_GET['term']}%' LIMIT 5";
    $result = mysqli_query($conn, $query);
 
    if (mysqli_num_rows($result) > 0) {
     while ($user = mysqli_fetch_array($result)) {
      $res[] = $user['id'] . " " . $user['name'] . " " . $user['mobile'];
     }
    } else {
      $res = array();
    }
    //return json res
    echo json_encode($res);
}
?> 