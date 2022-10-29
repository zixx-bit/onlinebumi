
  <?php
  $cat_id = ((isset($_REQUEST['cat']))?sanitize($_REQUEST['cat']):'');
 ?>

   <div class="container"> <br>
     <!-- <h2 align="center">Search</h2> -->
     <div class="row">
      <div class="col-md-10">

      <form class="" action="search.php" method="post">


     <div class="form-group">
       <div class="input-group">
         <span class="input-group-addon">Search</span>

         <!-- <input type="hidden" name="cat" id="cat" value="<?=$cat_id;?>"> -->
         <input type="text" name="search_text" id="search_text" placeholder="Search product..." class="form-control text-center" value="" autofocus>
       </div>

     </div> <br>
     <div class="" id="result">
     </div>
        </div>
      </div>


     </div>
     </form>



          <script>
          $(document).ready(function(){
            $('#search_text').keyup(function(){
              var txt = $(this).val();
              // var id = jQuery('#cat').val();
              if (txt != '')
              {
                $.ajax({
                  url:"/online store/fetch.php",
                  method:"post",
                  data:{search:txt},
                  // dataType:"text",

                  success:function(data)
                  {
                    $('#result').html(data);
                  }
                });

              }
              else {
                $('#result').html('');
              }
            });
          });

          </script>
