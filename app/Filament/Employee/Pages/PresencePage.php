<?php

namespace App\Filament\Employee\Pages;

use App\Models\Project;
use App\Models\Location;
use App\Models\Presence;
use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Carbon\Carbon;

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
                ->options(
                    Project::with('client')->get()->mapWithKeys(function ($project) {
                        return [
                            $project->id => $project->id . ' - ' . ($project->client->name ?? '-'),
                        ];
                    })
                )
                ->searchable()
                ->preload()
                ->live()
                ->required(),

            Select::make('location_id')
                ->label('Pilih Lokasi')
                ->options(function (callable $get) {
                    $projectId = $get('project_id');
                    if (!$projectId) return [];

                    return Location::where('project_id', $projectId)
                        ->get()
                        ->mapWithKeys(fn ($loc) => [
                            $loc->id => $loc->project_id . ' - ' . $loc->name,
                        ])
                        ->toArray();
                })
                ->required()
                ->disabled(fn (callable $get) => !$get('project_id'))
                ->reactive(),
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
        $this->form->validate();
        $state = $this->form->getState();

        $alreadyExists = Presence::where('employees_id', Auth::guard('employee')->id())
            ->where('project_id', $state['project_id'])
            ->where('location_id', $state['location_id'])
            ->whereDate('date', Carbon::today())
            ->exists();

        if ($alreadyExists) {
            Notification::make()
                ->warning()
                ->title('Presensi Gagal')
                ->body('Kamu sudah absen hari ini untuk lokasi dan project yang sama.')
                ->send();
            return;
        }

        Presence::create([
            'employees_id' => Auth::guard('employee')->id(),
            'project_id' => $state['project_id'],
            'location_id' => $state['location_id'],
            'date' => Carbon::today()->toDateString(),
            'timestamp' => Carbon::now()->toTimeString(),
        ]);

        $this->form->fill();
        $this->resetPage();

        Notification::make()
            ->success()
            ->title('Absen Berhasil')
            ->send();
    }

    public function getLatestPresencesProperty()
    {
        return Presence::with(['project', 'location'])
            ->where('employees_id', Auth::guard('employee')->id())
            ->latest('date')
            ->paginate(5);
    }
}