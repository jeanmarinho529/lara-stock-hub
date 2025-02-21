@section('title', 'Todos os Produtos')
@section('page', 'Todos os Produtos')

<div>
    <x-alert></x-alert>

    <div class="sm:col-span-6">
        <div class="overflow-x-auto">

            <div class="mb-10 grid grid-cols-1 sm:grid-cols-9 gap-x-6 gap-y-8">
                <div class="sm:col-span-6">
                    <x-input name="filter" wire:model.live="filter" placeholder="Filtre por Nome e Código"
                        autocomplete="off">Filtro</x-input>
                </div>

                <div class="sm:col-span-2">
                    <x-select name="type" label="Tipo do Produto" wire:model.live="type">
                        <option value="" selected>Filtre por Tipo de Produto</option>
                        <option value="product">Produto</option>
                        <option value="service">Seriviço</option>
                    </x-select>
                </div>

                <div class="sm:mt-9 sm:col-span-1">
                    <a href="{{ route('products.create') }}"
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
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Marca</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Código</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Estoque da Loja</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Estoque</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Valor</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600"></th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($products as $product)
                        <tr class="border-b">
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $product['display_type'] }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $product['name'] }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $product['brand']['name'] ?? '' }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $product['code'] }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">
                                {{ $product['product_transactions_sum_quantity_store'] ?? 0 }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">
                                    {{ $product['product_transactions_sum_quantity_others'] ?? '' }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">R$ {{ $product['amount'] }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700 flex justify-start items-center space-x-2">
                                <a href="{{ route('products.update', $product['id']) }}"
                                    class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs hover:bg-blue-200 hover:blue-blue-600 focus:outline-none cursor-pointer">
                                    Editar
                                </a>
                                <a href="{{ route('products.transactions', $product['id']) }}"
                                    class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs hover:bg-green-200 hover:green-green-600 focus:outline-none cursor-pointer">
                                    Movimentações
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="pagination mt-6">
        {{ $products->links() }}
    </div>

</div>
