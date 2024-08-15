<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use App\Repositories\DataPersonalRepository;
use App\Repositories\UserRepository;
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
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;


class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Usuários';
    protected static ?string $navigationGroup = 'Usuário';
    protected static ?int $navigationSort = 0;
    public static function form(Form $form): Form
    {
        $user = auth()->user();

        return $form
            ->schema(function () use ($user){
                $schema = [
                    TextInput::make('name')
                        ->label('Nome do Usuário')
                        ->required(),
                    TextInput::make('email')
                        ->label('E-mail do Usuário')
                        ->required(),
                    TextInput::make('password')
                        ->label('Senha')
                        ->required(),
                ];
                if ($user->hasRole(['saas-super-admin', 'super-admin'])) {
                    $schema[] = Section::make('Permissão')
                        ->description('Gerencie as permissões dos seus usuários')
                        ->schema([
                            Select::make('permissions')
                                ->label('Permissão')
                                ->multiple()
                                ->relationship(name: 'permissions', titleAttribute: 'name')
                                ->preload(),
                        ]);
                    $schema[] = Section::make('Papeis')
                        ->description('Altere o papel dos seus usuários')
                        ->schema([
                            Select::make('roles')
                                ->label('Papel')
                                ->relationship(name: 'roles', titleAttribute: 'name')
                                ->preload(),
                        ]);
                }
                return $schema;
            });
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
                TextColumn::make('dataPersonal.sex')
                    ->label('Sexo'),
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
                    Tables\Actions\EditAction::make()
                    ->label('Editar acesso')
                    ->icon('heroicon-c-user-circle'),
                    Action::make('Editar Dados Pessoais')
                        ->icon('heroicon-o-pencil-square')
                        ->action(function (User $user) {
                            //Verifica se tem dados pessoais para fazer o redirecionamento correto
                            $dtPersonal = new DataPersonalRepository($user);
                            return $dtPersonal->redirectCreateOrEditDataPersonal();
                        }),
                    Tables\Actions\DeleteAction::make(),
                ])->button()
                    ->label('Ação')
                    ->color('primary')
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

    public static function getNavigationLabel(): string
    {
        $label = UserRepository::adaptsNavigationUser();
        return $label['label'];
    }


    public static function getNavigationUrl():string
    {
        //Muda o link do sidebar dependendo do papel do usuario
       $url = UserRepository::adaptsNavigationUser();

       if($url['url'] instanceof Redirector) {
           return $url['url']->getUrlGenerator()->getRequest()->server('PATH_INFO');
       }elseif($url['url'] instanceof RedirectResponse){
           return $url['url']->getTargetUrl();
       }else{
           return $url['url'];
       }
    }

}
