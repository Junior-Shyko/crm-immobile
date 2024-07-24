<div>
   <h1>ID usuário: {{$idUser}} - {{request()->get('id')}}</h1>

    <div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900">
        @php foreach ($roles as $role) : @endphp
        @if($this->updatedRolesTeste($role->name) !== 'Saas Super Administrador')
        <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <div class="items-center sm:flex xl:block 2xl:flex sm:space-x-4 xl:space-x-0 2xl:space-x-4">
                <div>
                    <h3 class="mb-1 text-xl font-bold text-gray-900 dark:text-white">
                        Papel: {{$this->updatedRolesTeste($role->name)}}
                    </h3>
                    <div class="mb-4 text-sm text-gray-500 dark:text-gray-400">
                        Define o papel de cada usuário
                    </div>
                    <div class="flex items-center space-x-4">
                        <ul>
                        @php
                            $permissions = $role->permissions; // Obtenha as permissões associadas à role
                            foreach ($permissions as $permission) { @endphp
                            <li class="p-2 rounded-md" >
                                <div class="flex align-middle flex-row justify-between">
                                    <div class="p-2">
                                        <input type="checkbox" wire:click="setPermissions({{request()->get('id')}})" class="h-4 w-4" value="true"/>
                                    </div>
                                    <div class="p-2">
                                        <p class="text-lg line-through text-gray-400">{{$permission->name}}</p>
                                    </div>
                                </div>
                            </li>

                        @php
                            }
                        @endphp
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @php endforeach; @endphp

    </div>
</div>
