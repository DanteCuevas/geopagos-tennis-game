<?php

namespace App\Exports;

use App\Models\Liner;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LinersExport implements FromCollection, WithHeadings
{
    protected $codeReport;

    public function __construct($codeReport)
    {
        $this->codeReport = $codeReport;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Liner::select("date_report", "code_report", "code", "status", "location")
            ->where('code_report', $this->codeReport)
            ->get();
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return ["Fecha", "Reporte", "Codigo", "Estado", "Ubicacion"];
    }
}