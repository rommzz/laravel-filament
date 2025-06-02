<?php

namespace App\Filament\Resources\TaskResource\Widgets;

use App\Models\Task;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class StatsTable extends BaseWidget
{
    protected static ?string $heading = 'Daftar Tugas'; // Judul widget
    protected int|string|array $columnSpan = 'full'; // Lebar widget di layout

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return Task::query()->with(['project', 'user']);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('project.title')
                ->label('Project'),
            TextColumn::make('title')
                ->label('Judul Tugas'),
            TextColumn::make('user.name')
                ->label('Karyawan'),
            TextColumn::make('status')
                ->label('Status')
                ->badge()
                ->formatStateUsing(fn ($state) => match ($state) {
                    0 => 'Todo',
                    1 => 'In Progress',
                    2 => 'Done',
                    default => 'Unknown',
                })
                ->color(fn ($state) => match ($state) {
                    0 => 'gray',
                    1 => 'info',
                    2 => 'success',
                    default => 'secondary',
                }),
            TextColumn::make('percent')
                ->label('Persentase')
                ->getStateUsing(fn ($record) => $record->completePercentage())
                ->formatStateUsing(fn ($state) => "{$state}%"),
            TextColumn::make('due_date')
                ->label('Tanggal Deadline')
                ->date(),
        ];
    }
    protected $listeners = ['taskDeleted' => '$refresh'];

}
