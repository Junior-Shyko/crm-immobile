<?php

namespace App\Repositories;

use App\Models\User;
use Filament\Navigation\NavigationItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use function is_null;
use function redirect;

class DataPersonalRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public User $user,
    ) {}

    //Verifica se o usuario tem endereço.
    public function redirectCreateOrEditDataPersonal() : RedirectResponse|Redirector
    {
        if($this->user->dataPersonal)
        {
            return redirect('admin/data-personals/'.$this->user->dataPersonal->id.'/edit' );
        }
        return redirect('admin/data-personals/create?id='.$this->user->id );
    }


}
