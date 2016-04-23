<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Get_system extends CI_Model {
    
    # GET SERVER CURRENT DATE
    function get_server_current_date_time()
    {
        $query_current_date = "
            select GETDATE() as current_date_time
        ";
        return $query = $this->db->query($query_current_date);
    }
    
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
    
    # GET USER DEPARTMENT
    function get_user_department()
    {
        $query_get_user_department = "
            select 
                group_code,dept_desc,dept_short_desc,dept_stat 
            from 
                tbl_department
            where dept_stat = 'A'
        ";
        $query = $this->db->query($query_get_user_department);
        return $query->result();
    }
    
    # GET USER LEVEL
    function get_user_level()
    {
        $query_get_user_level = "
            select 
                level_code,level_desc,level_stat
            from
                tbl_user_level
        ";
        $query = $this->db->query($query_get_user_level);
        return $query->result();
    }
    
    # GET STORE DETAILS
    function get_store_details()
    {
        $query_get_user_level = "
            select 
                a.strnum as store_num,a.stshrt as store_short,cast(a.strnum as nvarchar)+' - '+a.strnam as store_code_name
            from 
                mmpgtlib_tblstr a
            where
                (a.STRNAM NOT LIKE 'X%')
                and (a.STCOMP in (101,102,103,104,105,801,802,803,804,805,806,807,808,700))
                and (a.STRNUM < 900)
            order by 
                a.strnum
        ";
        $query = $this->db->query($query_get_user_level);
        return $query->result();
    }
    
    # ADD NEW USER
    function add_new_user($data){
        echo $this->db->insert("tbl_users", $data);
    }
    
    # DELETE USER ID
    function delete_user_id($post_id)
    {
        $query_delete_user_id = "
            delete 
            from 
                tbl_users
            where 
                user_id = {$post_id}
        ";
        $this->db->query($query_delete_user_id);
    }
           
    # EDIT USER ID
    function edit_user_id($arr,$user_id)
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
                    user_id = {$user_id}     
        ";
        $this->db->query($query_editing_user_id);
    }
    
    function update_user_id($data,$user_id){
        $this->db->update("tbl_users", $data, "user_id = {$user_id}");
    }
    
}
