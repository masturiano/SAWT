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
             caseSensitive:false
             })
        });  
        
        // SELECT TABLE ROW
        $(function(){   
            $('#grid-data tbody').on( 'click', 'tr', function () {
                if ($(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
                }
                else {
                    $('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                    $('#edit').removeAttr('disabled');
                    $('#delete').removeAttr('disabled');
                    
                    $(this).addClass('selected').siblings().removeClass('selected');    
                    var value=$(this).find('td:first').html();
                    
                    $.ajax({
                    url: "<?php echo base_url('systema/user_maintenance');?>",
                    type: "GET",
                    data: "id="+value,
                    success: function(){ 
                            deleteUserId(value);     
                        }                
                   });    
                }
            });   
        });  
        
        // DELETE USER ID
        function deleteUserId(value){
            $('#delete').click( function () {  
                bootbox.confirm("Are you sure you want to delete user id #"+value+"?", function(result) {
                    if(result == true){
                        $.ajax({
                            url: "<?php echo base_url('systema/delete_user');?>",
                            type: "GET",
                            data: "id="+value,
                            success: function(){
                               bootbox.alert("Successfully deleted!", function() {
                                    document.location.reload();
                                    $('#edit').attr('disabled','disabled');
                                    $('#delete').attr('disabled','disabled');
                               });
                            }         
                        });     
                    }
                });      
            });  
        } 
        
        // EDIT USER ID
        function editUserId(value){
            $('#edit').click( function () {  
                $.ajax({
                    url: "<?php echo base_url('systema/edit_user');?>",
                    type: "GET",
                    data: "id="+value,
                    success: function(){
                       bootbox.alert("Successfully deleted!", function() {
                            document.location.reload();
                            $('#edit').attr('disabled','disabled');
                            $('#delete').attr('disabled','disabled');
                       });
                    }         
                });  
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
    
    &nbsp;
    <button type="button" id="edit" class="btn btn-primary" disabled="disabled">Edit</button>
    <button type="button" id="delete" class="btn btn-danger" disabled="disabled">Delete</button>
                    
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
            </tr>
    </thead>
    <tbody>
        <?php
            foreach($result_user_maintenance as $row){
        ?>
        <tr>
            <td id="<?php echo $row->user_id; ?>"><?php echo $row->user_id; ?></td>
            <td id="<?php echo $row->user_id; ?>"><?php echo $row->full_name; ?></td>
            <td id="<?php echo $row->user_id; ?>"><?php echo $row->user_name; ?></td> 
            <td id="<?php echo $row->user_id; ?>"><?php echo $row->dept_short_desc; ?></td> 
            <td id="<?php echo $row->user_id; ?>"><?php echo $row->store_code; ?></td>
            <td id="<?php echo $row->user_id; ?>"><?php echo date('Y-m-d',strtotime($row->date_enter)); ?></td>
            <td id="<?php echo $row->user_id; ?>"><?php echo $row->user_stat; ?></td> 
        </tr>
        <?php
            }
        ?>
    </tbody>
    </table>  
    
    <div class="container">
        <h2 style="text-align: center;">Bootstrap 3.1.0 - Modal Demo</h2>
        <div class="row text-center">
            <h3>The Basic Modal</h3>
            <a href="#" class="btn btn-lg btn-success" data-toggle="modal" data-target="#basicModal">Click to open Modal</a>
        </div> 
    </div>
    
    <div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Basic Modal</h4>
          </div>
          <div class="modal-body">
            <h3>Modal Body</h3>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>


  </body>
</html>