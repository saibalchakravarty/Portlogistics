<?php
namespace App\Services;
use App\Repositories\Export\ExportRepository;
use Storage;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class  ExcelOrCsvExportService implements FromArray, WithHeadings, ShouldAutoSize, WithEvents
{
	protected $data = null;

    function __construct($excelRowData,$excelHeader,$allInput)
    {
		$this->excelData = $excelRowData['result']; 
		$this->excelHeader = $excelHeader; 
		$this->allInput = $allInput; 
	}
	/*
	* Description 	: This function is managing styles and all customatic operation
	* Author 		: Ashish Barick
	* @param 		: $cellCount - Determine the total cell
					  $styleArray - Array for styling the row cells
	* Return 		: bool(true/false)
	*
	*/
	public function registerEvents(): array
    {
        return [
            
            AfterSheet::class => function(AfterSheet $event) {
            	$columns = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
            	$cellCount = count($this->excelHeader);
                $styleArray = [
                	'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                	],
                	'font' => [
                        'name'      =>  'Calibri',
                        'size'      =>  14,
                        'bold'      =>  true,
                        'color' => ['argb' => 'FFFFFF'],
                    ],
				    
				];
				// for Row data
				$dataCellCount = count($this->excelData);
				$row = 2;
				for($i =1 ;$i<=$dataCellCount;$i++)
				{
					$row += $i;
					$event->sheet->getDelegate()->getStyle('A'.$row.':'.$columns[$cellCount].$row)->getFont()->setSize(10);
				}
				
				 $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(19);
                $event->sheet->getDelegate()->setTitle($this->allInput['export_key'])->getStyle('A1:'.$columns[$cellCount-1].'1')->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('A1'); // Set cell A1 as selected
                $event->sheet->getDelegate()->getStyle('A1:'.$columns[$cellCount-1].'1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('4472c4');//Set background color of the Header

                //Title Header of the Excel
                // last column as letter value (e.g., D)
            	$merge_columns = Coordinate::stringFromColumnIndex(count($this->excelHeader)-1);
            	$last_column = Coordinate::stringFromColumnIndex(count($this->excelHeader));
	            // calculate last row + 1 (total results + header rows + column headings row + new row)

	            // at row 1, insert 2 rows
	            $event->sheet->insertNewRowBefore(1);

	            // merge cells for full-width
	            $event->sheet->mergeCells(sprintf('A1:%s1',$merge_columns));
	            // assign cell values
	            $event->sheet->setCellValue('A1',$this->allInput['export_key'].' Data Export');
	            $event->sheet->setCellValue($last_column.'1',date('d/m/Y'));
	            // assign cell styles
	            $event->sheet->getStyle('A1')->applyFromArray($styleArray);
	            $event->sheet->getStyle($last_column.'1')->applyFromArray($styleArray);
	            $event->sheet->getDelegate()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('305496');
	            $event->sheet->getDelegate()->getStyle($last_column.'1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('305496');
            },
        ];
    }
    
    /*
	* Description 	: This function is for adding Header columns in a row
	* Author 		: Ashish Barick
	* Return 		: Array
	*
	*/
	public function headings(): array
    {
        return $this->excelHeader;
    }
    /*
	* Description 	: This function is for adding Row data in excel after Header
	* Author 		: Ashish Barick
	* Return 		: Array
	*
	*/
    public function array(): array
    {
        return $this->excelData;
    }
}

