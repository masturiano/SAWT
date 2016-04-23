<?
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class FaIFAAF_excel extends CI_Controller{
################### INCLUDE FILE #################
public function __construct(){
    parent::__construct();
    $this->load->database();
    $this->load->model('ifaaf_model');
    $this->load->library('session');
    ini_set('include_path','C:\wamp\php\PEAR');
    require_once 'Spreadsheet/Excel/Writer.php';
}
function printExcel($txtStore,$txtFromDate,$txtToDate,$txtItem,$txtNature){    
    // /*
    $workbook = new Spreadsheet_Excel_Writer();
    $workbook->setCustomColor(12,226,236,253);
    $headingFormat = $workbook->addFormat(array('Size' => 14,
                                      'Color' => 'black',
                                      'bold'=> 1,
                                      'Align' => 'left'));
    $headingFormat->setFontFamily('Calibri');
    $headingFormat1 = $workbook->addFormat(array('Size' => 11,
                                      'Color' => 'black',
                                      'bold'=> 1,
                                      'Align' => 'left'));
    $headingFormat1->setFontFamily('Calibri'); 
    $subHeadingFormat = $workbook->addFormat(array('Size' => 11,
                                      'Color' => 'black',
                                      'border' => 1,
                                      'Align' => 'left'));
    $subHeadingFormat->setFontFamily('Calibri'); 
    $subHeadingFormatR = $workbook->addFormat(array('Size' => 11,
                                      'Color' => 'black',
                                      'border' => 1,
                                      'Align' => 'right'));
    $subHeadingFormatR->setFontFamily('Calibri'); 
    $subHeadingFormatC = $workbook->addFormat(array('Size' => 11,
                                      'Color' => 'black',
                                      'border' => 1,
                                      'Align' => 'center'));
    $subHeadingFormatC->setFontFamily('Calibri'); 
    $headerFormat = $workbook->addFormat(array('Size' => 11,
                                      'Color' => 'black',
                                      'bold'=> 1,
                                      'border' =>1,
                                      'Align' => 'merge'));
    $headerFormat->setFontFamily('Calibri'); 
    $contentFormat = $workbook->addFormat(array('Size' => 11,
                                      'Color' => 'black',
                                      'bold'=> 1,
                                      'border' => 1,
                                      'Align' => 'center'));
    $headerFormat->setFgColor(12);
    $contentFormat->setFontFamily('Calibri'); 
    $headerBorder    = $workbook->addFormat(array('Size' => 10,
                                      'Color' => 'black',
                                      'bold'=> 1,
                                      'border' => 1,
                                      'Align' => 'merge'));
    $headerBorder->setFontFamily('Calibri'); 
    $workbook->setCustomColor(13,155,205,255);
    $TotalBorder    = $workbook->addFormat(array('Align' => 'right','bold'=> 1,'border'=>1,'fgColor' => 'white'));
    $TotalBorder->setFontFamily('Calibri'); 
    $TotalBorder->setTop(5); 
    $detailrBorder   = $workbook->addFormat(array('border' =>1,'Align' => 'right'));
    $detailrBorder->setFontFamily('Calibri'); 
    $detailrBorderAlignRight2   = $workbook->addFormat(array('Align' => 'left'));
    $detailrBorderAlignRight2->setFontFamily('Calibri');
    //$workbook->setCustomColor(12,183,219,255);
    $detail   = $workbook->addFormat(array('Size' => 10,
                                          'fgColor' => 'white',
                                          'Pattern' => 1,
                                          'border' =>1,
                                          'Align' => 'left'));
    $detail->setFontFamily('Calibri'); 

    $detail2   = $workbook->addFormat(array('Size' => 10,
                                          'fgColor' => 'white',
                                          'border' =>1,
                                          'Pattern' => 1,
                                          'Align' => 'left'));
    //$detail2->setFgColor(12); 
    $detail2->setFontFamily('Calibri'); 
    $Dept   = $workbook->addFormat(array('Size' => 10,
                                          'fgColor' => 'white',
                                          'Pattern' => 1,
                                          'border' =>1,
                                          'Align' => 'right'));
    $Dept->setFontFamily('Calibri'); 
    $Dept2   = $workbook->addFormat(array('Size' => 10,
                                          'fgColor' => 'white',
                                          'border' =>1,
                                          'Pattern' => 1,
                                          'Align' => 'right'));;

    $filename = "IFAAF Report Inquiry.xls";
    $workbook->send($filename);
    
    $worksheet=&$workbook->addWorksheet("IFAAF Report Inquiry");
    $worksheet->write(0, 0,"IFAAF Report Inquiry",$headingFormat);
    $worksheet->setColumn(0,10,20);    

    $arrStore = $this->ifaaf_model->FaIFAAFStore($txtStore);
    $worksheet->write(1, 0,"STORE:",$headingFormat1);
        foreach($arrStore as $val){
            $worksheet->write(1, 1,$val['STRNAM'],$headingFormat1);
        }

    $arrItem = $this->ifaaf_model->FaIFAAFItem($txtItem);
    $worksheet->write(2, 0,"ITEM:",$headingFormat1);
        foreach($arrItem as $val){
            $worksheet->write(2, 1,$val['ItemDesc'],$headingFormat1);
        }

    $arrNature = $this->ifaaf_model->FaIFAAFNature($txtNature);
    $worksheet->write(3, 0,"NATURE:",$headingFormat1);
        foreach($arrNature as $val){
            $worksheet->write(3, 1,$val['natureDesc'],$headingFormat1);
        }
    
    $worksheet->write(4, 0,"DATE FROM:",$headingFormat1);
    $worksheet->write(4, 1,$txtFromDate,$headingFormat1);
    $worksheet->write(5, 0,"DATE TO:",$headingFormat1);
    $worksheet->write(5, 1,$txtToDate,$headingFormat1);

    $c = 6;
    $worksheet->write($c,0,"DATE ISSUED",$headerFormat);
    $worksheet->write($c,1,"IFAAF NUMBER",$headerFormat);
    $worksheet->write($c,2,"ISSUED TO",$headerFormat);
    $worksheet->write($c,3,"ITEM",$headerFormat);
    $worksheet->write($c,4,"QUANTITY",$headerFormat);
    $worksheet->write($c,5,"MODEL / BRAND",$headerFormat);
    $worksheet->write($c,6,"SERIAL #",$headerFormat);
    $ctr = 7;
    
        $arrIFAAF = $this->ifaaf_model->FaIFAAFexcel($txtStore,date('Y-m-d',strtotime($txtFromDate)),date('Y-m-d',strtotime($txtToDate)),$txtItem,$txtNature);
        foreach($arrIFAAF as $val){
            $worksheet->write($ctr,0,$val['ifaafDate'],$subHeadingFormatC);
            $worksheet->write($ctr,1,$val['ifaafNo'],$subHeadingFormatC);
            $worksheet->write($ctr,2,$val['fullname'],$subHeadingFormat);
            $worksheet->write($ctr,3,$val['ItemDesc'],$subHeadingFormat);
            $worksheet->write($ctr,4,$val['ifaafQty'],$subHeadingFormat);
            $worksheet->write($ctr,5,$val['ifaafBrand'],$subHeadingFormat);
            $worksheet->write($ctr,6,$val['ifaafSerial'],$subHeadingFormatC);
            $ctr++;
        }

    
        
$workbook->close();
 // */
}
}
?>