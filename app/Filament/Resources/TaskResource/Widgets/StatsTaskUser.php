<?php

namespace App\Filament\Resources\TaskResource\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class StatsTaskUser extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::query()->withCount([
                    'tasks as todo_count' => fn (Builder $query) => $query->where('status', 0),
                    'tasks as in_progress_count' => fn (Builder $query) => $query->where('status', 1),
                    'tasks as done_count' => fn (Builder $query) => $query->where('status', 2),
                    'tasks as total_count',
                ])
            )
            ->columns([
                TextColumn::make('name')->label('User'),

                TextColumn::make('todo_count')->label('To Do'),

                TextColumn::make('in_progress_count')->label('In Progress'),

                TextColumn::make('done_count')->label('Done'),

                TextColumn::make('total_count')->label('Total'),
            ]);
    }
}
