<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DataPersonalResource\Pages;
use App\Filament\Resources\DataPersonalResource\RelationManagers;
use App\Models\DataPersonal;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;
use Leandrocfe\FilamentPtbrFormFields\Document;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use function dump;
use function request;

class DataPersonalResource extends Resource
{
    protected static ?string $model = DataPersonal::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        $user = User::find(request()->get('id'));
//        dd($user->id);
        return $form
            ->schema([
                Section::make('')
                    ->description('Cadastro relacionado aos dados pessoais do usuário')
                    ->columns([
                        'md' => 3
                    ])
                    ->schema([
                        Placeholder::make('Proponente')
                            ->content($user->id),
                        Forms\Components\Hidden::make('user_id')
                            ->default(fn() => $user->id)
                            ->required(),
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
                        Select::make('EducationLevel')
                            ->options([
                                'Ensino fundamental imcompleto' => 'Ensino fundamental imcompleto',
                                'Ensino fundamental completo' => 'Ensino fundamental completo',
                                'Ensino médio incompleto' => 'Ensino médio incompleto',
                                'Ensino médio completo' => 'Ensino médio completo',
                                'Superior completo (ou graduação)' => 'Superior completo (ou graduação)',
                                'Pós-graduação' => 'Pós-graduação',
                                'Mestrado' => 'Mestrado',
                                'Doutorado' => 'Doutorado'
                            ])
                            ->label('Grau de Instrução')
                            ->preload(),
                        Forms\Components\TextInput::make('naturality')
                            ->label('Natural')
                            ->maxLength(100),
                        Select::make('maritalStatus')
                            ->options(['Casado' => 'Casado',
                                    'Desquitado' => 'Desquitado',
                                    'Divorciado' => 'Divorciado',
                                    'União Estável' => 'União Estável',
                                    'Solteiro' => 'Solteiro',
                                    'Separado' => 'Separado',
                                    'Viúvo' => 'Viúvo'])
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
                Tables\Columns\TextColumn::make('birthDate')
                    ->date('d/m/Y')
                    ->label('Data de nasc.')
                    ->sortable(),
                Tables\Columns\TextColumn::make('cpf')
                    ->label('CPF')
                    ->searchable()
                    ->sortable(),
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
}
