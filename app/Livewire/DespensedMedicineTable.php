<?php

namespace App\Livewire;

use App\Models\DespenseMedicine;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;

use PowerComponents\LivewirePowerGrid\Exportable;

use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\Rule; 

use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

use PowerComponents\LivewirePowerGrid\Traits\WithExport;

use OpenSpout\Reader\CSV\Options;

final class DespensedMedicineTable extends PowerGridComponent
{
    use WithExport;

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_CSV),
            Header::make()->showSearchInput()->showToggleColumns(),
            // Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return DespenseMedicine::query()->join('patients', 'despense_medicines.despensed', '=', 'patients.case_no')->selectRaw('despense_medicines.id, despense_medicines.*, concat(patients.first_name, " ", patients.mid_name, " ",patients.last_name) as patient');
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('despenser')

           /** Example of custom column using a closure **/
            ->addColumn('despenser_lower', fn (DespenseMedicine $model) => strtolower(e($model->despenser)))

            ->addColumn('patient')
            ->addColumn('medicine')
            ->addColumn('doctor')
            ->addColumn('quantity')
            ->addColumn('created_at_formatted', fn (DespenseMedicine $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('Despenser', 'despenser')
                ->sortable()
                ->searchable(),

            Column::make('Patients', 'patient')
                ->sortable(),
                // ->searchable(),

            Column::make('Medicine', 'medicine')
                ->sortable()
                ->searchable(),

            Column::make('Quantity', 'quantity'),
            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            // Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('despenser')->operators(['contains']),
            Filter::inputText('despensed')->operators(['contains']),
            Filter::inputText('doctor')->operators(['contains']),
            Filter::inputText('medicine')->operators(['contains', 'is', 'is_not']),
            Filter::inputText('quantity')->operators(['contains', 'is', 'is_not']),
            // Filter::datetimepicker('created_at'),
            // Filter::datepicker('created_at_formatted', 'created_at'),
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    }

    // public function actions(\App\Models\DespenseMedicine $row): array
    // {
    //     return [
    //         Button::add('edit')
    //             ->slot('Edit: '.$row->id)
    //             ->id()
    //             ->class('btn btn-secondary btn-sm')
    //             ->dispatch('edit', ['rowId' => $row->id])
    //     ];
    // }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
