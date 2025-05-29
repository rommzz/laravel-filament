<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required()->label('Nama'),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->label('Email')
                    ->unique(ignoreRecord: true),
                Select::make('roles')
                    ->relationship('roles', 'name')
                    ->preload()
                    ->searchable(),
                TextInput::make('password')
                    ->password()
                    ->required()
                    ->label('Kata Sandi')
                    ->minLength(8)
                    ->dehydrateStateUsing(fn ($state) => bcrypt($state))
                    ->visibleOn('create')
                    ->dehydrated(fn ($state) => ! empty($state)),
                TextInput::make('password_confirmation')
                    ->password()
                    ->label('Konfirmasi Kata Sandi')
                    ->same('password')
                    ->dehydrated(false)
                    ->visibleOn('create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                'name' => Tables\Columns\TextColumn::make('name')
                    ->label('Nama'),
                // 'description' => Tables\Columns\TextColumn::make('description')
                //     ->label('Deskripsi Proyek')
                //     ->limit(50)
                //     ->wrap(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
