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
                    
    <table id="grid-data" class="table table-condensed table-hover table-striped">
    <thead>
        <tr>
            <th data-column-id="id" data-type="numeric" data-identifier="true">ID</th>
            <th data-column-id="sender">Sender</th>
            <th data-column-id="received" data-order="desc">Received</th>
            </tr>
    </thead>
    <tbody>
        <tr>
            <td>00001</td>
            <td>masturiano@puregold.com</td>
            <td>June 24, 1987</td>
        </tr>
        <tr>
            <td>00002</td>
            <td>masturiano@puregold.com</td>
            <td>June 24, 1987</td>
        </tr>
        <tr>
            <td>00003</td>
            <td>masturiano@puregold.com</td>
            <td>June 24, 1987</td>
        </tr>
        <tr>
            <td>00004</td>
            <td>masturiano@puregold.com</td>
            <td>June 24, 1987</td>
        </tr>
        <tr>
            <td>00005</td>
            <td>masturiano@puregold.com</td>
            <td>June 24, 1987</td>
        </tr>
        <tr>
            <td>00006</td>
            <td>masturiano@puregold.com</td>
            <td>June 24, 1987</td>
        </tr>
        <tr>
            <td>00007</td>
            <td>masturiano@puregold.com</td>
            <td>June 24, 1987</td>
        </tr>
        <tr>
            <td>00008</td>
            <td>masturiano@puregold.com</td>
            <td>June 24, 1987</td>
        </tr>
        <tr>
            <td>00009</td>
            <td>masturiano@puregold.com</td>
            <td>June 24, 1987</td>
        </tr>
        <tr>
            <td>00010</td>
            <td>masturiano@puregold.com</td>
            <td>June 24, 1987</td>
        </tr>
        <tr>
            <td>00011</td>
            <td>masturiano@puregold.com</td>
            <td>June 24, 1987</td>
        </tr>
    </tbody>
    </table>
    
    <button onClick="getServerData()">Refresh Data</button> 
    <button onClick="clearGrid()">Clear table</button> 

  </body>
</html>