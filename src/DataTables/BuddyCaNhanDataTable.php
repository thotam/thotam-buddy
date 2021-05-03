<?php

namespace Thotam\ThotamBuddy\DataTables;

use Thotam\ThotamBuddy\Models\Buddy;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class BuddyCaNhanDataTable extends DataTableComponent
{

    public array $bulkActions = [
        'exportSelected' => 'Export',
    ];

    protected string $pageName = 'buddy_canhan';
    protected string $tableName = 'buddy_canhan';

    public function exportSelected()
    {
        if ($this->selectedRowsQuery->count() > 0) {
            //dd($this->selectedRowsQuery);
            return (new Buddy($this->selectedRowsQuery))->download($this->tableName.'.xlsx');
        }
    }

    public function columns(): array
    {
        return [
            Column::make('Mã nhân sự', 'hr_key')
                ->sortable()
                ->searchable(),
            Column::make('Họ và tên', 'id')
                ->searchable(),
            Column::make('Active')
                ->sortable()
        ];
    }

    public function query(): Builder
    {
        return Buddy::query();
    }
}