<!DOCTYPE html>
<html lang="en">
  <head>        
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    
    <title><? echo $title; ?></title>    
        
    <!-- CSS -->
        <!-- Bootstrap Minified Css -->
        <link href="<? echo base_url('includes/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
        <!-- Background -->
        <link href="<? echo base_url('includes/background/css/styles.css'); ?>" rel="stylesheet">
        <!-- My Style CSS -->
        <link href="<? echo base_url('includes/my_style.css'); ?>" rel="stylesheet">   
        <!-- Foo Table 3 -->
        <link href="<? echo base_url('includes/foo_table3/src/css/FooTable.css'); ?>" rel="stylesheet">
        <!-- Menu -->
        <link href="<? echo base_url('includes/menu_sky_blue/menu.css'); ?>" rel="stylesheet">
    
    <!-- JS -->
        <!-- Html 5 Shiv Minified -->
        <script src="<? echo base_url('includes/bootstrap/js/html5shiv.min.js'); ?>"></script>
        <!-- Respond Minified -->
        <script src="<? echo base_url('includes/bootstrap/js/respond.min.js'); ?>"></script> 
        <!-- Jquery Minified Javascript -->
        <script src="<? echo base_url('includes/jquery/js/jquery-1.6.2.min.js'); ?>"></script>
        <script src="<? echo base_url('includes/jquery/js/jquery-ui-1.8.16.custom.min.js'); ?>"></script>
        <!-- Foo Table 3 -->
        <script src="<? echo base_url('includes/foo_table3/src/js/FooTable.js'); ?>"></script>
        <!-- Jquery Running Time -->     
        <script src="<? echo base_url('includes/running_time/running_time.js'); ?>"></script>
        <!-- Menu -->
        <script src="<? echo base_url('includes/menu_sky_blue/jquery.js'); ?>"></script>
        <script src="<? echo base_url('includes/menu_sky_blue/menu.js'); ?>"></script>      
    
  </head>
    <body>
    <body onload="checkSession(); startTime();">
    
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
        
        <div id="menu">
            <ul class="menu">
                <li><a href="<? echo site_url('site/main'); ?>" class="homeIcon" title="Home"><span>Home</span></a>
                </li>
                <li><a href="#" class="parent"><span>Process</span></a>
                    <div>
                        <ul>
                            <li><a href="#"><span>Sub Item 1</span></a></li>
                            <li><a href="#"><span>Sub Item 2</span></a></li>
                            <li><a href="#"><span>Sub Item 3</span></a></li>
                        </ul>
                    </div>
                </li>
                <li><a href="#" class="parent"><span>Report</span></a>
                    <div>
                        <ul>
                            <li><a href="#"><span>Sub Item 1</span></a></li>
                            <li><a href="#"><span>Sub Item 2</span></a></li>
                            <li><a href="#"><span>Sub Item 3</span></a></li>
                        </ul>
                    </div>
                </li>
                <li><a href="#" class="parent"><span>System</span></a>
                    <div>
                        <ul>
                            <li><a href="#"><span>Sub Item 1</span></a></li>
                            <li><a href="#"><span>Sub Item 2</span></a></li>
                            <li><a href="#"><span>Sub Item 3</span></a></li>
                        </ul>
                    </div>
                </li>
                <li><a href="<? echo site_url('site/login'); ?>"><span style="color: red;"><b>Logout</b></span></a>
            </ul>
        </div>   
        
        <div id="currTime">
        </div> 
        
  </body>
</html>