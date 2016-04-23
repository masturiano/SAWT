<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');    

class perks_tnap_excel extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        
        # LIBRARY
        $this->load->library('form_validation');
        $this->load->library('session');
        
        # INCLUDE FILE
        ini_set('include_path','C:\wamp\php\PEAR');
        require_once 'Spreadsheet/Excel/Writer.php';
    }
    
    function print_excel($card_type,$date_from,$date_to){	

        $workbook = new Spreadsheet_Excel_Writer(); 
        
        $workbook->setCustomColor(12,226,236,253);
        
        $headerFormat = $workbook->addFormat(array('Size' => 11,
                                      'Color' => 'black',
                                      'bold'=> 1,
                                      'border' => 1,
                                      'Align' => 'merge'));
        $headerFormat->setFontFamily('Calibri'); 
        
        $headerFormat2 = $workbook->addFormat(array('Size' => 11,
                                          'Color' => 'black',
                                          'bold'=> 1,
                                          'border' => 1,
                                          'Align' => 'center'));
        $headerFormat2->setFontFamily('Calibri'); 
        $headerFormat2->setNumFormat('#,##0.00');
    
        $workbook->setCustomColor(13,155,205,255);
        $TotalBorder    = $workbook->addFormat(array('Align' => 'right','bold'=> 1,'border'=>1,'fgColor' => 'white'));
        $TotalBorder->setFontFamily('Calibri'); 
        $TotalBorder->setTop(5); 
        $detailrBorder   = $workbook->addFormat(array('border' =>1,'Align' => 'right'));
        $detailrBorder->setFontFamily('Calibri'); 
        $detailrBorderAlignRight2   = $workbook->addFormat(array('Align' => 'left'));
        $detailrBorderAlignRight2->setFontFamily('Calibri');
        $workbook->setCustomColor(12,183,219,255);
        
        #DETAIL ALIGN LEFT COLOR WHITE 
        $detail_left_color_white   = $workbook->addFormat(array('Size' => 10,
                                              'fgColor' => 'white',
                                              'Pattern' => 1,
                                              'border' =>1,
                                              'Align' => 'left'));
        $detail_left_color_white->setFontFamily('Calibri'); 
        #DETAIL ALIGN LEFT COLOR BLUE 
        $detail_left_color_blue   = $workbook->addFormat(array('Size' => 10,
                                              'border' =>1,
                                              'Pattern' => 1,
                                              'Align' => 'left'));
        $detail_left_color_blue->setFgColor(12); 
        $detail_left_color_blue->setFontFamily('Calibri');
        
        #DETAIL ALIGN CENTER COLOR WHITE 
        $detail_center_color_white   = $workbook->addFormat(array('Size' => 10,
                                              'fgColor' => 'white',
                                              'Pattern' => 1,
                                              'border' =>1,
                                              'Align' => 'center'));
        $detail_center_color_white->setFontFamily('Calibri'); 
        #DETAIL ALIGN CENTER COLOR BLUE 
        $detail_center_color_blue   = $workbook->addFormat(array('Size' => 10,
                                              'border' =>1,
                                              'Pattern' => 1,
                                              'Align' => 'center'));
        $detail_center_color_blue->setFgColor(12); 
        $detail_center_color_blue->setFontFamily('Calibri');
        
        #DETAIL ALIGN RIGHT COLOR WHITE 
        $detail_right_color_white   = $workbook->addFormat(array('Size' => 10,
                                              'fgColor' => 'white',
                                              'Pattern' => 1,
                                              'border' =>1,
                                              'Align' => 'right'));
        $detail_right_color_white->setFontFamily('Calibri'); 
        #DETAIL ALIGN RIGHT COLOR BLUE 
        $detail_right_color_blue   = $workbook->addFormat(array('Size' => 10,
                                              'border' =>1,
                                              'Pattern' => 1,
                                              'Align' => 'right'));
        $detail_right_color_blue->setFgColor(12); 
        $detail_right_color_blue->setFontFamily('Calibri');
        
        #DETAIL ALIGN RIGHT COLOR WHITE WITH NUMBER FORMAT 
        $detail_right_color_white_number   = $workbook->addFormat(array('Size' => 10,
                                              'fgColor' => 'white',
                                              'Pattern' => 1,
                                              'border' =>1,
                                              'Align' => 'right'));
        $detail_right_color_white_number->setFontFamily('Calibri'); 
        $detail_right_color_white_number->setNumFormat('#,##0.00');
        #DETAIL ALIGN RIGHT COLOR BLUE WITH NUMBER FORMAT
        $detail_right_color_blue_number   = $workbook->addFormat(array('Size' => 10,
                                              'border' =>1,
                                              'Pattern' => 1,
                                              'Align' => 'right'));
        $detail_right_color_blue_number->setFgColor(12); 
        $detail_right_color_blue_number->setFontFamily('Calibri');
        $detail_right_color_blue_number->setNumFormat('#,##0.00');
        
        # FILENAME
        $filename = strtoupper($card_type)."_".date('mdY',strtotime($date_from))."_TO_".date('mdY',strtotime($date_to)).".xls";
        
        # SEND FILENAME
        $workbook->send($filename);
        
        # ADD WORK SHEET OR WORK SHEET LABEL
        $worksheet = &$workbook->addWorksheet($card_type);
        
        # SET LANDSCAPE
        $worksheet->setLandscape();
        
        # FREEZE PANE
        //$worksheet->freezePanes(array(3,0));
        
        # MAIN HEADER
        $worksheet->write(0,0,strtoupper($card_type)." REPORT FROM ".date('m/d/Y',strtotime($date_from))." TO ".date('m/d/Y',strtotime($date_to)),$headerFormat);
        for($i=1;$i<5;$i++) {
            $worksheet->write(0, $i, "",$headerFormat);    
        }
        
        # COLUMN WIDTH
        $worksheet->setColumn(0,0,20);
        $worksheet->setColumn(1,1,20);
        $worksheet->setColumn(2,2,20);
        $worksheet->setColumn(3,3,20);
        $worksheet->setColumn(4,4,20);
        $worksheet->setColumn(5,5,20);
        $worksheet->setColumn(6,6,20);
        $worksheet->setColumn(7,7,20);
        $worksheet->setColumn(8,8,20);
        $worksheet->setColumn(9,9,20);
        $worksheet->setColumn(10,10,20);
        
        # HEADER
        $worksheet->write(2,0,"RECEIPT_NO",$headerFormat);
        $worksheet->write(2,1,"STORE",$headerFormat);
        $worksheet->write(2,2,"REG",$headerFormat);
        $worksheet->write(2,3,"TRX",$headerFormat);
        $worksheet->write(2,4,"TRXDATE",$headerFormat);
        
        # DATABASE
        $this->load->model('get_excel'); 
        
        $data = $this->get_excel->get_xls_data($card_type,$date_from,$date_to);
        
        # ASSIGN COUNTER ROW
        $ctr = 3; 
        
        #ASSIGN ALTERNATE COLOR
        $col = 0;     
        
        # LOOP DATA
        foreach($data as $row){  
             
            $row_left = ($col==0) ? $detail_left_color_blue:$detail_left_color_white;
            $row_center = ($col==0) ? $detail_center_color_blue:$detail_center_color_white;
            $row_right = ($col==0) ? $detail_right_color_blue:$detail_right_color_white;
            $row_right_number = ($col==0) ? $detail_right_color_blue_number:$detail_right_color_white_number;
            $col = ($col==0) ? 1:0;   
            
            $worksheet->write($ctr,0," ".$row->RECEIPT_NO,$row_left);
            $worksheet->write($ctr,1,$row->STORE,$row_left);
            $worksheet->write($ctr,2,$row->REG,$row_left);
            $worksheet->write($ctr,3,$row->TRX,$row_left);
            $worksheet->write($ctr,4,$row->TRXDATE,$row_left);
            
            //$month = substr($row->TRXDATE,2,3);
            //$date = date('d',substr($row->TRXDATE,0,2));
            //$year = date('Y',substr($row->TRXDATE,4,6));
            //$worksheet->write($ctr,4,$month."-".$date."-".$year,$row_center);
            //$worksheet->write($ctr,4,$month,$row_center);

            $ctr++;
        }                     
        
        # CLOSE WORK BOOK     
        $workbook->close();
    }
}
?>