<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Get_report extends CI_Model {
    
    # GET UNRECEIVE
    function get_unreceive($user_name)
    {   
        # FILTER NOT YET TRANSMITTED
        $filter_user = "and USER_NAME = '{$user_name}'";
             
        $query = "
            select 
                    CASH_RECEIPT_ID,RECEIPT_NUMBER,RECEIPT_DATE,ACCOUNT_NUMBER,ACCOUNT_NAME,
                    RECEIPT_METHOD_ID,NAME,ORG_ID,AMOUNT,USER_ID,USER_NAME,GL_DATE,TIN,
                    BIR_REG_NAME,ATC_CODE,TAX_BASE,IS_TRANSMITTED,TRANSMITTED_DATE,
                    IS_RECEIVED,RECEIVED_DATE,ORA_CREATION_DATE,SAWT_EXTRACT_DATE,
                    IS_BIR_POSTED,BIR_POSTED_DATE,FXF1,FXF2,FXF3,FXF4,FXF5,
                    GL_DATE_SAWT
            from 
                    tbl_export
            where
                    IS_TRANSMITTED = 'Y'
                    and IS_RECEIVED is null
                    {$filter_user}
            order by
                    ACCOUNT_NUMBER,ACCOUNT_NAME,RECEIPT_NUMBER,RECEIPT_DATE    
        ";
        $query = $this->db->query($query);
        return $query->result();
    }
    
    # GET FILTER COMPANY
    function get_company($org_id)
    {
        $query_get_company = "
            select 
                org_id,comp_name,comp_short 
            from
                tbl_company
            where 
                org_id = {$org_id}
        ";
        return $query = $this->db->query($query_get_company);
    }  
    
}
