<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTask extends EditRecord
{
    protected static string $resource = TaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        // Ambil task yang sedang diedit
        $task = $this->record;

        // Ambil ID subtask yang dicentang dari state
        $checkedIds = $this->form->getState()['subtask_ids'] ?? [];

        // Update semua subtask milik task ini
        foreach ($task->subtasks as $subtask) {
            $subtask->update([
                'completed' => in_array($subtask->id, $checkedIds),
            ]);
        }
    }
}
