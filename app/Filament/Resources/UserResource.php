<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nome do Usuário')
                    ->required(),
                TextInput::make('email')
                    ->label('E-mail do Usuário')
                    ->required(),
                Section::make('Permissão')
                    ->description('Gerencie as permissões dos seus usuários')
                    ->schema([
                        Select::make('permissions')
                            ->label('Permissão')
                            ->multiple()
                            ->relationship(name: 'permissions', titleAttribute: 'name')
                            ->preload(),
                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('E-mail')
                    ->searchable(),
                TextColumn::make('roles.name')
                    ->label('Papeis'),

                TextColumn::make('created_at')
                    ->dateTime('d/m/Y')
                    ->label('Criado em'),
            ])
            ->filters([

            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Action::make('Permissões')
                        ->icon('heroicon-s-cog-6-tooth')
                        ->action(function (User $record) {
                            return redirect('admin/settings-permissions/?id=' . $record->id);
                        })
                ])   ->button()
                    ->label('Ações')
                    ->color('primary'),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUsers::route('/'),
        ];
    }
}
