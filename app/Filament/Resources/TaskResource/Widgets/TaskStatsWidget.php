<?php

namespace App\Filament\Resources\TaskResource\Widgets;

use App\Models\Task;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Section;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TaskStatsWidget extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Section::make('Total Tasks', Task::count()),
        ];
    }
}
