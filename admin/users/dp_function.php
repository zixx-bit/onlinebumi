<?php

function pdoConnection(){
  try{
    $db_name = 'store';
    $db_user = 'root';
    $db_password = '';
    $db_host ='localhost';

    $pdo = new PDO('mysql:host =' .$db_host . '; dbname=' . $db_name, $db_user, $db_password);
    $pdo ->setAttribute(PDO:: ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    return $pdo;
  }

  catch (PDOException $e){
    echo $e->getMessage();
  }

}



 ?>
