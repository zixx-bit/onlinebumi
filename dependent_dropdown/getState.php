
<?php
require_once ("dbcontroller.php");
$db_handle = new DBController();

  if (!empty($_POST["country_id"])) {
    $query = "SELECT * FROM state WHERE countryID ='".$_POST['country_id']."' order by
    name asc";
    $results = $db_handle->runQuery($query);
   }

 ?>
 <option value="value disabled selected">Select States</option>
 <?php
      foreach ($results as $state) {
      ?>
      <option value="<?php echo $state['id']; ?>">
        <?php echo $state['name']; ?> </option>
      <?php
      }
  ?>
