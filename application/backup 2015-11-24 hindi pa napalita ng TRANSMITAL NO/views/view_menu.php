<table id="table_user_info" border = 0>
    <tr>
        <td id="user_label">
            <b>User</b>
        </td>
        <td class="colon">
            <b>:</b>
        </td> 
        <td id="user_full_name">
            <?php 
                $session_full_name = $this->session->userdata('fullName');
                echo $session_full_name;
                //echo print_r($this->session->all_userdata()); // # CHECK THE LIST OF SESSIONS
            ?> 
        </td>
    </tr>
    <tr>
        <td id="module_label">
            <b>Department</b>
        </td>
        <td class="colon">
            <b>:</b>
        </td>
        <td id="module_name">
            <?php 
                $session_dept_short_desc = $this->session->userdata('deptShortDesc');
                echo $session_dept_short_desc;
            ?> 
        </td>
    </tr>
    <tr>
        <td id="module_label">
            <b>Module</b>
        </td>
        <td class="colon">
            <b>:</b>
        </td>
        <td id="module_name">
            <?php 
                echo $module_name;
            ?> 
        </td>
    </tr>
    <tr>
        <td id="cur_date_label">
            <b>Date</b>
        </td>
        <td class="colon">
            <b>:</b>
        </td>
        <td id="cur_date_display">
            <?php 
                $current_date = date('F d, Y');
                echo $current_date;
                //echo print_r($this->session->all_userdata()); // # CHECK THE LIST OF SESSIONS
            ?> 
        </td>
    </tr>
    <tr>
        <td id="cur_time_label">
            <b>Time</b>
        </td>
        <td class="colon">
            <b>:</b>
        </td>
        <td id="cur_time_display">
            <div id="currTime">
            </div> 
        </td>
    </tr>
</table>
        
<?php
# SESSION DISPLAY
$session_store_code = $this->session->userdata('storeCode');    
$session_group_code = $this->session->userdata('groupCode');        
$session_user_level = $this->session->userdata('userLevel');        
?>        
        
<div id="menu">
    <ul class="menu">
        <li>
            <a href="<? echo site_url('site/main'); ?>" class="homeIcon" title="Home"><span>Home</span></a>
        </li>
        <li><a href="#" class="parent"><span>Process</span></a>
            <div> 
                <?php     
                if($session_store_code == 901){
                ?> 
                    <ul>
                        <?php   
                        # RESTRICT DEPARTMENT DEPARTMENT
                        # 1 = MIS
                        if(
                            ($session_group_code != 1)
                            && 
                            ($session_user_level == 2)
                        ){
                        ?>
                        <li><a href="<? echo site_url('process_ho/encode'); ?>" class="homeIcon" title="Home"><span>Encode</span></a></li>
                        <?php
                        }
                        ?>
                        <?php   
                        # ALLOW DEPARTMENT
                        # 4 = ACCOUNTING
                        if(
                            ($session_group_code == 4)
                            && 
                            ($session_user_level == 2)
                        ){
                        ?>
                            <li><a href="<? echo site_url('process_ho/receive'); ?>" class="homeIcon" title="Home"><span>Receive</span></a></li>
                            <li><a href="<? echo site_url('process_ho/received_edit'); ?>" class="homeIcon" title="Home"><span>Received Edit</span></a></li>
                            <li><a href="<? echo site_url('process_ho/post'); ?>" class="homeIcon" title="Home"><span>BIR File Creation</span></a></li>    
                        <?php
                        }
                        ?>
                        
                    </ul>
                    <?php
                }
                else{
                    ?>
                    <ul>
                        <li><a href="<? echo site_url('process/encode'); ?>" class="homeIcon" title="Home"><span>Encode</span></a></li>
                    </ul> 
                <?php    
                }
                ?>   
            </div>
        </li>
        <li><a href="#" class="parent"><span>Report</span></a>
            <div>
                <ul>   
                    <?php   
                    # RESTRICT DEPARTMENT DEPARTMENT
                    # 1 = MIS
                    if(
                        ($session_group_code != 1)
                        && 
                        ($session_user_level == 2)
                    ){
                    ?>
                    <li><a href="<? echo site_url('report/cancelled'); ?>" class="homeIcon" title="Home"><span>Cancelled</span></a></li>   
                    <li><a href="<? echo site_url('report/not_transmit'); ?>" class="homeIcon" title="Home"><span>Not Transmit</span></a></li> 
                    <?php
                    }
                    ?>  
                    <?php   
                    # ALLOW DEPARTMENT
                    # 4 = ACCOUNTING
                    if(
                        ($session_group_code == 4) || ($session_group_code == 5)
                        && 
                        ($session_user_level == 2)
                    ){
                    ?>   
                    <li><a href="<? echo site_url('report/unreceive'); ?>" class="homeIcon" title="Home"><span>Unreceive</span></a></li>                
                    <li><a href="<? echo site_url('report/received'); ?>" class="homeIcon" title="Home"><span>Received</span></a></li>   
                    <li><a href="<? echo site_url('report/post'); ?>" class="homeIcon" title="Home"><span>BIR File Creation</span></a></li> 
                    <?php
                    }
                    ?>   
                </ul>
            </div>
        </li>
        <li><a href="#" class="parent"><span>System</span></a>
            <div>
                <ul>
                    <?
                    # ALLOW DEPARTMENT
                    # 1 = MIS
                    if($session_group_code == 1 && $session_user_level == 1){    
                    ?>
                    <li><a href="<? echo site_url('systema/user_maintenance'); ?>" class="homeIcon" title="Home"><span>User Maintenance</span></a></li>
                    <li><a href="<? echo site_url('systema/oracle_data'); ?>" class="homeIcon" title="Home"><span>Oracle Data</span></a></li>
                    <?php
                    }
                    ?>
                    <li><a href="<? echo site_url('systema/change_password'); ?>" class="homeIcon" title="Home"><span>Change Password</span></a></li>
                </ul>
            </div>
        </li>
        <li><a href="<? echo site_url('site/login'); ?>"><span style="color: red;"><b>Logout</b></span></a>
    </ul>
</div>   

<div id="currTime">
</div> 
