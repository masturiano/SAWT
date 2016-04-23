<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Get_system extends CI_Model {
    
    # GET USER MAINTENANCE DETAILS
    function get_user_maintenance()
    {
        $query_get_user_details = "
            select
                a.user_id,a.store_code,a.group_code,a.user_name,
                a.user_pass,a.user_level,a.date_enter,a.date_update,
                case when a.user_stat = 'A' then 'Active' else 'Inactive' end as user_stat,
                a.full_name,a.ip_address,a.log,
                b.dept_desc,b.dept_short_desc
            from 
                tbl_users a
            left join
                tbl_department b on b.group_code = a.group_code
        ";
        $query = $this->db->query($query_get_user_details);
        return $query->result();
    }
    
    # DELETE USER ID
    function delete_user_id($id)
    {
        $query_delete_user_id = "
            delete 
            from 
                tbl_users
            where 
                user_id = {$id}
        ";
        $this->db->query($query_delete_user_id);
    }
    
    # GET USER DETAILS
    function get_user_details($user_id)
    {
        $query_user_detail = "
            SELECT 
                * 
            FROM 
                tbl_users a
            LEFT OUTER JOIN
                tbl_department b ON a.group_code = b.group_code
            WHERE
                user_id = {$user_id} 
        ";
        return $query = $this->db->query($query_user_detail);
    }
    
    # EDITING USER ID
    function editing_user_id($arr)
    {
        echo $query_editing_user_id = "
            update 
                tbl_users
            set 
                full_name = '{$arr['txt_full_name']}',
                store_code = '{$arr['txt_store_code']}',
                group_code = '{$arr['txt_group_code']}',
                user_level = '{$arr['txt_user_level']}',
                user_stat = '{$arr['txt_user_stat']}'
            where 
                    user_id = {$arr['txt_id']}     
        ";
        $this->db->query($query_editing_user_id);
    }
    
    
}
