; <?php
function display_errors($errors){
  $display ='<ul class="bg-danger"
   style="list-style-type:circle; z-index: 2;  margin:10px;  padding-left:10px; border:1px solid #d13f48; border-radius:10px;">';
  // $display = '<ul class="popup1" style="z-index: 2;">';
     // $display = '<ul class="error">';
  foreach ($errors as $error) {
    $display.='<li class="text-danger" style="z-index: 2; margin:10px; padding:1px; font-weight:100; ">'.$error. '</li>';
  }
  $display .= '</ul>' ;
  return $display;
}

function sanitize($dirty){
  return  htmlentities($dirty, ENT_QUOTES, "UTF-8");
}

function successMessage($messages){
  $display2 = '<ul class="container" style=" width:75%; height:50px;
   list-style:none; z-index: 2; border:1px solid #83bd77; border-radius:12px;">';
  foreach ($messages as $message ) {
  $display2 .='<li class="text-success">'.$message. '</li>';
  }
  $display2 .='</ul>';
  return $display2;
}


function money($number){
  return 'Ksh '.number_format($number,2);
}

function login($user_id){
  // $_SESSION['SBUSER'] = $user_id;
  global $db;
  $date = date("Y-m-d H:i:s");
  $login_user = $db->prepare("UPDATE users SET last_login = ? WHERE id = ?");
  $login_user->bind_param("si", $date, $user_id);
  $login_user->execute();
  $messages[] = 'you are now logged in';
  echo successMessage($messages);
  $_SESSION['success_flash'] = 'You are now logged in!';
  header('Location:products.php');
}

function is_logged_in(){
  if (isset($_SESSION['id']) && $_SESSION['type'] > 0) {
     return true;
  }
  return false;
}

function login_error_redirect($url = '../verify/login.php'){
  $_SESSION ['error_flash'] = '<div class="text-center" style= "color:#CC0000; text-align:center; background-color:#eb9ba5;">You must be logged in to access this page</div>';
  header('Location: '.$url);
}

function permission_error_redirect($url = 'login.php'){
  $_SESSION ['error_flash'] = 'You do not have permission  to access that page';
  header('Location: '.$url);
}

function has_permission($permission = 'admin'){
  global $user_data;
  $permissions = explode(',', $user_data['permissions']);
  if (in_array($permission, $permissions, true)) {
    return true;
  }
  return false;
}

function user_select(){
  if (isset($_SESSION['id']) && $_SESSION['id'] > 0) {
     return true;
  }
    return false;
}



function pretty_date($date){
  return date("M d, Y h:i:A",strtotime($date));
}


function get_category($child_id){
  global $db;
  $id = sanitize($child_id);
  $sql = "SELECT p.id AS 'pid', p.category
          AS 'parent', c.id AS 'cid', c.category AS 'child'
          FROM categories c
          INNER JOIN categories p
          ON c.parent = p.id
          WHERE c.id = '$id'";
  $query = $db->query($sql);

  $category = mysqli_fetch_assoc($query);
  return $category;

}


function list_category(){
$sql2="  SELECT node.location
  FROM locations AS node,
   locations AS
   parent WHERE node.lft BETWEEN parent.lft AND parent.rgt
   AND parent.location = 'Kenya' ORDER BY node.lft";
}



function sizesToArray($string){
  $sizesArray = explode(',', $string);
  $returnArray = array();
  foreach ($sizesArray as $size) {
    $s = explode(':', $size);
    $returnArray[] = array('size' => $s[0], 'quantity'=>$s[1], 'threshold' => $s[2]);
  }
  return $returnArray;
}

function sizesToString($sizes){
  $sizeString = '';
  foreach ($sizes as $size) {
    $sizeString .= $size['size'].':'.$size['quantity'].':'.$size['threshold'].',';
  }
  $trimmed = rtrim($sizeString, ',');
  return $trimmed;
}

//
// if(!isset($_COOKIE['name'])) {
//        echo "Cookies are not enabled on your browser, please turn them on!";
//    }
