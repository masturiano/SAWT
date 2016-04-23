<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Get_excel extends CI_Model {
    
    # CREATE XLS DATA
    function get_xls_data($card_type,$date_from,$date_to)    
    {
        # DATE RANGE
        //$date_from = date('mdy',strtotime($arr['datepicker_from']));
        //$date_to = date('mdy',strtotime($arr['datepicker_to']));
        
        # TYPE OF CARD
        //$card_type = $arr['cmb_card_typ'];
        /*
        if($card_type == 'Perks'){
            $db_crm = "MatrixCRM_Puregold";
            $db_data_eight = "Perks";
        }
        else if($card_type == 'Tnap'){
            $db_crm = "MatrixCRM_TNAP";  
            $db_data_eight = "TNAP";  
        }
        else{
            $db_crm = "";
            $db_data_eight = "";
        }
        */
        #FILE INFO
        
        //$fileExt = ".xls";
        //$filename = $db_data_eight."CRM_VS_DATAEIGHT_".$date_from."_".$date_to.$fileExt;
        //$fileDesti = "C:\wamp\\www\\Data8VsCRM\\export_files\\";
        //$fileDesti = "C:\\Data8VsCRM_Exportedfile\\";
        
        $query = "
            SELECT 
                RECEIPT_NO,STORE,REG,TRX,TRXDATE
            FROM 
                Perks.dbo.data8vscrm_view
        ";   
        $data =  $this->db->query($query);   
        return $data->result();    
    }
    
}
