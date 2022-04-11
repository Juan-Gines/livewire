<div>

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
            {{-- En este input ligamos su contenido a la propiedad search que tenemos en el componente ShowPosts es un componente de jetstream --}}
            <div class="px-6 py-4">
                <x-jet-input class="w-full" type="text" wire:model="search"
                    placeholder="Escriba lo que quiera buscar...">
                </x-jet-input>
            </div>
            @if ($posts->count())

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="cursor-pointer px-6 py-3 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
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
                            <th class="cursor-pointer px-6 py-3 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
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
                            <th class="cursor-pointer items-center align-middle px-6 py-3 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
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
                        @foreach ($posts as $post)
                            <tr>
                                <td class="px-6 py-4">

                                    <div class="text-sm text-gray-900">{{ $post->id }}</div>

                                </td>

                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $post->title }}</div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $post->content }}</div>
                                </td>

                                <td class="px-6 py-4 text-right  text-sm font-medium">
                                    <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="px-6 py-4">
                    No hay registros que coincidan con la búsqueda.
                </div>
            @endif
        </x-table>
    </div>
</div>
