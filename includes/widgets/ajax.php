<?php

//Including Database configuration file.
// require_once $_SERVER['DOCUMENT_ROOT']. '/online store/core/init.php';
// include "../includes/head.php";
$db=mysqli_connect('localhost', 'root', '', 'onlinestore');
if (mysqli_connect_errno()) {
  echo 'Database connection failed! '
  . mysqli_connect_error();
  die();
}
//Getting value of "search" variable from "script.js".

if (isset($_POST['search'])) {

//Search box value assigning to $Name variable.

   $title = $_POST['search'];

//Search query.

   $Query = "SELECT title FROM products WHERE title LIKE '%$title%' LIMIT 5";

//Query execution

   $ExecQuery =$db->query($Query);

//Creating unordered list to display result.

   echo '

<ul>

   ';

   //Fetching result from database.

   while ($Result = MySQLi_fetch_assoc($ExecQuery)) {

       ?>

   <!-- Creating unordered list items.

        Calling javascript function named as "fill" found in "script.js" file.

        By passing fetched result as parameter. -->

   <li onclick='fill("<?php echo $Result['title']; ?>")'>

   <a>

   <!-- Assigning searched result in "Search box" in "search.php" file. -->

       <?php echo $Result['title']; ?>

   </li></a>

   <!-- Below php code is just for closing parenthesis. Don't be confused. -->

   <?php

}}


?>

</ul>
