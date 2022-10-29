<?php
if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PWD'])){
  header("HTTP/1.0 401 Unauthorized");
  echo'{"error": "Authentication failed."}';

  exit();
  
}else{
  $username = $_SERVER['PHP_AUTH_USER'];
  $password = $_SERVER['PHP_AUTH_PWD'];

}

$sql_authenticate = 'select * from system_users where username = :username';

$data = [
        'username'=> $username
      ];

$stmt = $pdo->prepare($sql_authenticate);
$stmt ->execute($data);

$user_details = [];

while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  $user_details = $row;
}

if (password_verify($password, user_details['pwd'])==true) {
  $user_id = $user_details['user_id'];

}else{
  header("HTTP/1.0 401 Unauthorized");
  echo '{"error":"Invalid username or password."}';
  exit();
}






 ?>
