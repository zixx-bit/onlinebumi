
          <?php
            include "core/init.php";



             $output = '';
             // $cat_id = $_POST["id"];
             $sqlSearch = "SELECT * FROM products WHERE title  LIKE '%".$_POST["search"]."%'  LIMIT 5 ";
             $resultSearch = $db->query($sqlSearch);







             if (mysqli_num_rows($resultSearch) > 0)
              {
                $output .= '<h4 align = ""> Search Results </h4>';
                $output .= '
                            <ul class=" list-group search-list" style ="list-style:none; width:auto; ">

                            ';

                while ($row = mysqli_fetch_array($resultSearch))
                  {
                      $photos = explode(',', $row['image']);
                  $output .=


                   '
                   <input type="hidden" id="search_id" name="search_id" value="'.$row["id"].'">

                    <a href="navSearch.php?id='.base64_encode($row["id"]).'"   class="list-group-item" >


                      <img class="" height="auto" width="40px" src="'.$photos[0].'">
                    <span>'.$row["title"].'</span> <span style="margin-left:5px; font-weight:bold;"
                    class="text-primary">'.money($row["price"]).
                     ' </span>
                      </a>
                  ';
                }
                echo $output;

                // echo var_dump($resultSearch);
             }

              else
               {
               echo '<div class="text-danger text-center" style="margin-bottom:10px;">Product not found! Please try again. </div>';
             }

             $output.='</table>
             </div>'
           ?>

           <!-- <script>
           $(document).ready(function(){
               var id = jQuery('#search_id').val();
               var data={"id":id};
               if (data != '')
               {
                 $.ajax({
                   url:"/online store/search.php",
                   method:"post",
                   data:data,
                   // dataType:"text",

                   success:function(data)
                   {
                     // alert("data passed successfully!");
                   }
                 });

               }
               else {
                 alert("something went wrong!");
               }

           });

           </script>
 -->


           <!-- <a href="#"></a> -->
