<?php

namespace PhpExcel;

class ExcelFactory{
    
    protected $layoutService;
    protected $PHPExcel;
    
    public function __construct(){
        
        require '/PHPExcel/PHPExcel.php';
        require '/PHPExcel/PHPExcel/IOFactory.php';
        require '/PHPExcel/PHPExcel/Cell/DataType.php';
        $this->PHPExcel = new \PHPExcel();
    }
    
    /**
     * @return type Description
     */
    protected function getPHPExcel()
    {
        return $this->PHPExcel;
    }        
    
    /**
     * 
     * @param type $propertyCriador
     * @param type $propertyModificadoPor
     * @param type $propertyTitulo
     * @param type $propertyAssunto
     * @param type $propertyDescricao
     * @param type $propertyPalavrasChaves
     * @param type $propertyCategoria
     * @param type $propertyAlinhamento
     */
    public function setPropriedades($propertyCriador, $propertyModificadoPor, $propertyTitulo, $propertyAssunto, 
                                    $propertyDescricao, $propertyPalavrasChaves, $propertyCategoria, $propertyAlinhamento)
    {
        
        $excelProperties = $this->getPHPExcel()->getProperties();
        
        // Seta as propriedades passadas
        $excelProperties->setCreator($propertyCriador)
                        ->setLastModifiedBy($propertyModificadoPor)
                        ->setTitle($propertyTitulo)
                        ->setSubject($propertyAssunto)
                        ->setDescription($propertyDescricao)
                        ->setKeywords($propertyPalavrasChaves)
                        ->setCategory($propertyCategoria);

        // Seta alinhamento de todo o sheet pra esquerda
        $excelDefaultStyle = $this->getPHPExcel()->getDefaultStyle();
        $excelDefaultStyleAlignment = $excelDefaultStyle->getAlignment();
        $excelDefaultStyleAlignment->setHorizontal(strtolower($propertyAlinhamento));
    }
    
    /**
     * 
     * @param type $idx
     */
    public function setActiveSheetIndex($idx)
    {
        // Seta a sheet do index idx
        $this->getPHPExcel()->setActiveSheetIndex($idx);
    }        
    
    /**
     * 
     * @param type $col
     * @param type $width
     */
    public function setColumnDimensionWidth($col, $width)
    {
        // Seta as dimensões de todas as colunas passadas
        $excelSheet = $this->getPHPExcel()->getActiveSheet();
        $columnDimension = $excelSheet->getColumnDimension($col);
        $columnDimension->setWidth($width); 
    }        
    
    /**
     * 
     * @param type $title
     */
    public function setSheetTitle($title)
    {
        // Seta o titulo da sheet atual
        $excelSheet = $this->getPHPExcel()->getActiveSheet();
        $excelSheet->setTitle($title);
    }
    
    /**
     * 
     * @param type $colInicial
     * @param type $colFinal
     * @param type $tipoBorda
     */
    public function setBorders($colInicial, $colFinal , $tipoBorda){
        
        // Seta todas as bordar da coluna inicial ate a final
        $excelSheet = $this->getPHPExcel()->getActiveSheet();
        $excelSheetStyle = $excelSheet->getStyle($colInicial.':'.$colFinal);
        $excelGetStyleBorders = $excelSheetStyle->getBorders();
        $execelGetStyleAllBorder = $excelGetStyleBorders->getAllBorders();
        $execelGetStyleAllBorder->setBorderStyle($tipoBorda);
    }
       
    /**
     * 
     * @param type $col
     * @param type $value
     */
    public function setCellValue($col, $value)
    {
        
        // Seta valores na colunas
        $excelSheet = $this->getPHPExcel()->getActiveSheet();
        $excelSheet->setCellValue($col, $value);
    }
    
    /**
     * Style de uma celula no excel
     * 
     * @param type $cell
     * @param type $styleArray
     */
    public function setCellStyle($cell, $styleArray ){
        
        $this->getPHPExcel()->getActiveSheet()->getStyle($cell)->applyFromArray($styleArray);
    }
    
    /**
     * 
     * @param type $col
     * @param type $value
     * @param type $type
     */
    public function setCellValueExplicit($col, $value, $type)
    {
        // Seta valores na colunas
        $excelSheet = $this->getPHPExcel()->getActiveSheet();
        $excelSheet->setCellValueExplicit($col, $value, $type);
    }
    
    /**
     * 
     * @param type $col
     */
    public function setFontBold($col){
        
        // Seta as Fonte negrito de todas as colunas que seram passadas
        $excelSheet = $this->getPHPExcel()->getActiveSheet();
        $excelStyle = $excelSheet->getStyle($col);
        $excelStyleFont = $excelStyle->getFont();
        $excelStyleFont->setBold(true);
    }
    
    /**
     * 
     * @param type $cell
     * @param type $align
     */
    public function setAlignCell($cell, $align){
        
        // Seta alinhamento individual de cada cellula
        $excelSheet = $this->getPHPExcel()->getActiveSheet();
        $excelStyle = $excelSheet->getStyle($cell);
        $excelStyleAlign = $excelStyle->getAlignment();
        $excelStyleAlign->setHorizontal($align);
    }
    
    /**
     * 
     * @param type $colInicial
     * @param type $colFinal
     */
    public function MergeCells($colInicial, $colFinal){
        
        // Merges da coluna inicial ate coluna final
        $excelSheet = $this->getPHPExcel()->getActiveSheet();
        $excelSheet->mergeCells($colInicial . ':'. $colFinal);
    }
    
    /**
     * 
     * @return type $highestColumn
     */
    public function getHighestColumn(){
        
        $excel = $this->getPHPExcel();
        $excelSheet = $excel->getActiveSheet();
        $highestColumn = $excelSheet->getHighestColumn();
        
        // Retorna a maior coluna utilizada
        return $highestColumn;
    }
    
    /**
     * 
     * @return type $highestRow
     */
    public function getHighestRow(){
        
        $excel = $this->getPHPExcel();
        $excelSheet = $excel->getActiveSheet();
        $highestRow = $excelSheet->getHighestRow();
        
       // Retorna a maior linha utilizada
        return $highestRow;
    }
    
    /**
     * 
     * @param type $col
     * @param type $row
     * @return type
     */
    public function ConcatColRow($col , $row){
        
        return $col . $row;
    }
    
    /**
     * 
     * @param type $filename
     * @param type $dir
     * @return type
     * @throws \Exception
     */
    public function generateExcel($filename, $dir = null){
                
        // Objeto tipo Excel5
        $objWriter = \PHPExcel_IOFactory::createWriter($this->getPHPExcel(), 'Excel5');
        
        // Retorna diretorio atual
        $diretorio = getcwd() . "\\" . $dir;

        if(is_dir($dir)){
                
            try{
                // Salva excel no diretorio passado
                $objWriter->save($dir . $filename . '.xls');                
                return $diretorio . $filename . '.xls';
                 
            } catch (Exception $e) {
                throw new \Exception('Não foi possível gerar arquivo excel: ' . $filename . '</br> Error: ' . $e->getMessage());
            }
        }
        else
        {
            // Se nao for diretorio
            throw new \Exception('diretorio não valido: ' . $dir);
        }
    }
    
    /**
     * 
     * @param type $filename
     * @param type $dir
     * @return type
     * @throws \Exception
     */
    public function outputExcel($fileName = 'File'){
        
        $filename = "$fileName-" . date('d-m-Y-H-i-s') . ".xls";
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=$filename");
        header('Cache-Control: max-age=0');  
        
        // Objeto tipo Excel5
        $objWriter = \PHPExcel_IOFactory::createWriter($this->getPHPExcel(), 'Excel5');
        
        $objWriter->save('php://output');
    }
    
    /**
     * 
     * @param type $inputFileName
     * @param type $pedidoItens
     * @throws \Exception
     */
    public function validarValorPanilhas($inputFileName, $pedidoItens){
        
        $totalPanilha = 0;
        $qtdPanilha = 0;
        $i = 0;
        
        foreach($pedidoItens as $iten){
            $qtdPanilha = $qtdPanilha + $iten['QTDE_SOLICITADA'];
            $totalPanilha = $totalPanilha + str_replace(',', '.', $iten['TOTAL_SOLICITADO']);
        }
        
        //  Read your Excel workbook 
        try {
            $inputFileType = \PHPExcel_IOFactory::identify($inputFileName);
            $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
            
        } catch(Exception $e) {
            die('Error ao carregar arquivo para validar valor da panilha "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
        }

        //  Get worksheet dimensions
        $sheet = $objPHPExcel->getSheet(0); 
        $highestRow = $sheet->getHighestRow(); 
        $highestColumn = $sheet->getHighestColumn();
        
        $flag = 0;
        $total = 0;
        $qtd_item = 0;
        
        //  Loop through each row of the worksheet in turn
        for ($row = 1; $row <= $highestRow; $row++){ 
            //  Read a row of data into an array
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                            NULL,
                                            TRUE,
                                            FALSE);
            
            if($rowData[0][0] == 'Codigo de Item'){
                $flag = 1;
            }
            
            if($rowData[0][4] == 'TOTAIS'){
                $flag = 0;
            }
                        
            if($flag == 1){
                $total = $total + $rowData[0][7]; 
                $qtd_item = $qtd_item + $rowData[0][5];
            }
        }
        
        if(($totalPanilha != $total) || ($qtdPanilha != $qtd_item)){
            throw new \Exception("Panilha não valida valor na panilha: $total - valor esperado: $totalPanilha");
        }
    }
    
    public function setWholeDocAlign($align){
        
        $excelSheet = $this->getPHPExcel()->getActiveSheet();
        $excelSheet->getDefaultStyle()->getAlignment()->setHorizontal($align);
    }
    
    public function applyStyleArrayWholeDoc($styleArray){

        $excelSheet = $this->getPHPExcel()->getActiveSheet();
        $excelSheet->getDefaultStyle()->applyFromArray($styleArray);
    }
}
?>