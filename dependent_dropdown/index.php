<?php
  require_once("dbcontroller.php");
  $db_handle = new DBController();
  $query = "SELECT * FROM country";
  $results = $db_handle->runQuery($query);
  // var_dump($results);
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>

  <style type="text/css">
          body{
            width: 800px;
            font-family: calibri;
            padding: 0;
            margin: 0 auto;
          }
          .frm{
            border: 1px solid #7ddaff;
            background-color: #b4c8d0;
            margin: 0px auto;
            padding: 40px;
            border-radius: 4px;
          }
          .InputBox{
            padding: 10px;
            border: #bdbdbd 1px solid;
            border-radius: 4px;
            background-color: #fff;
            width: 50%;
          }
          .row{
            padding-bottom: 15px;
            padding-left: 150px;
          }

  </style>
      <script src="jquery.main.js" type="text/javascript" ></script>
      <script type="text/javascript">

          function getState(val){
            $.ajax({
              type: "POST",
              url: "getState.php",
              data: 'country_id='+val,
              success:function(data){
                $("#state-list").html(data),
                getCity();
              }
            });
          }

          function getCity(val){
            $.ajax({
              type:"POST",
              url:"getCity.php",
              data:'state_id='+val,
              success:function(data){
                $("#city-list").html(data);
              }
            });
          }
      </script>

  <body>
    <div class="frm">
      <h2> Depend dropdown List - Countries, State and Cities</h2>
      <div class="row">
        <form class="" action="index.html" method="post">

        <label for="">Country:</label><br>
        <select class="InputBox" name="country" id="country-list"
        onChange="getState(this.value);">
          <option value disabled selected>Select Country</option>
          <?php
              foreach ($results as $country) {
                ?>
              <option value="<?php echo $country['id'];?>">
                 <?php echo $country['country_name']; ?></option>
              <?php
              }
              ?>
        </select>
      </div>

      <div class="row">
        <label for="">State:</label><br>
        <select class="InputBox" name="state" id="state-list"
        onChange="getCity(this.value);">
          <option value="">Select state</option>
        </select>
      </div>

      <div class="row">
        <label for="">City:</label><br>
        <select class="InputBox" name="city" id="city-list">
          <option value="">Select City</option>
        </select>
        <input type="text" name="county" value="">

      </div>
    </div>
</form>


<!-- insert form -->
    <div class="">
      <form class="" action="index.html" method="post">
        <select class="" name="city">
          <option value="Kisii">Kisii</option>
          <option value="Nyamira">Nyamira</option>
          <option value="migori">Migori</option>

        </select>
        <input type="submit" name="submit" value="">

      </form>
    </div>



    <div class="">
      <form class="" action="" method="post">
        <input type="text" name="county" value="">
         <select class="city" name="city">
          <option value="">Select City</option>
          <?php
            $query="SELECT * FROM city";
            // $result = $conn->query($query);
              $results = $db_handle->runQuery($query);
            if ($results -> num_rows>0) {
              while ($optionData = $results->fetch_assoc()) {
                  $option = $optionData['name'];

              ?>
            <?php
            // selected option
            if (!empty($city)&& $city==$option) {
              // selected option
              ?>
          <option value="<?php echo $option; ?>" selected>
             <?php echo $option; ?></option>
          <?php
          continue;
          }?>

          <option value="<?php echo $option; ?>">
            <?php echo $option; ?> </option>
          <?php
          }}
           ?>
          </select>
          <br>
          <input type="submit" name="submit" value="">
      </form>

    </div>

  </body>
</html>
