<?php

namespace App\Filament\Resources\TaskResource\Widgets;

use App\Models\Project;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class StatsTaskProject extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Project::query()->withCount([
                    'tasks as todo_count' => fn (Builder $query) => $query->where('status', 0),
                    'tasks as in_progress_count' => fn (Builder $query) => $query->where('status', 1),
                    'tasks as done_count' => fn (Builder $query) => $query->where('status', 2),
                    'tasks as total_count',
                ])
            )
            ->columns([
                TextColumn::make('title')
                    ->label('Proyek'),

                TextColumn::make('todo_count')
                    ->label('To Do'),

                TextColumn::make('in_progress_count')
                    ->label('In Progress'),

                TextColumn::make('done_count')
                    ->label('Done'),

                TextColumn::make('total_count')
                    ->label('Total'),
            ]);
    }
}
