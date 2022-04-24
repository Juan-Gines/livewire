<div wire:init="loadPosts">

    {{-- Nos hemos traido esto de dashboard.blade por que no se estaba mostrando ya que solo muestra la plantilla app, esto y pasa del dashboard --}}

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    {{-- Variables pasadas directamente al componente en la vista
        {{$title}}
    {{$titulo}} --}}

    {{-- Variable pasada por la ruta a usar el componente de controller --}}
    <div class="max-w-7xl mx-auto sm:px-6 py-12">
        <x-table>
            {{-- En este input ligamos su contenido a la propiedad search que tenemos en el componente ShowPosts es un componente de jetstream
                Tambien vamos a poner un select para cambiar los archivos de paginación y un componente livewire para crear registros --}}
            <div class="flex items-center px-6 py-4 bg-gradient-to-b from-blue-100 to-blue-200">
                <div class="flex items-center">
                    <span>Mostrar</span>
                    <select wire:model="cant" class="form-control mx-2">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span>posts</span>
                </div>
                <x-jet-input class="flex-1 mx-6" type="text" wire:model="search"
                    placeholder="Escriba lo que quiera buscar...">
                </x-jet-input>
                @livewire('create-post')
            </div>
            @if (count($posts))

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-b from-blue-200 to-blue-300">
                        <tr>
                            <th scope="col"
                                class="cursor-pointer px-6 py-3 text-left text-xs leading-4 font-black text-gray-800 uppercase tracking-wider"
                                wire:click="order('id')">
                                <span class=" whitespace-nowrap">ID
                                    {{-- sort --}}
                                    @if ($sort == 'id')
                                        @if ($direction == 'desc')
                                            <i class="fa-solid fa-arrow-down-9-1"></i>
                                        @else
                                            <i class="fa-solid fa-arrow-up-1-9"></i>
                                        @endif
                                    @else
                                        <i class="fa-solid fa-sort"></i>
                                    @endif
                                </span>

                            </th>
                            <th class="cursor-pointer px-6 py-3 text-left text-xs leading-4 font-black text-gray-800 uppercase tracking-wider"
                                wire:click="order('title')">
                                <span>Title
                                    {{-- sort --}}
                                    @if ($sort == 'title')
                                        @if ($direction == 'desc')
                                            <i class="fa-solid fa-arrow-down-z-a float-right mt-0.5"></i>
                                        @else
                                            <i class="fa-solid fa-arrow-up-a-z float-right mt-0.5"></i>
                                        @endif
                                    @else
                                        <i class="fa-solid fa-sort float-right mt-0.5"></i>
                                    @endif
                                </span>
                            </th>
                            <th class="cursor-pointer items-center align-middle px-6 py-3 text-left text-xs leading-4 font-black text-gray-800 uppercase tracking-wider"
                                wire:click="order('content')">
                                <span>Content
                                    {{-- sort --}}
                                    @if ($sort == 'content')
                                        @if ($direction == 'desc')
                                            <i class="fa-solid fa-arrow-down-z-a float-right mt-0.5"></i>
                                        @else
                                            <i class="fa-solid fa-arrow-up-a-z float-right mt-0.5"></i>
                                        @endif
                                    @else
                                        <i class="fa-solid fa-sort float-right mt-0.5"></i>
                                    @endif
                                </span>
                            </th>
                            <th class="relative px-6 py-3"></th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($posts as $item)
                            <tr>
                                <td class="px-6 py-4">

                                    <div class="text-sm text-gray-900">{{ $item->id }}</div>

                                </td>

                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $item->title }}</div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{!! $item->content !!}</div>
                                </td>

                                <td class="px-6 py-4 text-sm font-medium flex">
                                    {{-- Creamos un componente livewire de anidamiento para cada uno de los posts pasandole una variable post con su información 
                                        VAMOS A MODIFICAR LA VISTA PARA QUE EL PROYECTO SOLO CARGUE UN MODAL EN VEZ DE UN MODAL PARA CADA REGISTRO
                                        PARA ELLO OBVIAMOS EL COMPONENTE DE ANIDAMIENTO DE LIVEWIRE Y MODIFICAMOS ESTE PARA INTEGRARLO
                                    @livewire('edit-post', ['post' => $post], key($post->id)) --}}
                                    {{-- PRIMERO COPIAMOS EL BOTÓN --}}
                                    <a class="btn btn-green" wire:click="edit({{ $item->id }})">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a class="btn btn-red ml-2" wire:click="$emit('deletePost',{{ $item->id }})">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Aquí ponemos la paginación en la vista --}}

                @if ($posts->hasPages())
                    <div class="px-6 py-3">
                        {{ $posts->links() }}
                    </div>
                @endif
            @else
                <div class="px-6 py-4">
                    No hay registros que coincidan con la búsqueda.
                </div>
            @endif



        </x-table>

        {{-- COPIAMOS DEL COMPONENTE EDIT-POST EL MODAL QUE UTILIZAREMOS PARA EDITAR REGISTROS --}}

        <x-jet-dialog-modal wire:model="open_edit">

            <x-slot name="title">
                Editar el post
            </x-slot>

            <x-slot name="content">
                <div wire:loading wire:target="image"
                    class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Imagen cargando!</strong>
                    <span class="block sm:inline">Espere un momento hasta que la imagen se procese.</span>
                </div>
                @if ($image)
                    {{-- Vamos a mostrar la imagen antes de guardarla aquí --}}
                    <img class="mb-4" src="{{ $image->temporaryUrl() }}">
                @elseif($post->image)
                    <img class="mb-4" src="{{ Storage::url($post->image) }}">
                @endif
                <div class="mb-4">
                    <x-jet-label value="Título del post" />
                    <x-jet-input type="text" wire:model="post.title" class="w-full" />
                    <x-jet-input-error for="post.title"></x-jet-input-error>
                </div>
                <div class="mb-4">
                    <x-jet-label value="Contenido del post" />
                    <textarea wire:model="post.content" rows="6" class="w-full form-control"></textarea>
                    <x-jet-input-error for="post.content"></x-jet-input-error>
                </div>
                <div class="mb-4">
                    {{-- Creamos un imput file para guardar las imagenes
                        Y jugamos con los cambios de id para borrar el contenido del imput file --}}
                    <input type="file" wire:model="image" id={{ $identificador }} />
                    <x-jet-input-error for="image"></x-jet-input-error>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button class="mr-4" wire:click="$set('open_edit',false)">
                    Cancelar
                </x-jet-secondary-button>
                <x-jet-danger-button wire:click="update" wire:loading.attr="disabled" wire:target="update, image"
                    class="disabled:opacity-25">
                    Actualizar post
                </x-jet-danger-button>
            </x-slot>

        </x-jet-dialog-modal>
    </div>
    @push('js')
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Livewire.on('deletePost', postId => {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás recuperar el post borrado!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Bórralo',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {

                        Livewire.emitTo('show-posts', 'delete', postId)

                        Swal.fire(
                            '¡Borrado!',
                            'Tu post a sido borrado con exito.',
                            'success'
                        )

                    }
                })
            })
        </script>
    @endpush
</div>
