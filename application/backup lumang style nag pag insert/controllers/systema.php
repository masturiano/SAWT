<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Systema extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        
        # LIBRARY
        $this->load->library('form_validation');
        $this->load->library('pagination'); 
        $this->load->library('table');
        
        # HELPER
        $this->load->helper('url');
        $this->load->helper('path');  
        $this->load->helper('form');      
    }
    
    public function check_session(){
        # CHECK SESSION                 
        if($this->session->userdata('userName') == ""){
            $this->session->sess_destroy();    
            echo "location.href='".base_url()."'";    
        }    
    }
    
    public function user_maintenance(){  
        # TITLE
        $data['title']  = "User Maintenance"; 
        
        # MODULE NAME
        $data['module_name']  = "User Maintenance";   
        
        # MODEL
        $this->load->model('get_system'); 
         
        $data['result_user_maintenance'] = $this->get_system->get_user_maintenance(); 
        
        # VIEW
        $this->load->view('view_user_maintenance',$data);  
    }     
    
    public function add_user(){  
        # MODEL
        $this->load->model('get_system');
        
        # GET GROUP DEPARTMENT
        $result_group_code = $this->get_system->get_user_department(); 
        # GET USER LEVEL
        $result_user_level = $this->get_system->get_user_level(); 
        # GET STORE DETAILS
        $result_store_details = $this->get_system->get_store_details(); 
        
        ?>
        
        <form id="add_form" method="POST">
            <table id="table_add" border="0" class="table table-condensed table-striped">
                <tr>
                    <td class="table_label"><b>Full name</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">
                        <input type="text" class="form-control" name="txt_full_name" id="txt_full_name"
                        style="height:30px; width: 400px;">  
                    </td>
                </tr>
                <tr>
                    <td class="table_label"><b>User name</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">
                        <input type="text" class="form-control" name="txt_user_name" id="txt_user_name"
                        style="height:30px; width: 400px;">  
                    </td>
                </tr>    
                <tr>
                    <td class="table_label"><b>Store</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">
                        <select name="cmd_store_code" id="cmd_store_code"
                        style="height:30px; width: 400px;">   
                            <option value="0">SELECT</option>  
                            <?php foreach($result_store_details as $row){ ?>
                            <option value="<?=$row->store_num;?>"><?=$row->store_code_name;?></option>
                            <? } ?>
                        </select>
                    </td>
                </tr>    
                <tr>
                    <td class="table_label"><b>Group code</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">
                        <select name="cmd_group_code" id="cmd_group_code"
                        style="height:30px; width: 400px;">   
                            <option value="0">SELECT</option>  
                            <?php foreach($result_group_code as $row){ ?>
                            <option value="<?=$row->group_code;?>"><?=$row->dept_desc;?></option>
                            <? } ?>
                        </select>
                    </td>
                </tr> 
                <tr>
                    <td class="table_label"><b>User level</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">
                        <select name="cmd_user_level" id="cmd_user_level"
                        style="height:30px; width: 400px;">   
                            <option value="0">SELECT</option>  
                            <?php foreach($result_user_level as $row){ ?>
                            <option value="<?=$row->level_code;?>"><?=$row->level_desc;?></option>
                            <? } ?>
                        </select>
                    </td>
                </tr> 
                <tr>
                    <td class="table_label"><b>Oracle user name</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">
                        <input type="text" class="form-control" name="txt_ora_user_name" id="txt_ora_user_name"
                        style="height:30px; width: 400px;">  
                    </td>
                </tr>
            </table>    
        </form>
        <?php

    } 
    
    public function adding_user(){  
        # MODEL
        $this->load->model('get_system'); 
        
        //$this->get_system->add_new_user($_POST); 
        $result_current_date_time = $this->get_system->get_server_current_date_time();
        
        if ($result_current_date_time->num_rows() > 0){
           $row = $result_current_date_time->row();
        }
        else{
           $row = "0"; 
        } 
        
        $new_user = array(
            "full_name" => $this->input->post('txt_full_name'), 
            "user_name" => $this->input->post('txt_user_name'),
            "store_code" => $this->input->post('cmd_store_code'),
            "group_code" => $this->input->post('cmd_group_code'),
            "user_level" => $this->input->post('cmd_user_level'),
            "oracle_user_name" => $this->input->post('txt_ora_user_name'),
            "user_pass" => base64_encode($this->input->post('txt_user_name')),
            "pages" => '',
            "date_enter" => $row->current_date_time,
            "date_update" => '',
            "user_stat" => 'A',
            "ip_address" => '',
            "log" => ''
        );
        $this->get_system->add_new_user($new_user);
        echo "New user has been added";
    }
    
    public function delete_user(){  
        ?>
        Are you sure you want to delete user id <?php echo $this->input->post('post_id');?>? 
        <?php
    }
    
    public function deleting_user(){  
        # MODEL
        $this->load->model('get_system');
        $this->get_system->delete_user_id($_POST['post_id']); 
    }
    
    public function edit_user(){  
        # MODEL
        $this->load->model('get_system'); 
        $result_user_details = $this->get_system->get_user_details($this->input->post('post_id'));
         
        if ($result_user_details->num_rows() > 0){
           $row = $result_user_details->row();
        }
        else{
           $row = "0"; 
        }
        
        # GET GROUP DEPARTMENT
        $result_group_code = $this->get_system->get_user_department(); 
        # GET USER LEVEL
        $result_user_level = $this->get_system->get_user_level(); 
        # GET STORE DETAILS
        $result_store_details = $this->get_system->get_store_details(); 
        ?>
        <form id="edit_form" method="POST">
            <table id="table_edit" border="0" class="table table-condensed table-striped">
                <tr>
                    <td class="table_label"><b>User id</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">
                        <?php echo $row->user_id; ?>
                        <input type="hidden" class="form-control" name="txt_user_id" id="txt_user_id" value="<?php echo $row->user_id; ?>"> 
                    </td>
                </tr>

                <tr>
                    <td class="table_label"><b>User name</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">
                        <?php echo $row->user_name; ?>
                        <input type="hidden" class="form-control" name="txt_user_name" id="txt_user_name" value="<?php echo $row->user_name; ?>">
                    </td>
                </tr>
                <tr>
                    <td class="table_label"><b>Full name</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">
                        <input type="text" class="form-control" name="txt_full_name" id="txt_full_name" placeholder="<?php echo $row->full_name; ?>" 
                        style="height:30px; width: 400px;">  
                    </td>
                </tr> 
                <tr>
                    <td class="table_label"><b>Store</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">
                        <select name="cmd_store_code" id="cmd_store_code"
                        style="height:30px; width: 400px;">   
                            <option value="0">SELECT</option>  
                            <?php foreach($result_store_details as $row){ ?>
                            <option value="<?=$row->store_num;?>"><?=$row->store_code_name;?></option>
                            <? } ?>
                        </select>
                    </td>
                </tr>    
                <tr>
                    <td class="table_label"><b>Group code</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">
                        <select name="cmd_group_code" id="cmd_group_code"
                        style="height:30px; width: 400px;">   
                            <option value="0">SELECT</option>  
                            <?php foreach($result_group_code as $row){ ?>
                            <option value="<?=$row->group_code;?>"><?=$row->dept_desc;?></option>
                            <? } ?>
                        </select>
                    </td>
                </tr> 
                <tr>
                    <td class="table_label"><b>User level</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">
                        <select name="cmd_user_level" id="cmd_user_level"
                        style="height:30px; width: 400px;">   
                            <option value="0">SELECT</option>  
                            <?php foreach($result_user_level as $row){ ?>
                            <option value="<?=$row->level_code;?>"><?=$row->level_desc;?></option>
                            <? } ?>
                        </select>
                    </td>
                </tr> 
                <tr>
                    <td class="table_label"><b>User Status</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">
                        <select name="cmd_user_status" id="cmd_user_status"
                        style="height:30px; width: 400px;">    
                            <?php 
                            $user_status = array('A'=>'ACTIVE','I'=>'INACTIVE');
                            ?>
                            <option value="0">SELECT</option> 
                            <option value="A"><?=$user_status['A'];?></option>
                            <option value="I"><?=$user_status['I'];?></option>
                        </select>
                    </td>
                </tr>
            </table>    
        </form>
        <?php

    }
    
    public function editing_user(){  
        # MODEL
        $this->load->model('get_system');
        //$this->get_system->edit_user_id($_POST,$_POST['txt_user_id']); 
        
        $result_current_date_time = $this->get_system->get_server_current_date_time();
        
        if ($result_current_date_time->num_rows() > 0){
           $row = $result_current_date_time->row();
        }
        else{
           $row = "0"; 
        } 
        
        $edit_user = array(
            "full_name" => $this->input->post('txt_full_name'), 
            //"user_name" => $this->input->post('txt_user_name'),
            "store_code" => $this->input->post('cmd_store_code'),
            "group_code" => $this->input->post('cmd_group_code'),
            "user_level" => $this->input->post('cmd_user_level'),
            //"oracle_user_name" => $this->input->post('txt_ora_user_name'),
            //"user_pass" => base64_encode($this->input->post('txt_user_name')),
            //"pages" => '',
            //"date_enter" => $row->current_date_time,
            "date_update" => $row->current_date_time,
            "user_stat" => $this->input->post('cmd_user_status')
            //"ip_address" => '',
            //"log" => ''
        );
        $this->get_system->update_user_id($edit_user,$this->input->post('txt_user_id'));
        echo "User has been edited";
    }
    
}