<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Get_tools extends CI_Model {
    
    # DROP DOWN MENU
    
    function DropDownMenu($arrRes,$id,$selected='',$attr){
        echo "<select id=\"$id\" name=\"$id\" $attr>\n";
            foreach ((array)$arrRes as $index => $value){
                echo "<option value=\"$index\" ";
                if($index == $selected){
                    
                    echo "selected=\"selected\">\n";
                }
                else{
                    echo " >\n";
                }
                    echo ucwords(strtoupper($value))."\n";
                echo "</option>\n";
            }
        echo "</select>\n";
    }
    
}
