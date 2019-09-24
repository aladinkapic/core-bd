<?php

namespace App\Http\Controllers;
use App\Models\Sluzbenik;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\Session;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Worksheet_Drawing;
use PHPExcel_Style_Alignment;
use PHPExcel_Style_Border;
use App\Models\Izvjestaji;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Http\Request;

class ExportController extends Controller{
    protected $letters = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "w", "X", "Y", "Z");
    protected $excelFile = null;
    protected $array_length = null;
    protected $pdf_active = null;

    protected $style = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        ),
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )

    );

    public function saveToTable($name, $result, $what){
        try{
            if(Session::has('ID')){
                $id = Crypt::decryptString(Session::get('ID'));
            }else $id = null;
            $izvjestaji = new Izvjestaji();
            $izvjestaji->naziv            = $name;
            $izvjestaji->what             = $what;
            $izvjestaji->naziv_korisnicki = $result;
            $izvjestaji->id_sluzbenika    = '1';
            $izvjestaji->save();

            return $izvjestaji->id;
        }catch (\Exception $e){
            return $e;
        }
    }

    public function word(Request $request, $createPDF = null){
        $PHPWord = new \PhpOffice\PhpWord\PhpWord();
        // Every element you want to append to the word document is placed in a section. So you need a section:
        $section = $PHPWord->createSection();
        $data = $request->all();  // Podaci koji su stigli putem HTTP-requesta : )
        $fileName = sha1(time());
        $result   = $data['result'];

        /**************************************************************************************************************
         *
         *      Kreirajmo header sa određenim stajlom.
         *
         *************************************************************************************************************/
        $text = "Pododjeljenje za ljudske resurse Brčko Distrikta.";
        $PHPWord->addFontStyle('headerFont', array('bold'=>true, 'italic'=>false, 'size'=>14));
        $PHPWord->addParagraphStyle('headerParagraph', array('align'=>'center'));
        $section->addText($text, 'headerFont', 'headerParagraph');
        $section->addTextBreak(1);

        // You can also putthe appended element to local object an call functions like this:
        //$myTextElement->setBold();
        //$myTextElement->setName('Verdana');
        //$myTextElement->setSize(22);

        /**************************************************************************************************************
         *
         *      Kreirajmo tabelu i popunimo ćelije sa podacima iz requesta
         *
         *************************************************************************************************************/
        $styleTable = array(
            'borderColor' => '333333',
            'borderSize' => 1,
            'cellMargin' => 50,
            'unit' => 'pct',
            'width' => 5000
        );

//        $styleTable = new \PhpOffice\PhpWord\Style\Table;
//        $styleTable->setBorderColor('333333');
//        $styleTable->setBorderSize(1);
////        $styleTable->setUnit(\PhpOffice\PhpWord\Style\Table::WIDTH_PERCENT);
//        $styleTable->setWidth(100 * 50);


        $PHPWord->addTableStyle('myTable', $styleTable);
        $table = $section->addTable('myTable');

        for($i=0; $i<count($data['data']); $i++){
            $table->addRow();
            for($j=0; $j<count($data['data'][$i]); $j++){
                if($j == 0) $cellWidth = 400;
                else $cellWidth = 2000;

                $cell = $table->addCell();
                $cell->addText($data['data'][$i][$j ]);
            }
        }


        // Add image elements
//        $section->addImage(APPPATH . '/images/side/jqxs-l.JPG');
//        $section->addTextBreak(1);
        //$section->addImage(APPPATH.'/images/side/jqxs-l.JPG', array('width'=>210, 'height'=>210, 'align'=>'center'));
        //$section->addTextBreak(1);
        //$section->addImage(APPPATH.'/images/side/jqxs-l.jpg', array('width'=>100, 'height'=>100, 'align'=>'right'));
        // At least write the document to webspace:

        /**************************************************************************************************************
         *
         *      Footer na kraju dokumenta
         *
         *************************************************************************************************************/
        $section->addTextBreak(1); $section->addTextBreak(1);
        $PHPWord->addFontStyle('footerFont', array('bold'=>false, 'italic'=>false, 'size'=>9));
        $PHPWord->addParagraphStyle('footerParagraph', array('align'=>'center'));
        $section->addText('© '.date('Y').' Sva prava zadržana: Pododjeljenje za ljudske resurse Brčko Distrikt','footerFont','footerParagraph');


        /**************************************************************************************************************
         *
         *      Kreirajmo fajl na kraju te to sve umetnimo u bazu podataka.
         *
         *************************************************************************************************************/
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($PHPWord, 'Word2007');
        $objWriter->save('izvjestaji/word/'.$fileName.'.docx');

        if(!$this->pdf_active){
            return $this->saveToTable($fileName, $result, 'word');
        }

        return $fileName;
    }


    public function pdf(Request $request){
        $this->pdf_active = true;
        $fileName = $this->word($request);
        $result   = $request->all()['result'];

        Settings::setPdfRendererName(Settings::PDF_RENDERER_DOMPDF);
        // Any writable directory here. It will be ignored.
        Settings::setPdfRendererPath('.');

        $phpWord = IOFactory::load('izvjestaji/word/'.$fileName.'.docx', 'Word2007');
        $phpWord->save('izvjestaji/pdf/'.$fileName.'.pdf', 'PDF');


        $this->saveToTable($fileName, $result, 'word');
        return $this->saveToTable($fileName, $result, 'pdf');
    }






    public function excel(Request $request){
        $this->excelFile = new PHPExcel();
        $this->excelFile->setActiveSheetIndex(0); // Aktivni sheet nulti - početni
        $this->excelFile->getDefaultStyle()->applyFromArray($this->style); // Ovdje pozicioniramo tekst u sredinu - H i V
        $data = $request->all();  // Podaci koji su stigli putem HTTP-requesta : )
        $fileName = sha1(time());

        $result   = $data['result'];

        $this->excelFile->getProperties()->setCreator("Core-BD app")
            ->setLastModifiedBy("Core-BD app")
            ->setTitle("Izvještaj")
            ->setSubject("Izvještaj sa aplikacije")
            ->setDescription("Ovo je automatski kreirani izvještaj za Pododjeljenje za ljudske resurse Brčko Distrikta.")
            ->setKeywords("office 2007 core-bd")
            ->setCategory("Excel fajlovi");

        /**************************************************************************************************************
         *
         *      Postavimo header row nešto malo širi od ostalih
         *
         *************************************************************************************************************/

        $this->excelFile->getActiveSheet()->getRowDimension('1')->setRowHeight(40);

        /**************************************************************************************************************
         *
         *      Ubacimo logo na vrhu stranice u fajl
         *
         *************************************************************************************************************/

        $this->setImage(5,5, 40, 40, 'images/grb-bih.png', 'A1', 'Grb Bosne i Hercegovine', 'Logo na vrhu skripte');;


        $this->excelFileWriter = PHPExcel_IOFactory::createWriter($this->excelFile, 'Excel2007');

        /**************************************************************************************************************
         *
         *      Naslov fajla ; Postavimo naslov fajla; Postavimo ćeliju kojoj pripada; Boldirajmo ćeliju;
         *      Povećajmo font; Spojimo ćelije od do
         *
         *************************************************************************************************************/
        $this->excelFile->getActiveSheet()->SetCellValue('A1','Pododjeljenje za ljudske resurse Brčko Distrikta. ');
        $this->boldCell('A1');
        $this->fontSize('A1', 14);
        $this->excelFile->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->excelFile->getActiveSheet()->getStyle('A1')->getAlignment()->setWrapText(true);
        $this->excelFile->getActiveSheet()->mergeCells('A1:'.$this->letters[count($data['header']) - 1].'1');


        /**************************************************************************************************************
         *
         *      Postavimo sve ćelije da su autoresize u zavisnosti od dužine riječi / rečnice - HEIGHT SAMO
         *
         *************************************************************************************************************/

        $this->excelFile->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

        foreach(range('A',$this->letters[count($data['header']) - 1]) as $columnID) {
            $this->excelFile->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
            $this->excelFile->getActiveSheet()->getStyle($columnID)->getAlignment()->setWrapText(true);
        }

        /**************************************************************************************************************
         *
         *      Dodajmo automatske nazive kolona u excel fajlu.
         *
         *************************************************************************************************************/
        $this->nameOfColumns($data['header'],3);



        for($i=0; $i<count($data['data']); $i++){
            $j = 0;
            foreach(range('A',$this->letters[count($data['header']) - 2]) as $columnID) {

//                if($columnID.' '.$data['data'][$i][$j] != null) echo $columnID.' '.$data['data'][$i][$j++].' ';
                $this->excelFile->getActiveSheet()->SetCellValue($columnID.($i + 4), $data['data'][$i][$j++]);
            }
        }

        $this->excelFileWriter->save('izvjestaji/excel/'.$fileName.'.xlsx');
        return $this->saveToTable($fileName, $result, 'excel');
    }






    public function boldCell($cellName){$this->excelFile->getActiveSheet()->getStyle( $cellName )->getFont()->setBold( true );}
    public function fontSize($cellName, $size){$this->excelFile->getActiveSheet()->getStyle( $cellName )->getFont()->setSize( $size );}
    public function setImage($x_of, $y_of, $width, $height, $url, $cell, $name = null, $description = null){
        $this->excelFileDrawing = new PHPExcel_Worksheet_Drawing();
        $this->excelFileDrawing->setName($name);
        $this->excelFileDrawing->setDescription($description);
        $this->excelFileDrawing->setPath($url);
        $this->excelFileDrawing->setCoordinates($cell);
        //setOffsetX works properly
        $this->excelFileDrawing->setOffsetX($x_of);
        $this->excelFileDrawing->setOffsetY($y_of);
        //set width, height
        $this->excelFileDrawing->setWidth($width);
        $this->excelFileDrawing->setHeight($height);
        $this->excelFileDrawing->setWorksheet($this->excelFile->getActiveSheet());
    }

    public function nameOfColumns($names, $row = 3){
        $i = 0;
        foreach(range('A',$this->letters[count($names) - 1]) as $columnID) {
            $this->excelFile->getActiveSheet()->SetCellValue($columnID.$row, $names[$i++]);
        }
    }


    public function download(Request $request){
        $data     = Izvjestaji::where('id', $request->id)->first();
        $response = array();
        array_push($response, $data->naziv_korisnicki);

        if($data->what == 'word'){
            array_push($response, '/izvjestaji/word/'.$data->naziv.'.docx');
        }else if($data->what == 'excel'){
            array_push($response, '/izvjestaji/excel/'.$data->naziv.'.xlsx');
        }else if($data->what == 'pdf'){
            array_push($response, '/izvjestaji/pdf/'.$data->naziv.'.pdf');
        }


        return $response;
    }
}
