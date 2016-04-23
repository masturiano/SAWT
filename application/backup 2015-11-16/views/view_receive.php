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
                url: "<?php echo base_url('process_ho/check_session');?>",
                type: "POST",
                success: function(Data){
                        eval(Data);
                    }                
               });  
            setTimeout("checkSession()",10000); 
        }  
        
        // ON FIRST LOAD
        $(function(){       
            value = $('#cmd_company').val() 
            $.ajax({           
                url: "<?php echo base_url('process_ho/receive_per_company');?>",
                type: "POST",
                data: "post_org_id="+value,
                success: function(data){   
                    $('#div_disp_grid').html(data);        
                }         
            });  
        }); 
        
        // ON CHANGE COMPANY DROPDOWN
        $(function(){   
            $('#cmd_company').change(function() {
                $('#grid-data').bootgrid('reload');
                value = $(this).val();
                $.ajax({           
                    url: "<?php echo base_url('process_ho/receive_per_company');?>",
                    type: "POST",
                    data: "post_org_id="+value,
                    success: function(data){   
                        $('#div_disp_grid').html(data);         
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
        <div id="div_disp_data">  
        &nbsp;
            <div align="center">
                <? # ALLOW DEPARTMENT MIS,ACCOUNTING ?>
                <? if($this->session->userdata('groupCode') == 1 || $this->session->userdata('groupCode') == 4){ ?>     
                <table id="table_company" border=0>
                    <tr>
                        <td class="table_label">
                            COMPANY
                        </td>
                        <td class="table_colon">:</td>
                        <td class="table_data">
                            <select name="cmd_company" id="cmd_company"
                            style="height:30px; width: 400px;">   
                                <option value="0">SELECT COMPANY</option>  
                                <?php foreach($get_all_company as $row){ ?>
                                <option value="<?=$row->org_id;?>"><?=$row->comp_name;?></option>
                                <? } ?>
                            </select> 
                        </td>
                    </tr>
                </table>
                <? } ?>
            </div> 
        </div>
        
        <div id="div_disp_grid">   
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
    
        <div class="modal fade" id="div_encode_sawt" tabindex="-1" role="dialog" aria-labelledby="div_encode_sawt" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Encode</h4>
              </div>
              <div class="modal-body">
              </div>
              <div class="modal-footer">
                <button type="button" id="save_close" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="saving" class="btn btn-primary">Save</button>
              </div>
            </div>
          </div>
        </div>
        
        <div class="modal fade" id="div_receive_confirm" tabindex="-1" role="dialog" aria-labelledby="div_transmit_sawt" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-body">
              </div>
              <div class="modal-footer">
                <button type="button" id="receive_confirm_close" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="receiving_confirm" class="btn btn-primary">Save</button>
              </div>
            </div>
          </div>
        </div>
        
        <div class="modal fade" id="div_save_confirm" tabindex="-1" role="dialog" aria-labelledby="div_save_confirm" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-body">
              </div>
              <div class="modal-footer">
                <button type="button" id="save_confirm_close" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="saving_confirm" class="btn btn-primary">Save</button>
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