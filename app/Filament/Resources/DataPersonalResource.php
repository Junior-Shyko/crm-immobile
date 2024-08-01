<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Helpers\Helpers;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\DataPersonal;
use Filament\Resources\Resource;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Leandrocfe\FilamentPtbrFormFields\Document;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DataPersonalResource\Pages;
use App\Filament\Resources\DataPersonalResource\RelationManagers;
use function auth;
use function dd;
use function dump;
use function redirect;
use function request;

class DataPersonalResource extends Resource
{
    protected static ?string $model = DataPersonal::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static bool $shouldRegisterNavigation = false;
    public static function form(Form $form): Form
    {
        $userForm = Helpers::getUserToForm($form);
        return $form
            ->schema([
                Section::make('')
                    ->description('Cadastro relacionando aos dados pessoais do usuário')
                    ->columns([
                        'md' => 3
                    ])
                    ->schema([
                        Placeholder::make('Proponente')
                            ->content($userForm['nameUser']),
                        Hidden::make('user_id')
                            ->default($userForm['idUser']),
                        Document::make('cpf')
                            ->label('CPF')
                            ->cpf()
                            ->maxLength(15),
                        Select::make('sex')
                            ->options([
                                'Masculino' => 'Masculino',
                                'Feminino' => 'Feminino'
                            ])
                            ->label('Sexo')
                            ->preload(),
                        Forms\Components\DatePicker::make('birthDate')
                            ->label('Data de Nasc.'),
                        Forms\Components\TextInput::make('identity')
                            ->label('RG/Identidade')
                            ->maxLength(100),
                        Forms\Components\TextInput::make('organConsignor')
                            ->label('Orgão Emissor')
                            ->maxLength(25),
                        Forms\Components\TextInput::make('nationality')
                            ->label('Nacionalidade')
                            ->maxLength(50),
                        Select::make('educationLevel')
                            ->options(Helpers::getEmploymentRelationship())
                            ->label('Grau de Instrução')
                            ->preload(),
                        Forms\Components\TextInput::make('naturality')
                            ->label('Natural')
                            ->maxLength(100),
                        Select::make('maritalStatus')
                            ->options(Helpers::getMaritalStatus())
                            ->label('Estado Civil')
                            ->preload(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        $idFromURL = request()->get('id');
         return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuário')
                    ->searchable(),
                Tables\Columns\TextColumn::make('birthDate')
                    ->date('d/m/Y')
                    ->label('Data de nasc.')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cpf')
                    ->label('CPF')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nationality')
                    ->label('Nacional')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Última Alteração')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('identity')
                    ->label('RG/Identidade')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
                    ->button()
                    ->label('Ações')
                    ->color('primary')
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
            'index' => Pages\ListDataPersonals::route('/'),
            'create' => Pages\CreateDataPersonal::route('/create'),
            'edit' => Pages\EditDataPersonal::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        $user = auth()->user();
        if(!is_null(request()->route()->record)){
            $idDataPersonal = request()->route()->record;
            $personal = DataPersonal::find($idDataPersonal);
        }else{
            $personal = new DataPersonal();
            $personal->user_id = $user->id;
        }
        if(isset($personal->user_id) && $personal->user_id == $user->id)
        {
            return true;
        }elseif ($user->hasRole(['saas-super-admin', 'super-admin']))
        {
            return true;
        }else{
            return false;
        }
    }
}
