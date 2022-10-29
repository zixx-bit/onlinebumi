<?php

  require_once('db_function.php');
  require_once('system_permissions.php');

  $pdo = pdoConnection();
  $http_verb = $_SERVER['REQUEST_METHOD'];
  $params  =json_decode(file_get_contents('php://input'));

  require_once('aunthenticatons.php');

if ($http_verb == 'POST') {

  if (checkPermissions($user_id, 1) == "false") {
    header("HTTP/1.0 403 Forbidden");
    echo'{"error": "You do not have permission to create product"}' . '\n';
    exit();

  }

  $sql = 'insert into products(product_name, retail_price)
   values(:product_name, :retail_price)';

   $data = [
          'product_name' => $params->product_name,
          'retail_price' => $params->retail_price
   ];

   $stmt = $pdo->prepare($sql);
   $stmt->execute($data);

   echo'{"message": "Product created successfully."}' .'\n';

}elseif ($http_verb == 'GET') {
  $me = checkPermissions($user_id, 4);
  if (checkPermissions($user_id, 4)=="false") {
    header("HTTP/1.0 403 Forbidden");
    echo '{"error": "You do not have permission to list products."}' . '\n';
    exit();
  }

  $sql = 'select * from products';

  $stmt = $pdo->prepare($sql);
  $stmt->execute();

  $data = [];

  while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $data[] = $row;
  }

  $response = [];
  $response['data'] = $data;

  echo json_encode($response, JSON_PRETTY_PRINT). "\n";

}elseif ($http_verb == 'PUT') {
  if (checkPermissions($user_id, 2) == "false") {
    header("HTTP/1.0 403 Forbidden");
    echo '{"error": "You dont have permission to update a product."}' ,'\n';
    exit();
    // code...
  }
  $sql = 'update products set product_name = :product_name,
          retail_price = :retail_price
          where product_id = :product_id';
  // code...
  $data  = ['product_id' => $params->product_id,
            'product_name'=> $params->product_name,
            'retail_price' => $params->retail_price
          ];

  $stmt = $pdo->prepare($sql);
  $stmt->execute($data);

  echo '{"message": "Product updated succesfully"}' .'\n';

} elseif ($http_verb == 'DELETE') {

        if (checkPermissions($user_id, 3) == "false") {
            header("HTTP/1.0 403 Forbidden");
            echo '{"error": "You do not have permissions to delete a product."}';
            exit();
        }

        $sql = 'delete from products
                where product_id = :product_id
                limit 1
                ';

        $data = [
                'product_id' => $params->product_id
                ];

        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);

        echo '{"message": "Product deleted successfully."}' . '\n';
    }


 ?>
