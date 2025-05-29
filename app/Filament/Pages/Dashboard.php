<?php
namespace App\Filament\Pages;

use App\Filament\Resources\TaskResource\Widgets\StatsOverview as TaskStatsOverview;
use App\Filament\Resources\TaskResource\Widgets\StatsTaskProject;
use App\Filament\Resources\TaskResource\Widgets\StatsTaskUser;
use App\Filament\Widgets\UserStats;
use App\Filament\Widgets\LatestUsers;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected function getHeaderWidgets(): array
    {
        return [
            TaskStatsOverview::class,
            StatsTaskProject::class,
            StatsTaskUser::class,
        ];
    }

    // protected function getWidgets(): array
    // {
    //     return [
    //         LatestUsers::class,
    //     ];
    // }
}
