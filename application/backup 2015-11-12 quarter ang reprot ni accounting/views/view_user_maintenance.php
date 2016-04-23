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
                type: "POST",
                success: function(Data){
                        eval(Data);
                    }                
               });  
            setTimeout("checkSession()",10000); 
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
            $.ajax({
                url: "<?php echo base_url('systema/user_maintenance');?>",
                type: "POST",
                success: function(){
 
                    $("#div_disp_data").show();
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
                            type: "POST",
                            data: "id="+value,
                            success: function(){ 
                                    editUserId(value);
                                    deleteUserId(value);     
                                }                
                           });    
                        }
                    });       
                    
                }         
            });  
        }); 
        
        // ADD NEW USER
        $(function(){ 
            $('#add').click( function () {  
                $.ajax({
                    url: "<?php echo base_url('systema/add_user');?>",
                    type: "POST",
                    success: function(data){   
                       
                        $('#addUser .modal-body').html(data);
                        $('#addUser').modal('show');
                        $('#adding').click( function () {
                           $.ajax({
                                url: "<?php echo base_url('systema/adding_user');?>",
                                type: "POST",
                                data: $('#add_form').serialize(),
                                success: function(){
                                    $('#addUser').modal('hide');  
                                    $('#edit').attr('disabled','disabled');
                                    $('#delete').attr('disabled','disabled'); 
                                    document.location.reload();
                                }         
                            });   
                        });
                        $('#save_close').click( function () {
                            $('#edit').attr('disabled','disabled');
                            $('#delete').attr('disabled','disabled'); 
                            document.location.reload();
                        });
                        
                    }         
                });  
            });  
        });       
    
        // DELETE USER ID
        function deleteUserId(value){
            $('#delete').click( function () { 
                                 
                $.ajax({
                    cache: false,
                    url: "<?php echo base_url('systema/delete_user');?>",
                    type: "POST",
                    data: "post_id="+value,
                    success: function(data){
                                                
                        $('#deleteUser').modal('show');
                        $('#deleteUser .modal-body').html(data); 
                        $('#deleting').click( function () {
                           $.ajax({
                                url: "<?php echo base_url('systema/deleting_user');?>",
                                type: "POST",
                                data: "post_id="+value,
                                success: function(){
                                    $('#deleteUser').modal('hide');  
                                    $('#edit').attr('disabled','disabled');
                                    $('#delete').attr('disabled','disabled'); 
                                    document.location.reload(); 
                                }         
                            });   
                        });
                        $('#delete_close').click( function () {
                            $('#edit').attr('disabled','disabled');
                            $('#delete').attr('disabled','disabled'); 
                            document.location.reload();     
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
                    type: "POST",
                    data: "post_id="+value,
                    success: function(data){   
                       
                        $('#editUser .modal-body').html(data);
                        $('#editUser').modal('show');
                        $('#saving').click( function () {
                           $.ajax({
                                url: "<?php echo base_url('systema/editing_user');?>",
                                type: "POST",
                                data: $('#edit_form').serialize()+"&post_id="+value,
                                success: function(){
                                    $('#editUser').modal('hide');  
                                    $('#edit').attr('disabled','disabled');
                                    $('#delete').attr('disabled','disabled'); 
                                    document.location.reload();
                                }         
                            });   
                        });
                        $('#save_close').click( function () {
                            $('#edit').attr('disabled','disabled');
                            $('#delete').attr('disabled','disabled'); 
                            document.location.reload();         
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
    
    <div id="container">  
        <div id="div_disp_data" style="display:none;">
            &nbsp;
            <button type="button" id="add" class="btn btn-primary">Add</button>
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
                        <th data-column-id="date_enter">Date / Time Enter</th>
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
                        <td id="<?php echo $row->user_id; ?>"><?php echo date('Y-m-d H:i:s',strtotime($row->date_enter)); ?></td>
                        <td id="<?php echo $row->user_id; ?>"><?php echo $row->user_stat; ?></td> 
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table> 
        </div>    
        
        <div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="addUser" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Add User</h4>
              </div>
              <div class="modal-body">
              </div>
              <div class="modal-footer">
                <button type="button" id="save_close" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="adding" class="btn btn-primary">Save</button>
              </div>
            </div>
          </div>
        </div>
        
        <div class="modal fade" id="deleteUser" tabindex="-1" role="dialog" aria-labelledby="deleteUser" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-body">
              </div>
              <div class="modal-footer">
                <button type="button" id="delete_close" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="deleting" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </div>
        </div>
    
        <div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="editUser" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Edit User</h4>
              </div>
              <div class="modal-body">
              </div>
              <div class="modal-footer">
                <button type="button" id="save_close" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="saving" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </div>
        </div>
    
    </div>    

    </body>
</html>