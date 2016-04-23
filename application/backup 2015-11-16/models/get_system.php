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
                and (a.STRNUM < 902)
            order by 
                a.strnum
        ";
        $query = $this->db->query($query_get_user_level);
        return $query->result();
    }
    
    # GET USER STATUS
    function get_user_status()
    {
        $query_get_user_status = "
            select 
                user_stat,user_status_description
            from 
                tbl_user_status
        ";
        $query = $this->db->query($query_get_user_status);
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
    function edit_user_id($data,$user_id){
        $this->db->update("tbl_users", $data, "user_id = {$user_id}");
    }
    
    # EDIT USER ID GET STORE DETAILS SELECTED
    function get_store_details_selected($user_id)
    {
        $query_get_user_level = "
            select 
                b.strnum as store_num,b.stshrt as store_short,cast(b.strnum as nvarchar)+' - '+b.strnam as store_code_name 
            from 
                tbl_users a
            inner join 
                mmpgtlib_tblstr b on b.strnum = a.store_code
            where 
                user_id = {$user_id}
        ";
        return $query = $this->db->query($query_get_user_level);
    }
    
    # EDIT USER ID GET USER DEPARTMENT SELECTED
    function get_user_department_selected($user_id)
    {
        $query_get_user_department = "
            select 
                b.group_code,b.dept_desc,b.dept_short_desc,b.dept_stat 
            from 
                tbl_users a
            left join tbl_department b on b.group_code = a.group_code
            where
                a.user_id = {$user_id}
        ";
        return $query = $this->db->query($query_get_user_department);
    }
    
    # EDIT USER ID GET USER LEVEL SELECTED
    function get_user_level_selected($user_id)
    {
        $query_get_user_level = "
            select 
                b.level_code,b.level_desc,b.level_stat
            from 
                tbl_users a
            left join tbl_user_level b on b.level_code = a.user_level
            where
                a.user_id = {$user_id}
        ";
        return $query = $this->db->query($query_get_user_level);
    }  
    
    # EDIT USER GET USER STATUS
    function get_user_status_selected($user_id)
    {
        $query_get_user_status = "
            select 
                b.user_stat,b.user_status_description
            from 
                tbl_users a
            inner join tbl_user_status b on b.user_stat = a.user_stat
            where
                a.user_id = {$user_id}
        ";
        return $query = $this->db->query($query_get_user_status);
    }  
    
    # EDIT USER PASSWORD   
    function edit_user_password($data,$user_id){
        $this->db->update("tbl_users", $data, "user_name = '{$user_id}'");
    }
    
    # COPY ORACLE DATA
    function get_oracle_data($date_from,$date_to)
    {
        $query_get_oracle_data = "
            IF OBJECT_ID('tbl_oracle_temp', 'U') IS NOT NULL
            BEGIN
            DROP TABLE tbl_oracle_temp
            END
            -- INSERT INTO TEMP TABLE
            BEGIN
                -- CURRENT DATE
                DECLARE @Current_Date varchar(MAX)
                select @Current_Date = CONVERT(char(10), GetDate(),126)
                --Select @Current_Date as 'Current_Date' -- to view the date
                -- PREVIOUS 2 DAYS
                DECLARE @Previous_Two_Days varchar(MAX)
                select @Previous_Two_Days = CONVERT(char(10), DATEADD(DAY,-2,GetDate()),126)
                --Select @Prev_Two_Days as 'Prev_Two_Days' -- to view the date
                DECLARE @TSQL varchar(8000)
                select @TSQL = ' 
                select 
                    CASH_RECEIPT_ID,RECEIPT_NUMBER,RECEIPT_DATE,ACCOUNT_NUMBER,ACCOUNT_NAME,
                    RECEIPT_METHOD_ID,NAME,ORG_ID,AMOUNT,USER_ID,USER_NAME,GL_DATE,GL_DATE_SAWT
                into tbl_oracle_temp
                from openquery([192.168.200.136],''
                    SELECT acr.CASH_RECEIPT_ID,
                        acr.RECEIPT_NUMBER,
                        acr.RECEIPT_DATE,
                        a.ACCOUNT_NUMBER,
                        a.ACCOUNT_NAME,
                        acr.RECEIPT_METHOD_ID,
                        b.NAME,
                        acr.ORG_ID,
                        acr.AMOUNT,
                        fnd_user.USER_ID,
                        fnd_user.USER_NAME,
                        arp.GL_DATE,
                        arp.GL_DATE as GL_DATE_SAWT
                    FROM fnd_user,
                        ar_cash_receipts_all acr,
                        hz_cust_accounts a,
                        AR_RECEIPT_METHODS b,
                        ar_payment_schedules_all arp
                    WHERE acr.PAY_FROM_CUSTOMER = a.CUST_ACCOUNT_ID
                        AND acr.RECEIPT_METHOD_ID   = b.RECEIPT_METHOD_ID
                        AND acr.CREATED_BY          = fnd_user.USER_ID
                        AND acr.CASH_RECEIPT_ID     = arp.CASH_RECEIPT_ID
                        AND (b.NAME LIKE ''''%230%''''
                        AND acr.ORG_ID IN (85,87,113,133,153))
                        AND acr.RECEIPT_DATE between ''''{$date_from}'''' and ''''{$date_to}''''    
                    ORDER BY acr.ORG_ID,
                        a.ACCOUNT_NUMBER,
                        acr.CASH_RECEIPT_ID
                '')' 
                EXEC (@TSQL)
            END
            BEGIN
                insert into 
                    tbl_export(
                    CASH_RECEIPT_ID,RECEIPT_NUMBER,RECEIPT_DATE,ACCOUNT_NUMBER,ACCOUNT_NAME,
                    RECEIPT_METHOD_ID,NAME,ORG_ID,AMOUNT,USER_ID,USER_NAME,GL_DATE,GL_DATE_SAWT
                    )
                select 
                    CASH_RECEIPT_ID,RECEIPT_NUMBER,RECEIPT_DATE,ACCOUNT_NUMBER,ACCOUNT_NAME,
                    RECEIPT_METHOD_ID,NAME,ORG_ID,AMOUNT,USER_ID,USER_NAME,GL_DATE,GL_DATE_SAWT
                from tbl_oracle_temp
                where 
                    CASH_RECEIPT_ID not in (
                            select CASH_RECEIPT_ID from tbl_export
                    )
                    and CASH_RECEIPT_ID not in (
                            select CASH_RECEIPT_ID from tbl_export_cancelled
                    )
            END    
        ";
        $query = $this->db->query($query_get_oracle_data);
    } 
    
    
}
