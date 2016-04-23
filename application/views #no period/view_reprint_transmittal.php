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
                url: "<?php echo base_url('report/check_session');?>",
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
                            return "<?php echo base_url('report/reprint_transmittal');?>" + column.id + ": " + row.id + "</a>";
                        }
                    },
                    rowCount: [10, 50, 75, -1]
                }).on("selected.rs.jquery.bootgrid", function (e, rows) {
                        var value = $("#grid-data").bootgrid("getSelectedRows");
                        if(value.length == 0){
                            $('#btn_print').attr('disabled','disabled'); 
                        }
                        else if(value.length == 1){
                            $('#btn_print').removeAttr('disabled'); 
                        }
                        else{    
                            $('#btn_print').attr('disabled','disabled');
                        }                                                     
                    }).on("deselected.rs.jquery.bootgrid", function (e, rows){
                        var value = $("#grid-data").bootgrid("getSelectedRows");
                        if(value.length == 0){
                            $('#btn_print').attr('disabled','disabled'); 
                        }
                        else if(value.length == 1){
                            $('#btn_print').removeAttr('disabled'); 
                        }
                        else{    
                            $('#btn_print').attr('disabled','disabled');
                        }     
                    }) 
            }
            
            init();    
            
            $("#btn_print").on("click", function ()
            {
                var value = $("#grid-data").bootgrid("getSelectedRows");
                // SELECT TABLE ROW         
                $.ajax({
                    url: "<?php echo base_url('report/generate_reprint_pdf');?>",
                    type: "POST",
                    data: "post_transmittal_number="+value,
                    success: function(data){
                        eval(data);
                        bootbox.alert("Re-Print transmittal success!", function() {  
                        });       
                    }         
                });    
            });  
            
        });       
        
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
            <button id="btn_print" type="button" class="btn btn-default" disabled="disabled">Print</button>                             
                            
            <table id="grid-data" class="table table-condensed table-hover table-striped"
            data-selection="true" 
            data-multi-select="false" 
            data-row-select="true" 
            data-keep-selection="true">
                <thead>
                    <tr class="clickable-row"> 
                        <th data-column-id="transmittal_number" data-identifier="true" data-order="desc">TRANSMITTAL NUMBER</th>
                        <th data-column-id="transmittal_date">TRANSMITTED DATE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($get_all_transmittal as $row){
                    ?>
                    <tr>
                        <td id="<?php echo $row->TRANSMITTAL_NUMBER; ?>"><?php echo $row->TRANSMITTAL_NUMBER; ?></td>
                        <td id="<?php echo $row->TRANSMITTAL_NUMBER; ?>"><?php echo date('Y-m-d',strtotime($row->TRANSMITTED_DATE)); ?></td> 
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table> 
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