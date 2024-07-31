<?php

namespace App\Helpers;

use App\Models\DataPersonal;
use App\Models\User;
use Filament\Notifications\Notification;

class Helpers
{
    /**
     * Formata id e nome do usuário para retornar como array
     *
     * @param [type] $form
     * @return array
     */
    static public function getUserToForm($form): array
    {

        //Modo de edição de form
        if ($form->getOperation() == 'edit' || $form->getOperation() == 'view' ) {
            //Instancia um usuário se tiver object_id
            if(isset($form->getRecord()->object_id))
            {
                $user = self::getUserDataPersonal($form->getRecord()->object_id);
                $nameUser = $user->name;
                $idUser = $user->id;
            }else{
                //instanciando com o proprio registro passado
                $nameUser = $form->getRecord()->name;
                $idUser = $form->getRecord()->id;
            }

        }
        else{
            //Busca o usuário que está no id da url
            $idFromURL = request()->get('id');
            if($idFromURL !== null){
                $user = self::getUserData($idFromURL);

                $nameUser = $user->name;
                $idUser = $user->id;

            }else{
                $idUser = $form->getLivewire()->data['user_id'];
                $nameUser = null;
            }
        }
        return ['idUser' => $idUser,'nameUser' => $nameUser];
    }

    /**
     * Retorna o usuário pelo id dos dados pessoais
     *
     * @param [integer] $id
     * @return User
     */
    static public function getUserDataPersonal($id)
    {

        $personal = DataPersonal::find($id);
        if(!is_null($personal))
        {
            $user = User::find($personal->user_id);
            return $user;
        }else{
            $user = User::find($id);
            return $user;
        }
    }

    static public function getUserData($id)
    {
        $user = User::find($id);
        return $user;
    }

    //Opções para regime trabalhista
    static public function getEmploymentRelationship(): array
    {
        return [
            'Aposentado/pensionista' => 'Aposentado/pensionista',
            'Autônomo' => 'Autônomo',
            'Empresário' => 'Empresário',
            'Funcionário público' => 'Funcionário público',
            'Registro CLT' => 'Registro CLT',
            'Profisional liberal' => 'Profisional liberal',
            'Outros' => 'Outros'
        ];
    }

    //Opções para relação matrimonial
    static public function getMaritalStatus(): array
    {
        return [
            'Casado' => 'Casado',
            'Desquitado' => 'Desquitado',
            'Divorciado' => 'Divorciado',
            'União Estável' => 'União Estável',
            'Solteiro' => 'Solteiro',
            'Separado' => 'Separado',
            'Viúvo' => 'Viúvo'
        ];
    }

    /**
     * Função para mostrar as notificações
     * @param $type string
     * @param $title string
     * @param $body string
     * @param $icon string
     * @param $iconCollor string
     * @return Notification|void
     */
    static public function customNotification($type, $title, $body, $icon, $iconCollor)
    {
        switch ($type)
        {
            case 'success':
                return Notification::make()
                    ->success()
                    ->title($title)
                    ->body($body)
                    ->icon($icon)
                    ->iconColor($iconCollor)
                    ->send();
                break;
            case 'warning':
                return Notification::make()
                    ->warning()
                    ->title($title)
                    ->body($body)
                    ->icon($icon)
                    ->iconColor($iconCollor)
                    ->send();
                break;
            case 'danger':
                return Notification::make()
                    ->danger()
                    ->title($title)
                    ->body($body)
                    ->icon($icon)
                    ->iconColor($iconCollor)
                    ->send();
                break;
        }

    }


}
