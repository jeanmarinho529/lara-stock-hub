@section('title', 'Todos os Produtos')
@section('page', 'Todos os Produtos')

<div>

    <div class="sm:col-span-6">
        <div class="overflow-x-auto">

            <div class="mb-10 grid grid-cols-1 sm:grid-cols-9 gap-x-6 gap-y-8">
                <div class="sm:col-span-7">
                    <x-input name="filter" wire:model.live="filter"
                        placeholder="Filtre por Nome, Código, Tipo" autocomplete="off">Filtro</x-input>
                </div>


                <div class="sm:mt-9 sm:col-span-1">
                    <a href="{{ route('products.create', 1) }}"
                        class="rounded-md bg-indigo-600 px-3 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Novo Produto
                    </a>
                </div>
            </div>

            <table class="min-w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Tipo</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Nome</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Código</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Valor</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600"></th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($products as $products)
                        <tr class="border-b">
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $products['type'] }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $products['name'] }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $products['code'] }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $products['amount'] }} $</td>
                            <td class="px-4 py-2 text-sm text-gray-700"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


</div>
