<?php

namespace App\Filament\Resources\TaskResource\Widgets;

use App\Models\Task;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static function getAllTasks()
    {
        $tasks = Task::all();
        return [
            'todo' => $tasks->where('status', 0)->count(),
            'in_progress' => $tasks->where('status', 1)->count(),
            'done' => $tasks->where('status', 2)->count(),
            'total' => $tasks->count(),
        ];
    }

    protected function getHeading(): string
    {
        return 'Task Progress Overview';
    }

    protected function getStats(): array
    {
        $taskStats = self::getAllTasks();
        return [
            Stat::make('Todo', $taskStats['todo'])
                ->color('gray')
                ->icon('heroicon-o-rectangle-stack'),

            Stat::make('In Progress', $taskStats['in_progress'])
                ->color('info')
                ->icon('heroicon-o-arrow-right-circle'),
            Stat::make('Done', $taskStats['done'])
                ->color('success')
                ->icon('heroicon-o-check-circle'),
        ];
    }
}
