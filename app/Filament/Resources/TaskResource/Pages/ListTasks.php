<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use App\Filament\Resources\TaskResource\Widgets\StatsOverview;
use App\Filament\Resources\TaskResource\Widgets\StatsTable;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTasks extends ListRecords
{
    protected static string $resource = TaskResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
            StatsTable::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected $listeners = ['taskDeleted' => '$refreshData'];
    //  protected $listeners = ['reloadListWidget' => 'refreshData'];

    // public function emit()
    // {
    //     $this->dispatch('taskDeleted');
    // }

    public function refreshData()
    {
        $this->reset(); // atau panggil method khusus kalau ada untuk reload data
    }

}
