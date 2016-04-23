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
                            return "<?php echo base_url('process/encode');?>" + column.id + ": " + row.id + "</a>";
                        }
                    },
                    rowCount: [10, 50, 75, -1]
                }).on("selected.rs.jquery.bootgrid", function (e, rows) {
                        var value = $("#grid-data").bootgrid("getSelectedRows");
                        if(value.length == 0){
                            $('#btn_view').attr('disabled','disabled'); 
                        }
                        else if(value.length == 1){
                            $('#btn_view').removeAttr('disabled'); 
                        }
                        else{    
                            $('#btn_view').attr('disabled','disabled');
                        }                                                     
                    }).on("deselected.rs.jquery.bootgrid", function (e, rows){
                        var value = $("#grid-data").bootgrid("getSelectedRows");
                        if(value.length == 0){
                            $('#btn_view').attr('disabled','disabled'); 
                        }
                        else if(value.length == 1){
                            $('#btn_view').removeAttr('disabled'); 
                        }
                        else{    
                            $('#btn_view').attr('disabled','disabled');
                        }  
                    }) 
            }
            
            init();    
            
            $("#btn_view").on("click", function ()
            {
                var value = $("#grid-data").bootgrid("getSelectedRows");
                // SELECT TABLE ROW         
                $.ajax({           
                    url: "<?php echo base_url('report/unreceive');?>",
                    type: "POST",
                    data: "post_id="+value,
                    success: function(){
                                             
                        $("#div_disp_data").show();  
                        $('#btn_view').removeAttr('disabled'); 
                        $('#div_view_sawt').modal('hide'); 
                        view(value)        
                    }         
                });  
            }); 
            
            $("#btn_print_excel").on("click", function ()
            {
                $.ajax
                ({
                    url: '<? echo site_url('report/generate_unreceive_xls');?>',
                    type: 'POST',  
                    beforeSend: function(data)
                    {
                        $("#btn_print_excel").html('Printing Excel');
                    },
                    success: function(data){ 
                        $("#btn_print_excel").html('Print Excel');
                        eval(data);
                    }
                });  
            }); 
            
            // VIEW RECEIPT NO
            function view(value){

                $.ajax({
                    url: "<?php echo base_url('report/view_export');?>",
                    type: "POST",
                    data: "post_id="+value,
                    success: function(data){   
                        
                        if(value.length > 1){
                            bootbox.alert("Please select one receipt number only!", function() {
                            });    
                            return false;
                        }
                        else{                                 
                            $('#div_view_sawt .modal-body').html(data);
                            $('#div_view_sawt').modal('show');                            
                        }   
                        
                    }         
                }); 
            }     
            
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
    
    <div id="container">  
        <div id="div_disp_data" style="display:none;">
            &nbsp;
            <button id="btn_view" type="button" class="btn btn-default" disabled="disabled">View</button>
            <button id="btn_print_excel" type="button" class="btn btn-default">Print Excel</button>
                            
            <table id="grid-data" class="table table-condensed table-hover table-striped"
            data-selection="true" 
            data-multi-select="false" 
            data-row-select="true" 
            data-keep-selection="true">
                <thead>
                    <tr class="clickable-row"> 
                        <th data-column-id="cash_receipt_id" data-type="numeric" data-identifier="true" data-visible="false" data-visible-in-selection="true" data-order="asc">#</th>
                        <th data-column-id="receipt_number">RECEIPT NUMBER</th>
                        <th data-column-id="receipt_date">RECEIPT DATE</th>
                        <th data-column-id="account_number">ACCOUNT NUMBER</th>
                        <th data-column-id="account_name">ACCOUNT NAME</th>
                        <? // <th data-column-id="receipt_method_id">RECEIPT METHOD ID</th> ?>
                        <? // <th data-column-id="name">NAME</th> ?>
                        <th data-column-id="org_id">ORG ID</th>
                        <th data-column-id="amoount">AMOUNT</th>
                        <? // <th data-column-id="user_stat">USER ID</th> ?>
                        <? // <th data-column-id="user_name">USER NAME</th> ?>
                        <? // <th data-column-id="gl_date">GL DATE</th> ?>
                        <th data-column-id="tin">TIN</th>
                        <th data-column-id="bir_reg_name">BIR REG NAME</th>
                        <th data-column-id="atc_code">ATC CODE</th>
                        <th data-column-id="tax_base">TAX BASE</th>
                        <th data-column-id="gl_date_sawt">SAWT GL DATE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($get_unreceive as $row){
                    ?>
                    <tr>
                        <td id="<?php echo $row->CASH_RECEIPT_ID; ?>"><?php echo $row->CASH_RECEIPT_ID; ?></td>
                        <td id="<?php echo $row->CASH_RECEIPT_ID; ?>"><?php echo $row->RECEIPT_NUMBER; ?></td>
                        <td id="<?php echo $row->CASH_RECEIPT_ID; ?>"><?php echo date('Y-m-d',strtotime($row->RECEIPT_DATE)); ?></td> 
                        <td id="<?php echo $row->CASH_RECEIPT_ID; ?>"><?php echo $row->ACCOUNT_NUMBER; ?></td> 
                        <td id="<?php echo $row->CASH_RECEIPT_ID; ?>"><?php echo $row->ACCOUNT_NAME; ?></td>
                        <? // <td id="<?php echo $row->CASH_RECEIPT_ID; ">?><?php //echo $row->RECEIPT_METHOD_ID; ?><? //</td> ?>
                        <? // <td id="<?php echo $row->CASH_RECEIPT_ID; ">?><?php //echo $row->NAME; ?><? //</td> ?>  
                        <?php
                        # GET USER STATUS SELECTED
                        $result_company = $this->get_report->get_company($row->ORG_ID); 
                        if ($result_company->num_rows() > 0){
                           $row_company = $result_company->row();
                        }
                        ?>
                        <td id="<?php echo $row->CASH_RECEIPT_ID; ?>"><?php echo $row_company->comp_short; ?></td>      
                        <td id="<?php echo $row->CASH_RECEIPT_ID; ?>"><?php echo $row->AMOUNT; ?></td>    
                        <? // <td id="<?php echo $row->CASH_RECEIPT_ID; ">?><?php //echo $row->USER_ID; ?><? //</td> ?> 
                        <? // <td id="<?php echo $row->CASH_RECEIPT_ID; ">?><?php //echo $row->USER_NAME; ?><? //</td> ?>
                        <? // <td id="<?php echo $row->CASH_RECEIPT_ID; ">?><?php //echo date('Y-m-d',strtotime($row->GL_DATE)); ?><? //</td> ?>
                        <td id="<?php echo $row->CASH_RECEIPT_ID; ?>"><?php echo $row->TIN; ?></td> 
                        <td id="<?php echo $row->CASH_RECEIPT_ID; ?>"><?php echo $row->BIR_REG_NAME; ?></td> 
                        <td id="<?php echo $row->CASH_RECEIPT_ID; ?>"><?php echo $row->ATC_CODE; ?></td> 
                        <td id="<?php echo $row->CASH_RECEIPT_ID; ?>"><?php echo $row->TAX_BASE; ?></td> 
                        <td id="<?php echo $row->CASH_RECEIPT_ID; ?>"><?php echo date('Y-m-d',strtotime($row->GL_DATE_SAWT)); ?></td> 
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table> 
        </div> 
        
        <div class="modal fade" id="div_view_sawt" tabindex="-1" role="dialog" aria-labelledby="div_view_sawt" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">View</h4>
              </div>
              <div class="modal-body">
              </div>
              <div class="modal-footer">
                <button type="button" id="save_close" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div> 
        
    </div>

  </body>
</html>