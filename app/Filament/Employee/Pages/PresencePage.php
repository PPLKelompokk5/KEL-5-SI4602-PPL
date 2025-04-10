<?php

namespace App\Filament\Employee\Pages;

use App\Models\Project;
use App\Models\Presence;
use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class PresencePage extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;
    use WithPagination;

    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationLabel = 'Presensi';
    protected static string $view = 'filament.employee.pages.presence-page';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function getFormSchema(): array
    {
        return [
            Select::make('project_id')
                ->label('Pilih Project')
                ->options(Project::pluck('name', 'id'))
                ->required(),
        ];
    }

    public function getForm(string $name): Form
    {
        return Form::make($this)
            ->schema($this->getFormSchema())
            ->statePath('data');
    }

    public function absen(): void
    {
        $this->validateOnly('data.project_id', [
            'data.project_id' => 'required|exists:projects,id',
        ]);

        Presence::create([
            'employees_id' => Auth::guard('employee')->id(),
            'project_id' => $this->data['project_id'],
            'date' => now()->toDateString(),
            'timestamp' => now()->toTimeString(),
        ]);
    }

    public function getLatestPresencesProperty()
    {
        return Presence::with('project')
            ->where('employees_id', Auth::guard('employee')->id())
            ->latest('date')
            ->paginate(5);
    }
}