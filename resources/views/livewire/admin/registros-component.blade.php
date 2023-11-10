<div wire:poll.5000ms>
    <div class="py-5 bg-gray-100 dark:bg-slate-950 flex items-center justify-center">
        <div class="container max-w-screen-lg mx-auto">

            <div class="">
                <div class="dark:bg-slate-950 bg-slate-100 rounded shadow-lg p-4 px-4 md:p-8 mb-6 ">

                    <div>
                        @if (session('mensaje'))
                            <!-- Warning -->
                            <div class="mt-5">
                                <div class="bg-green-100 text-green-600 px-3 py-2 rounded">
                                    <svg class="inline w-3 h-3 shrink-0 fill-current" viewBox="0 0 12 12">
                                        <path
                                            d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                    </svg>
                                    <span class="text-sm">
                                        {{ session('mensaje') }}
                                    </span>
                                </div>
                            </div>
                        @endif





                        <form wire:submit.prevent="cargarBase">

                            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                                <div class="text-gray-600">
                                    <p class="font-medium text-lg">Sube un nuevo registro</p>
                                    <p>Por favor carga los datos con la plantilla correcta.</p>
                                </div>

                                <div class="lg:col-span-2">
                                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">


                                        <div class="form-group col-span-6 ">
                                            <x-label for="nombre">Nombre</x-label>
                                            <x-input type="text" wire:model="nombre"
                                                class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:bg-slate-900" />
                                            @error('nombre')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>


                                        <div class="form-group col-span-6">
                                            <x-label for="descripcion">Descripción</x-label>
                                            <x-input wire:model="descripcion"
                                                class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:bg-slate-900"></x-input>
                                            @error('descripcion')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>


                                        <div class="form-group col-span-3">
                                            <x-label for="fecha_desde">Fecha Inicial</x-label>
                                            <x-input type="date" wire:model="fecha_desde"
                                                class="form-control h-10 border mt-1 rounded px-4 w-full dark:bg-slate-900 bg-gray-50" />
                                            @error('fecha_desde')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-span-3">
                                            <x-label for="fecha_hasta">Fecha Final</x-label>
                                            <x-input type="date" wire:model="fecha_hasta"
                                                class="form-control h-10 border mt-1 rounded px-4 w-full dark:bg-slate-900 bg-gray-50" />
                                            @error('fecha_hasta')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-span-6">
                                            <x-label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"  for="archivo">Archivo XLSX</x-label>
                                            <x-input type="file" wire:model="archivo" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" />
                                            <div class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="user_avatar_help">A profile picture is useful to confirm your are logged into your account</div>

                                            @error('archivo')
                                                <div class="mt-5">
                                                    <div class="bg-red-100 text-red-600 px-3 py-2 rounded">
                                                        <svg class="inline w-3 h-3 shrink-0 fill-current" viewBox="0 0 12 12">
                                                            <path d="M6 1.5A4.49 4.49 0 002.5 6c0 2.49 2.01 4.5 4.5 4.5s4.5-2.01 4.5-4.5S8.49 1.5 6 1.5zM6 10a3.48 3.48 0 01-3.5-3h7a3.48 3.48 0 01-3.5 3z" />
                                                        </svg>
                                                        <span class="text-danger">{{ $message }}</span>
                                                    </div>
                                                </div>

                                            @enderror
                                        </div>



                                        <div class="col-span-6 flex justify-center">

                                            <x-button type="submit" class="mt-2">Cargar Base de Datos</x-button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-32 px-4 sm:px-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4 sm:px-6 pb-2 grid grid-cols-2">

            <div>

                <div class="form-group mt-2">
                    <x-select wire:model="registroId" wire:change="contarMujeresAccidentadas" class="form-control">
                        <option value="">Selecciona un registro</option>
                        @foreach ($registros as $registro)
                            <option value="{{ $registro->id }}">{{ $registro->nombre_registro }}</option>
                        @endforeach
                    </x-select>
                </div>

                @if ($registroId)
                    <x-label> Conteo de mujeres accidentadas para el Registro seleccionado:
                        {{ $conteoMujeres }}</x-label>


                    <x-label>Conteo de mujeres accidentadas para el Registro seleccionado:
                        {{ $conteoHombres }}
                    </x-label>
                @endif
            </div>

            <div>
                <h1>
                    EL NUMERO TOTAL DE MUJERES ACCIDENTADAS ES {{ $numeroMujeres }}
                </h1>

                <h1>
                    EL NUMERO TOTAL DE HOMBRES ACCIDENTADOS ES {{ $numeroHombres }}
                </h1>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-24 py-10">
        <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-xl sm:rounded-lg">


            <div
                class="col-span-full xl:col-span-8 bg-white dark:bg-slate-900 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
                <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
                    <h2 class="font-semibold text-slate-800 dark:text-slate-100">Registros</h2>
                </header>
                <div class="p-3">

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="table-auto w-full dark:text-slate-300 dark:bg-slate-900">
                            <!-- Table header -->
                            <thead
                                class="text-xs uppercase text-slate-400 dark:text-slate-500 bg-slate-50 dark:bg-slate-900 dark:bg-opacity-50 rounded-sm">
                                <tr>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Nombre</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-center">Descripcion</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-center">Primera Fecha</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-center">Ultima Fecha</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-center">Acciones</div>
                                    </th>
                                </tr>
                            </thead>
                            <!-- Table body -->
                            <tbody class="text-sm font-medium divide-y divide-slate-100 dark:divide-slate-700">
                                <!-- Row -->
                            @foreach ($registros as $registro)

                                <tr>
                                    <td class="p-2">
                                        <div class="flex items-center">
                                            <svg class="shrink-0 mr-2 sm:mr-3" width="36" height="36"
                                                viewBox="0 0 36 36">
                                                <circle fill="#24292E" cx="18" cy="18" r="18" />
                                                <path
                                                    d="M18 10.2c-4.4 0-8 3.6-8 8 0 3.5 2.3 6.5 5.5 7.6.4.1.5-.2.5-.4V24c-2.2.5-2.7-1-2.7-1-.4-.9-.9-1.2-.9-1.2-.7-.5.1-.5.1-.5.8.1 1.2.8 1.2.8.7 1.3 1.9.9 2.3.7.1-.5.3-.9.5-1.1-1.8-.2-3.6-.9-3.6-4 0-.9.3-1.6.8-2.1-.1-.2-.4-1 .1-2.1 0 0 .7-.2 2.2.8.6-.2 1.3-.3 2-.3s1.4.1 2 .3c1.5-1 2.2-.8 2.2-.8.4 1.1.2 1.9.1 2.1.5.6.8 1.3.8 2.1 0 3.1-1.9 3.7-3.7 3.9.3.4.6.9.6 1.6v2.2c0 .2.1.5.6.4 3.2-1.1 5.5-4.1 5.5-7.6-.1-4.4-3.7-8-8.1-8z"
                                                    fill="#FFF" />
                                            </svg>
                                            <div class="text-slate-800 dark:text-slate-100">{{  $registro->nombre_registro }}</div>
                                        </div>
                                    </td>
                                    <td class="p-2">
                                        <div class="text-center">{{  $registro->descripcion }}</div>
                                    </td>
                                    <td class="p-2">
                                        <div class="text-center text-emerald-500">{{  $registro->fecha_inicial }}</div>
                                    </td>
                                    <td class="p-2">
                                        <div class="text-center text-sky-500">{{  $registro->fecha_final }}</div>
                                    </td>
                                    <td class="p-2">
                                          <!-- Iconos de ver, editar y eliminar -->
                                          <div class="flex justify-center">

                                            {{-- -->Ver User --}}
                                            <a href="#" class="icon-blue green-hover"
                                                wire:click="showUser({{ $registro->nombre_registro }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" class="w-10 h-6">
                                                    <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                                                    <path fill-rule="evenodd"
                                                        d="M.664 10.59a1.651 1.651 0 010-1.186A10.004 10.004 0 0110 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0110 17c-4.257 0-7.893-2.66-9.336-6.41zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </a>


                                            {{-- -->Eliminar User --}}

                                            <a href="#"
                                                wire:click="confirmUserDeletion({{ $registro->nombre_registro }})"
                                                class="red-hover icon-red">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" class="w-10 h-6">
                                                    <path fill-rule="evenodd"
                                                        d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                        </div>

                                    </td>
                                </tr>
                                <!-- Row -->

                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>









