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
        function checkSession(){
            $.ajax({
                url: "<?php echo base_url('systema/check_session');?>",
                type: "GET",
                success: function(Data){
                        eval(Data);
                    }                
               });  
            setTimeout("checkSession()",5000); 
        }  
        
        // BOOT GRID
        // Refer to http://jquery-bootgrid.com/Documentation for methods, events and settings
        // load gird on page\e load...
        $(function(){
            $("#grid-data").bootgrid(
             {
             caseSensitive:false, 
             formatters: {
             "commands": function(column, row)
                    {
                    return "<button class=\"btn btn-primary btn-xs command-edit\" data-title=\"Edit\" data-toggle=\"modal\" data-target=\"#edit\"><span class=\"glyphicon glyphicon-pencil\" data-row-id=\"" + row.id + "\"></span></button>" +
                    "<button class=\"btn btn-danger btn-xs command-delete\" data-title=\"Delete\" data-toggle=\"modal\" data-target=\"#delete\" ><span class=\"glyphicon glyphicon-trash\" data-row-id=\"" + row.id + "\"></span>";
                    }
                }  
             })
        }); 





        
        function getServerData(){
         console.log("getServerData");
         $("#grid-data").bootgrid(
            { 
                caseSensitive:false
            });
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
        <tr class="clickable-row"> 
            <!-- data-column-id="sender" data-column-id="received" -->
            <th data-column-id="id" data-type="numeric" data-identifier="true" data-order="asc">Id</th>
            <th data-column-id="full_name">Full Name</th>
            <th data-column-id="user_name">User Name</th>
            <th data-column-id="dept_short_desc">Department Desc</th>
            <th data-column-id="store_code">Store Code</th>
            <th data-column-id="date_enter">Date Enter</th>
            <th data-column-id="user_stat">User Stat</th>
            <th data-column-id="commands" data-formatter="commands" data-sortable="false">Commands</th>
            </tr>
    </thead>
    <tbody>
        <?php
            foreach($result_user_maintenance as $row){
        ?>
        <tr>
            <td><?php echo $row->user_id; ?></td>
            <td><?php echo $row->full_name; ?></td>
            <td><?php echo $row->user_name; ?></td> 
            <td><?php echo $row->dept_short_desc; ?></td> 
            <td><?php echo $row->store_code; ?></td>
            <td><?php echo date('Y-m-d',strtotime($row->date_enter)); ?></td>
            <td><?php echo $row->user_stat; ?></td> 
        </tr>
        <?php
            }
        ?>
    </tbody>
    </table>

  </body>
</html>