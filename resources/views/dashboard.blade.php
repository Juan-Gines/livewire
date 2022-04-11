<x-app-layout>
    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Poniendo el array de segundo parametro mandamos esa información al componente --}}
            @livewire('show-posts',['title'=>'Este es un titulo del componente'])
        </div>
    </div>
</x-app-layout>
