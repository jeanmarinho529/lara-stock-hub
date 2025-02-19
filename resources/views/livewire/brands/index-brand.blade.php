@section('title', 'Todas as Marcas')
@section('page', 'Todas as Marcas')

<div>

    @if (session()->has('message'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-md">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-md">
            {{ session('error') }} 
        </div>
    @endif

    <div class="sm:col-span-6">
        <div class="overflow-x-auto">

            <div class="mb-10 grid grid-cols-1 sm:grid-cols-9 gap-x-6 gap-y-8">
                <div class="sm:col-span-7">
                    <x-input name="filter" wire:model.live="filter"
                        placeholder="Filtre por Nome" autocomplete="off">Filtro</x-input>
                </div>

                <div class="sm:mt-9 sm:col-span-1">
                    <a href="{{ route('brands.create') }}"
                        class="rounded-md bg-indigo-600 px-3 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Nova Marca
                    </a>
                </div>
            </div>

            <table class="min-w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Nome</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600"></th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($brands as $brands)
                        <tr class="border-b">
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $brands['name'] }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700 flex justify-end items-center space-x-4">
                                <a href="{{ route('brands.edit', $brands['id']) }}"
                                    class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs hover:bg-blue-200 hover:blue-blue-600 focus:outline-none cursor-pointer">
                                    Editar
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="pagination mt-6">
        
    </div>
</div>
