<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    
    <title><? echo $title; ?></title>
    
    <?php 
    include('view_includes.php');
    ?>
        
    <!-- Javascript -->
    <script type="text/javascript">     
        // CHECK SESSION
        function checkSession() {
            $.ajax({
                url: "<?php echo base_url();?>site/check_session",
                type: "GET",
                success: function(Data){
                        eval(Data);
                    }                
               });  
            setTimeout("checkSession()",5000); 
        }  
        
        // Refer to http://jquery-bootgrid.com/Documentation for methods, events and settings
        // load gird on page\e load...
        $(function(){  
            $("#grid-data").bootgrid(
             {
             caseSensitive:false    
             });
        });  
        
        function getServerData()
        {
         console.log("getServerData");
         $("#grid-data").bootgrid({ caseSensitive:false});
        }
        
        function clearGrid()
        {
        console.log("clearGrid");
        $("#grid-data").bootgrid().clear();
        }
    
    </script>  
        
  </head>

  <body onload=" checkSession(); startTime();">
  
    <div class="header_bg">
    </div>
    <div class="header_logo">
    </div>
    
    <?php 
    include('view_menu.php');
    ?>
    
    <div class="header_bg_down">
    </div>
                    
    
    <div class="footer_bg">
        <div align="center">
        &copy; 2015 Puregold Price Club Inc. IT-HO Mydel-Ar A. Asturiano All Rights Reserved
        </div>    
    </div> 

  </body>
</html>