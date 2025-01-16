<?php

namespace App\Exports;

use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class CourseExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    protected $column_count;

    public function __construct( $created_start = null, $created_end = null)
    {
        $this->entries = Course::where(function ($query) use ($created_start, $created_end) {
            if (isset($created_start)) {
                $query->where('created_at', '>=', $created_start);
            }
            if (isset($created_end)) {
                $query->where('created_at', '<=', $created_end);
            }
        })->get();

        $this->column_count = count($this->headings()); // number of columns to be auto sized
    }

    public function collection(): Collection
    {
        return collect($this->entries);
    }

    public function headings(): array
    {
        return [
            'Course Code',
            'Course Name',
            'Number of Students',
            'Number of Students Done',
            'Created By',
            'Created at',
            'Last Updated At'
        ];
    }

    public function map($row): array
    {
        $user = User::find($row->created_by);
        
        return [
            $row->code,
            $row->name,
            $row->numberOfStudents() > 0 ? $row->numberOfStudents() : '0',
            $row->numberOfCompletedStudents() > 0 ? $row->numberOfCompletedStudents() : '0',
            $user->name,
            $row->created_at ? $row->created_at->format('M d, Y') : null,
            $row->updated_at ? $row->updated_at->format('M d, Y') : null,
        ];
    }

    public function registerEvents(): array
    {
        $column_count = $this->column_count;

        return [
            AfterSheet::class => function (AfterSheet $event) use ($column_count) {
                // set columns to autosize
                for ($i = 1; $i <= $column_count; $i++) {
                    $column = Coordinate::stringFromColumnIndex($i);
                    $event->sheet->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}
