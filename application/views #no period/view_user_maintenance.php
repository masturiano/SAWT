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
        
        //selection:true,
        //multiSelect: true,
        //rowSelect : true,   
        $(function()
        {
            function init()
            {
                $("#div_disp_data").show();
                $("#grid-data").bootgrid({
                    formatters: {
                        "link": function(column, row)
                        {
                            return "<?php echo base_url('systema/user_maintenance');?>" + column.id + ": " + row.id + "</a>";
                        }
                    },
                    rowCount: [10, 50, 75, -1]
                }).on("selected.rs.jquery.bootgrid", function (e, rows) {
                    var value = $("#grid-data").bootgrid("getSelectedRows");
                    if(value.length == 0){
                        $('#btn_edit').attr('disabled','disabled'); 
                        $('#btn_delete').attr('disabled','disabled'); 
                    }
                    else if(value.length == 1){
                        $('#btn_edit').removeAttr('disabled');
                        $('#btn_delete').removeAttr('disabled'); 
                    }
                    else{    
                        $('#btn_edit').attr('disabled','disabled'); 
                        $('#btn_delete').attr('disabled','disabled'); 
                    }                                                    
                }).on("deselected.rs.jquery.bootgrid", function (e, rows){
                    var value = $("#grid-data").bootgrid("getSelectedRows");
                    if(value.length == 0){
                        $('#btn_edit').attr('disabled','disabled'); 
                        $('#btn_delete').attr('disabled','disabled'); 
                    }
                    else if(value.length == 1){
                        $('#btn_edit').removeAttr('disabled');
                        $('#btn_delete').removeAttr('disabled'); 
                    }
                    else{    
                        $('#btn_edit').attr('disabled','disabled'); 
                        $('#btn_delete').attr('disabled','disabled'); 
                    }       
                })  
            }
            
            init();    
            
            $("#btn_add").on("click", function ()
            {
                var value = $("#grid-data").bootgrid("getSelectedRows");
                // SELECT TABLE ROW         
                $.ajax({           
                    url: "<?php echo base_url('systema/user_maintenance');?>",
                    type: "POST",
                    data: "post_id="+value,
                    success: function(){
                                             
                        $("#div_disp_data").show();  
                        $('#btn_encode').removeAttr('disabled'); 
                        $('#div_encode_sawt').modal('hide');   
                        add_user(value)     
                    }         
                });  
            }); 
            
            $("#btn_edit").on("click", function ()
            {
                var value = $("#grid-data").bootgrid("getSelectedRows");
                // SELECT TABLE ROW         
                $.ajax({           
                    url: "<?php echo base_url('systema/user_maintenance');?>",
                    type: "POST",
                    data: "post_id="+value,
                    success: function(){
                                             
                        $("#div_disp_data").show();  
                        $('#btn_encode').removeAttr('disabled'); 
                        $('#div_encode_sawt').modal('hide');   
                        edit_user(value)     
                    }         
                });  
            });
            
            $("#btn_delete").on("click", function ()
            {
                var value = $("#grid-data").bootgrid("getSelectedRows");
                // SELECT TABLE ROW         
                $.ajax({           
                    url: "<?php echo base_url('systema/user_maintenance');?>",
                    type: "POST",
                    data: "post_id="+value,
                    success: function(){
                                             
                        $("#div_disp_data").show();  
                        $('#btn_encode').removeAttr('disabled'); 
                        $('#div_encode_sawt').modal('hide');   
                        delete_user(value)     
                    }         
                });  
            });
            
        });    
        
        // ADD NEW USER
        function add_user(value){ 
            $.ajax({
                url: "<?php echo base_url('systema/add_user');?>",
                type: "POST",
                success: function(data){   
                   
                    $('#addUser .modal-body').html(data);
                    $('#addUser').modal('show');
                    $('#adding').click( function (e) {  
                        e.stopImmediatePropagation(); 
                       
                        if($('#txt_full_name').val().length == 0){
                            bootbox.alert("Please input Full name!", function() {  
                                $('#txt_full_name').css("border","red solid 1px");  
                            }); 
                            return false;
                        } 
                        else{
                            $('#txt_full_name').css("border","gray solid 1px");    
                        }
                        
                        if($('#txt_user_name').val().length == 0){
                            bootbox.alert("Please input User name!", function() {  
                                $('#txt_user_name').css("border","red solid 1px");  
                            }); 
                            return false;
                        } 
                        else{
                            $('#txt_user_name').css("border","gray solid 1px");    
                        }
                        
                        if($('#cmb_store_code').val() == 0){
                            bootbox.alert("Please select store!", function() {  
                                $('#cmb_store_code').css("border","red solid 1px");  
                            }); 
                            return false;
                        } 
                        else{
                            $('#cmb_store_code').css("border","gray solid 1px");    
                        }
                        
                        if($('#cmb_group_code').val() == 0){
                            bootbox.alert("Please select group code!", function() {  
                                $('#cmb_group_code').css("border","red solid 1px");  
                            }); 
                            return false;
                        } 
                        else{
                            $('#cmb_group_code').css("border","gray solid 1px");    
                        }
                        
                        if($('#cmb_user_level').val() == 0){
                            bootbox.alert("Please select user level!", function() {  
                                $('#cmb_user_level').css("border","red solid 1px");  
                            }); 
                            return false;
                        } 
                        else{
                            $('#cmb_user_level').css("border","gray solid 1px");    
                        }
                        
                        if($('#txt_ora_user_name').val().length == 0){
                            bootbox.alert("Please input Oracle user name!", function() {  
                                $('#txt_ora_user_name').css("border","red solid 1px");  
                            }); 
                            return false;
                        } 
                        else{
                            $('#txt_ora_user_name').css("border","gray solid 1px");    
                        }
                        
                        $.ajax({
                            url: "<?php echo base_url('systema/check_user');?>",
                            type: "POST",
                            data: $('#add_form').serialize(),
                            success: function(data){ 
                                if(data == 1){
                                    bootbox.alert("Username alerady exist!", function() {
                                        $('#txt_user_name').css("border","red solid 1px");  
                                    });  
                                    return false;  
                                }
                                else{
                                    $.ajax({
                                        url: "<?php echo base_url('systema/adding_user');?>",
                                        type: "POST",
                                        data: $('#add_form').serialize(),
                                        success: function(){ 
                                            $('#addUser').modal('hide');  
                                            bootbox.alert("User successfully added!", function() {
                                                $('#btn_edit').attr('disabled','disabled');
                                                $('#btn_delete').attr('disabled','disabled'); 
                                                document.location.reload();
                                            });
                                        }         
                                    });      
                                }  
                            }         
                        });   
                    });
                }         
            });   
        };       
    
        // EDIT USER ID
        function edit_user(value){
            $.ajax({
                url: "<?php echo base_url('systema/edit_user');?>",
                type: "POST",
                data: "post_id="+value,
                success: function(data){   
                   
                    $('#editUser .modal-body').html(data);
                    $('#editUser').modal('show');
                    $('#saving').click( function (e) {
                        e.stopImmediatePropagation(); 
                        $.ajax({
                            url: "<?php echo base_url('systema/editing_user');?>",
                            type: "POST",
                            data: $('#edit_form').serialize()+"&post_id="+value,
                            success: function(){
                                $('#editUser').modal('hide');  
                                bootbox.alert("User successfully edited!", function() {
                                    $('#btn_edit').attr('disabled','disabled');
                                    $('#btn_delete').attr('disabled','disabled'); 
                                    document.location.reload();
                                });
                            }         
                        });   
                    });
                }         
            });  
        } 
        
        // DELETE USER ID
        function delete_user(value){             
            $.ajax({
                cache: false,
                url: "<?php echo base_url('systema/delete_user');?>",
                type: "POST",
                data: "post_id="+value,
                success: function(data){
                                            
                    $('#deleteUser').modal('show');
                    $('#deleteUser .modal-body').html(data); 
                    $('#deleting').click( function (e) {
                        e.stopImmediatePropagation(); 
                        $.ajax({
                            url: "<?php echo base_url('systema/deleting_user');?>",
                            type: "POST",
                            data: "post_id="+value,
                            success: function(){
                                bootbox.alert("User successfully deleted!", function() {
                                    $('#btn_edit').attr('disabled','disabled');
                                    $('#btn_delete').attr('disabled','disabled'); 
                                    document.location.reload();
                                });
                            }         
                        });   
                    });    
                }         
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
    
    <?php 
    if($this->session->userdata('userName') == 'masturiano901'){
        $view_password = "data-visible-in-selection=\"true\"";    
    }
    else{
        $view_password = "data-visible-in-selection=\"false\"";    
    }
    ?>
    
    <div id="container">  
        <div id="div_disp_data" style="display:none;">
            &nbsp;
            <button type="button" id="btn_add" class="btn btn-primary">Add</button>
            <button type="button" id="btn_edit" class="btn btn-primary" disabled="disabled">Edit</button>
            <button type="button" id="btn_delete" class="btn btn-danger" disabled="disabled">Delete</button>
                            
            <table id="grid-data" class="table table-condensed table-hover table-striped"
            data-selection="true" 
            data-multi-select="false" 
            data-row-select="true" 
            data-keep-selection="true">
                <thead>
                    <tr class="clickable-row"> 
                        <!-- data-column-id="sender" data-column-id="received" -->
                        <th data-column-id="id" data-type="numeric" data-identifier="true" data-order="asc" >Id</th>
                        <th data-column-id="full_name">Full Name</th>
                        <th data-column-id="user_name">User Name</th>
                        <th data-column-id="user_pass" data-visible="false" <?=$view_password;?>>User Password</th>
                        <th data-column-id="oracle_user_name">Oracle User Name</th>
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
                        <td id="<?php echo $row->user_id; ?>"><?php echo base64_decode($row->user_pass); ?></td> 
                        <td id="<?php echo $row->user_id; ?>"><?php echo $row->oracle_user_name; ?></td> 
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
    
    <br/><br/>
    <div class="footer_bg">
        <div align="center">
        &copy; 2015 Puregold Price Club Inc. IT-HO Mydel-Ar A. Asturiano All Rights Reserved
        </div>    
    </div> 

    </body>
</html>