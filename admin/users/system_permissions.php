<?php


    function checkPermissions($user_id, $permission_id){

      require_once('db_function.php');

      $pdo  = pdoConnection();

      try {

        'select count(*) as total_permissions
         from system_permission_to_roles
         left join system_users_to_roles
         on system_permission_to_roles.role_id = system_users_to_roles.role_id
         where system_users_to_roles:user_id = :user_id
          and permission_id = :permission_id';

          $data = ['user_id' => $user_id,
                    'permission_id' => $permission_id
                  ];

          $stmt = $pdo->prepare($sql);
          $stmt->execute($data);
          $row = $stmt-fetch();

          $uathorized = '';

          if ($row['total_permissions']>0) {
            // code...
             $uathorized = "true";
          }else{
            $uathorized = "false";
          }

          return $authorized;

      } catch (\Exception $e) {

        echo $e -> getMessage();

      }

    }




 ?>
