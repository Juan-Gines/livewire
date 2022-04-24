<div>
    <x-jet-danger-button wire:click="$set('open','true')">
        Crear nuevo post
    </x-jet-danger-button>
    <x-jet-dialog-modal wire:model='open'>
        <x-slot name="title">
            Crear un nuevo post
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
            @endif

            <div class="mb-4">

                <x-jet-label value="Título del post" />
                {{-- El wire:model.defer nos venía bien para que no actualice hasta que enviemos el formulario
                    Pero como queremos que se verifique en tiempo real nuestros inputs ahora deberiamos prescindir del .defer --}}
                <x-jet-input type='text' class="w-full" wire:model="title" />
                {{-- Usamos un componente de jetstream para mostrar las validaciones en vez de la directiva error de blade 
                @error('title')
                    <span>{{ $message }}</span>
                @enderror --}}
                <x-jet-input-error for="title"></x-jet-input-error>
            </div>
            <div class="mb-4">{{-- este comando de livewire impide que al hacer cambios en el componente no renderize este post y no pierda los stilos de editor --}}
                <x-jet-label value="Contenido del post" />
                {{-- Creamos un nuevo archivo css para crear estilos para un textarea form.css lo importamos en app.css y lo compilamos todo --}}
                <div wire:ignore>
                    <textarea id="editor" rows="6" class="form-control w-full" wire:model="content"></textarea>
                </div>
                <x-jet-input-error for="content"></x-jet-input-error>
            </div>
            <div class="mb-4">
                {{-- Creamos un imput file para guardar las imagenes
                    Y jugamos con los cambios de id para borrar el contenido del imput file --}}
                <input type="file" wire:model="image" id={{ $identificador }} />
                <x-jet-input-error for="image"></x-jet-input-error>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('open',false)" class="mr-4">
                Cancelar
            </x-jet-secondary-button>
            {{-- Cuando se esté guardando el formulario vamos a darle interactividad al botón, deshabilitandolo y dandole opacidad también se deshabilita mientras se carga la imagen previsualizandola --}}
            <x-jet-danger-button wire:click="save" wire:loading.attr="disabled" wire:target="save,image"
                class="disabled:opacity-25">
                Crear post
            </x-jet-danger-button>
        </x-slot>

    </x-jet-dialog-modal>
    @push('js')
        {{-- vamos a colocar el ckeditor para hacer que nuestro textarea tenga esta funcionalidad --}}
        <script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>
        <script>
            ClassicEditor
                .create(document.querySelector('#editor'))
                .then((editor) => { //este then se lo añadimos para que cada vez que haya un cambio se guarde en el textarea
                    editor.model.document.on('change:data', () => {
                        @this.set('content', editor.getData());
                    })
                    Livewire.on('resetCKEditor', () => {
                        editor.setData('');
                    })
                })
                .catch(error => {
                    console.error(error);
                });
        </script>
    @endpush
</div>
