@if ($productId)
    @section('title', "Todos as Movimentações - $productName")
    @section('page', "Todos as Movimentações - $productName")
@else
    @section('title', 'Todos as Movimentações')
    @section('page', 'Todos as Movimentações')
@endif


<div>
    <x-alert></x-alert>

    <div class="sm:col-span-6">
        <div class="overflow-x-auto">

            <div class="mb-10 grid grid-cols-1 sm:grid-cols-10 gap-x-6 gap-y-8">
                <div class="sm:col-span-3">
                    <x-input name="filter" wire:model.live="filter" placeholder="Filtre por Produto e Código"
                        autocomplete="off">Filtro</x-input>
                </div>

                <div class="sm:col-span-2">
                    <x-input type="date" name="date" wire:model.live="date">Data</x-input>
                </div>

                <div class="sm:col-span-2">
                    <x-select name="type" label="Tipo do Produto" wire:model.live="type">
                        <option value="" selected>Filtre por Tipo de Mov...</option>
                        <option value="added">Adicionado</option>
                        <option value="removed">Removido</option>
                        <option value="transferred">Transferido</option>
                        <option value="sold">Vendido</option>
                    </x-select>
                </div>

                <div class="sm:col-span-1">
                    <x-select name="sort" label="Ordem" wire:model.live="sort">
                        <option value="" selected>Ordem</option>
                        <option value="desc">Recentes</option>
                        <option value="asc">antigas</option>
                    </x-select>
                </div>

                <div class="sm:mt-9 sm:col-span-2">
                    <a href="{{ route('products.transactions.create') }}"
                        class="rounded-md bg-indigo-600 px-3 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Criar Movimentação
                    </a>
                </div>

            </div>

            <table class="min-w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Data</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Tipo</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Responsável</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Produto</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Marca do Produto</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Código do Produto</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Total da Movimentação</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600"></th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($productTransactions as $productTransaction)
                        <tr class="border-b">
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $productTransaction['display_created_at'] }}
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $productTransaction['display_type'] }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $productTransaction['user']['name'] ?? '' }}
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $productTransaction['product']['name'] }}
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-700">
                                {{ $productTransaction['product']['brand']['name'] ?? '' }}
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $productTransaction['product']['code'] }}
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $productTransaction['quantity'] }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700 flex justify-start items-center space-x-2">
                                <a href="{{ route('products.update', $productTransaction['product']['id']) }}"
                                    class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs hover:bg-blue-200 hover:blue-blue-600 focus:outline-none cursor-pointer">
                                    Ver Produto
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="pagination mt-6">
        {{ $productTransactions->links() }}
    </div>

</div>
