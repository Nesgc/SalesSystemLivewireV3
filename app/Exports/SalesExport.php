<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;

class SalesExport implements
    FromCollection,
    WithHeadings,
    WithCustomStartCell,
    WithTitle,
    WithStyles,
    WithColumnWidths,
    WithMapping,
    WithColumnFormatting
{
    /**
     * @return \Illuminate\Support\Collection
     */

    //use Exportable;

    protected $userId, $dateFrom, $dateTo, $reportType;

    function __construct($userId, $reportType, $f1, $f2)
    {
        $this->userId = $userId;
        $this->reportType = $reportType;
        $this->dateFrom = $f1;
        $this->dateTo = $f2;
        //$this->fileName = 'reporte_ventas_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
    }

    public function collection()
    {
        // return Sale::all();

        $data = [];
        if ($this->reportType == 1) {
            $from = Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($this->dateTo)->format('Y-m-d') . ' 23:59:59';
        } else {
            $from = Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($this->dateTo)->format('Y-m-d') . ' 23:59:59';
        }

        if ($this->userId == 0) {
            $data = Sale::join('users as u', 'u.id', 'sales.user_id')
                ->select('sales.id', 'sales.total', 'sales.items', 'sales.status', 'u.name as user', 'sales.created_at')
                ->whereBetween('sales.created_at', [$from, $to])
                ->get();

            //dd($data);

        } else {
            $data = Sale::join('users as u', 'u.id', 'sales.user_id')
                ->select('sales.id', 'sales.total', 'sales.items', 'sales.status', 'u.name as user', 'sales.created_at')
                ->whereBetween('sales.created_at', [$from, $to])
                ->where('user_id', $this->userId)
                ->get();
        }

        return $data;
    }


    public function headings(): array // Etiqueta nuestros encabezados o titulos
    {
        return ["Sale", "Import", "Items", "Status", "User", "Date"];
    }

    public function startcell(): string // Inicio de nuestro archivo o reporte
    {
        return 'A2';
    }

    public function styles(Worksheet $sheet) // Personaliza nuestras columnas
    {
        /*return [
                2 => [ 'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
            ],
            'C' => [ // Centrar Columna C
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
            'D' => [ // Centrar Columna D
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
            'E' => [ // Centrar Columna E
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
            '*' => [ // Todas las demás filas
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
            ],
        ];*/

        $sheet->getStyle('A2:F2')->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'D6D6D6', // Color de fondo GRIS
                ],
            ],
        ]);


        return [

            'A2:F' . $sheet->getHighestRow() => [
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
            ],
        ];
    }

    public function title(): string // coloca el nombre de nuestro archivo
    {
        return 'Sales Report';
    }

    public function columnWidths(): array // Coloca el ancho de cada columna
    {
        return [
            'A' => 15,
            'B' => 15,
            'C' => 15,
            'D' => 15,
            'E' => 20,
            'F' => 20,
        ];
    }

    public function map($row): array // Formatea la fecha antes de incluirla en el array
    {
        $formattedDate = Date::dateTimeToExcel($row->created_at);

        return [
            $row->id,
            $row->total,
            $row->items,
            $row->status,
            $row->user,
            $formattedDate,
        ];
    }

    public function columnFormats(): array //Formato para cada columna
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
            'B' => NumberFormat::FORMAT_NUMBER,
            'C' => NumberFormat::FORMAT_NUMBER,
            'D' => NumberFormat::FORMAT_TEXT,
            'E' => NumberFormat::FORMAT_TEXT,
            'F' => 'dd/mm/yyyy hh:mm', // 'F' => NumberFormat::FORMAT_DATE_DDMMYYYY,

        ];
    }
}
