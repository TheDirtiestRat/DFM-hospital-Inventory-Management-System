<?php

namespace App\Livewire;

use App\Models\Patient;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class PatientTable extends PowerGridComponent
{
    use WithExport;

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            // Header::make()->showSearchInput()->showToggleColumns(),
            Header::make()->showSearchInput()->showToggleColumns(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Patient::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            // ->add('id')
            ->add('case_no')
            ->add('first_name')

            /** Example of custom column using a closure **/
            ->add('first_name_lower', fn (Patient $model) => strtolower(e($model->first_name)))

            ->add('mid_name')
            ->add('last_name')
            ->add('birth_date_formatted', fn (Patient $model) => Carbon::parse($model->birth_date)->format('d/m/Y'))
            ->add('age')
            ->add('birth_place')
            ->add('blood_type')
            ->add('gender')
            ->add('religion')
            ->add('citizenship')
            ->add('contact_no')
            ->add('address')
            ->add('created_at_formatted', fn (Patient $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }

    public function columns(): array
    {
        return [
            // Column::make('Id', 'id'),
            Column::make('Case no', 'case_no')
                ->sortable()
                ->searchable(),

            Column::make('First name', 'first_name')
                ->sortable()
                ->searchable(),

            Column::make('Mid name', 'mid_name')
                ->sortable()
                ->searchable(),

            Column::make('Last name', 'last_name')
                ->sortable()
                ->searchable(),

            Column::make('Birth date', 'birth_date_formatted', 'birth_date')
                ->sortable(),

            Column::make('Age', 'age'),
            Column::make('Birth place', 'birth_place')
                ->sortable()
                ->searchable(),

            Column::make('Blood type', 'blood_type')
                ->sortable()
                ->searchable(),

            Column::make('Sex', 'gender')
                ->sortable()
                ->searchable(),

            Column::make('Religion', 'religion')
                ->sortable()
                ->searchable(),

            Column::make('Citizenship', 'citizenship')
                ->sortable()
                ->searchable(),

            Column::make('Contact no', 'contact_no')
                ->sortable()
                ->searchable(),

            Column::make('Address', 'address')
                ->sortable()
                ->searchable(),

            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('first_name')->operators(['contains']),
            Filter::inputText('mid_name')->operators(['contains']),
            Filter::inputText('last_name')->operators(['contains']),
            Filter::datepicker('birth_date'),
            Filter::inputText('birth_place')->operators(['contains']),

            Filter::select('blood_type', 'blood_type')
                ->dataSource(Patient::select('blood_type')->distinct()->get())
                ->optionValue('blood_type')
                ->optionLabel('blood_type'),
            // Filter::inputText('gender')->operators(['contains']),

            Filter::select('gender', 'gender')
                ->dataSource(Patient::select('gender')->distinct()->get())
                ->optionValue('gender')
                ->optionLabel('gender'),

            Filter::inputText('religion')->operators(['contains']),
            Filter::inputText('citizenship')->operators(['contains']),
            Filter::inputText('address')->operators(['contains']),
            // Filter::datetimepicker('created_at'),
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert(' . $rowId . ')');
    }

    public function actions(\App\Models\Patient $row): array
    {
        return [
            Button::add('edit-patient')
                ->slot('Edit')
                ->class('btn btn-primary')
                ->route('patient.edit', ['patient' => $row->id])
                ->tooltip('Edit Record'),
            // Button::add('show')
            //     ->slot('Details')
            //     ->id()
            //     ->class('btn btn-success')
            //     ->route('patient.show', ['patient' => $row->id])
        ];
    }

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
