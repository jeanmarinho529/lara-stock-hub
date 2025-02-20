@section('title', 'Criar Movimentações')
@section('page', 'Criar Movimentações')


<div>
    <x-alert></x-alert>

    <form wire:submit="save" autocomplete="off">
        <div class="space-y-12">

            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-base/7 font-semibold text-gray-900">Novo Produto</h2>
                <p class="text-sm/6 text-gray-600">Insira os dados do novo produto.</p>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-6">
                        <div x-data="{ isOpen: false, searchTerm: '' }">
                            <div class="relative">
                                <a @click="isOpen = !isOpen"
                                    class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
                                    <span class="mr-2">Procurar Produtos</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2 -mr-1"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M6.293 9.293a1 1 0 011.414 0L10 11.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>

                                <div x-show="isOpen" @click.away="isOpen = false"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 transform scale-95"
                                    x-transition:enter-end="opacity-100 transform scale-100"
                                    class="right-0 mt-2 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 p-1 space-y-1">

                                    <!-- Campo de busca -->
                                    <input wire:model.live="searchTerm" x-model="searchTerm"
                                        @input="if (searchTerm.length >= 3) { $wire.set('searchTerm', searchTerm) }"
                                        class="block w-full px-4 py-2 text-gray-800 border rounded-md border-gray-300 focus:outline-none"
                                        type="text" placeholder="Procure o Produto" autocomplete="off"
                                        @keydown.enter.prevent="return false" x-ref="searchInput">

                                    <!-- Itens do dropdown -->
                                    <template x-for="(item, index) in @js($products)"
                                        :key="index">
                                        <a href="#"
                                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100 active:bg-blue-100 cursor-pointer rounded-md"
                                            @click="$wire.addProduct(item); searchTerm = ''; isOpen = false;">
                                            <span x-text="item.brand.name"></span>
                                            <span x-text="'- ' + item.name"></span>
                                            <span class="ml-2 text-gray-500" x-text="'- R$ ' + item.amount"></span>
                                        </a>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="sm:col-span-4">
                        <x-input disabled is_required name="product" wire:model="product">Produto</x-input>
                    </div>

                    <div class="sm:col-span-2">
                        <x-input is_required type="number" min="0" step="0.01" name="quantity"
                            wire:model="quantity">Quantidade</x-input>
                    </div>

                    <div class="sm:col-span-2">
                        <x-select name="type" wire:model="type" is_required label="Tipo">
                            <option value="" disabled selected>Selecione o Tipo</option>
                            <option value="added">Adicionando</option>
                            <option value="removed">Removendo</option>
                            <option value="transferred">Transferência</option>
                        </x-select>
                    </div>

                    <div class="sm:col-span-2">
                        <x-select name="local" wire:model="local" is_required label="Local da Movimentação">
                            <option value="" disabled selected>Selecione o Local da Movimentação</option>
                            <option value="store">Loja</option>
                            <option value="stock">Estoque</option>
                            <option value="others">Outros Locais</option>
                        </x-select>
                    </div>

                    <div class="sm:col-span-2">
                        <x-select name="local_transfer" wire:model="local_transfer" label="Local da Transferência">
                            <option value="" selected>Selecione o Local da Transferência</option>
                            <option value="store">Loja</option>
                            <option value="stock">Estoque</option>
                            <option value="others">Outros Locais</option>
                        </x-select>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <a href="{{ url()->previous() }}" class="text-sm/6 font-semibold text-gray-900">Voltar</a>
                <button type="submit"
                    class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Salvar
                </button>
            </div>
    </form>

    <div class="border-t border-gray-900/10 pt-12">
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
