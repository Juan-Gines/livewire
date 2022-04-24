<div>
    {{-- Creamos nuevo archivo css buttons.css para crearle la apariencia de botón a nuesto icono de font awesome. Y recuerda importarlo despues en app.css --}}
    <a class="btn btn-green" wire:click="$set('open',true)">
        <i class="fas fa-edit"></i>
    </a>

    {{-- Ahora creamos un modal para cuando le demos click se nos abra, para eso utilizaremos el componente de jetstream dialog-modal y dentro necesita 3 slots title content y footer --}}

    <x-jet-dialog-modal wire:model="open">

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
            @else
                <img class="mb-4" src="{{ Storage::url($post->image) }}">
            @endif
            <div class="mb-4">
                <x-jet-label value="Título del post" />
                <x-jet-input type="text" wire:model="post.title" class="w-full" />
            </div>
            <div class="mb-4">
                <x-jet-label value="Contenido del post" />
                <textarea wire:model="post.content" rows="6" class="w-full form-control"></textarea>
            </div>
            <div class="mb-4">
                {{-- Creamos un imput file para guardar las imagenes
                    Y jugamos con los cambios de id para borrar el contenido del imput file --}}
                <input type="file" wire:model="image" id={{ $identificador }} />
                <x-jet-input-error for="image"></x-jet-input-error>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button class="mr-4" wire:click="$set('open',false)">
                Cancelar
            </x-jet-secondary-button>
            <x-jet-danger-button wire:click="save" wire:loading.attr="disabled" wire:target="save, image"
                class="disabled:opacity-25">
                Actualizar post
            </x-jet-danger-button>
        </x-slot>

    </x-jet-dialog-modal>
</div>
