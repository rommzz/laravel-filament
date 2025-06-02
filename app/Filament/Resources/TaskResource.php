<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Filament\Resources\TaskResource\RelationManagers;
use App\Filament\Resources\TaskResource\Widgets\StatsOverview;
use App\Filament\Resources\TaskResource\Widgets\TaskStatsWidget;
use App\Models\Task;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Task')
                    ->required()
                    ->maxLength(255),
                Select::make('project_id')
                    ->relationship('project', 'title')
                    ->label('Project')
                    ->required(),
                Select::make('user_id')
                    ->label('Karyawan')
                    ->relationship('user', 'name')
                    ->required(),
                DatePicker::make('due_date')
                    ->label('Tanggal Deadline')
                    ->required()
                    ->readOnlyOn('edit'),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        0 => 'Todo',
                        1 => 'In Progress',
                        2 => 'Done',
                    ])
                    ->visibleOn('edit')
                    ->required(),

                Repeater::make('subtasks')
                    ->label('Daftar Subtask')
                    ->relationship()
                    ->schema([
                        TextInput::make('title')
                            ->label('Subtask')
                            ->required(),
                    ])
                    ->addActionLabel('Tambah Subtask')
                    ->visibleOn('create'),

                CheckboxList::make('subtask_ids')
                    ->label('Daftar subtask')
                    ->options(fn ($record) =>
                        $record?->subtasks()->pluck('title', 'id')->toArray() ?? []
                    )
                    ->afterStateHydrated(function ($component) {
                        $component->state(
                            $component->getRecord()?->subtasks()->where('completed', true)->pluck('id')->toArray() ?? []
                        );
                    })
                    ->afterStateUpdated(function ($state, $component) {
                        $task = $component->getRecord();

                        foreach ($task->subtasks as $subtask) {
                            $subtask->update([
                                'completed' => in_array($subtask->id, $state),
                            ]);
                        }
                    })
                    ->visibleOn('edit'),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                'project' => TextColumn::make('project.title')
                    ->label('Project'),
                'title' => TextColumn::make('title'),
                'karyawan' => TextColumn::make('user.name')
                    ->label('Karyawan'),
                'status' => TextColumn::make('status')
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
                'percent' =>TextColumn::make('percent')
                    ->label('Persentase')
                    ->getStateUsing(fn ($record) => $record->completePercentage())
                    ->formatStateUsing(fn ($state) => "{$state}%"),
                'deadline' => TextColumn::make('due_date')
                    ->date()
                    ->label('Tanggal Deadline'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->action(function ($records, $livewire) {
                            foreach ($records as $record) {
                                $record->delete();
                            }

                            // Trigger event ke widget atau komponen lain
                            $livewire->dispatch('taskDeleted');
                            // Filament::notify('success', 'Beberapa task berhasil dihapus!');
                        }),
                ]),
            ])
            ->groups([
                'status',
                'project.title'
            ])
            ->defaultGroup('Project.title');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }
}
