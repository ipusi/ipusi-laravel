<?php

namespace App\Admin\Extensions;

use Encore\Admin\Grid\Exporters\AbstractExporter;
use Maatwebsite\Excel\Facades\Excel;
use Encore\Admin\Grid;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class ExcelExporter extends AbstractExporter
{
    protected $grid;
    protected $row = [];

    public function __construct(Grid $grid)
    {
        $this->grid = $grid;
    }
    public function export()
    {
        $now = Carbon::now();
        Excel::create($now, function($excel) {
            $excel->sheet('数据', function($sheet) {
                $columns = $this->grid->columns()->all();
                $rowheader = [];
                foreach ($columns as $key => $value) {
                    array_push($rowheader, $value->getLabel());
                    array_push($this->row, $value->getName());
                }
                $sheet->rows(collect([0 => $rowheader]));
                // 这段逻辑是从表格数据中取出需要导出的字段
                $rows = collect($this->getData())->map(function ($item) {
                    return array_only($item, $this->row);
                });

                $sheet->rows($rows);
            });

        })->export('xlsx');
    }
}