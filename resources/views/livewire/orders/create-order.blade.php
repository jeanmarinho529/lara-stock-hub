@section('title', 'Vendas')
@section('page', 'Vendas')

<div>

    <div class="space-y-12">

        <div class="border-b border-gray-900/10 pb-12">
            <h2 class="text-base/7 font-semibold text-gray-900">Dados do Cliente</h2>
            <p class="text-sm/6 text-gray-600">Dados do cliente para verificação.</p>

            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="sm:col-span-2">
                    <x-input name="client_name" wire:model="client_name" disabled>Nome</x-input>
                </div>

                <div class="sm:col-span-2">
                    <x-input name="client_document" wire:model="client_document" disabled>Documento</x-input>
                </div>

                <div class="sm:col-span-2">
                    <x-input name="client_cell_number" wire:model="client_cell_number"
                        disabled>Celular</x-input>
                </div>
            </div>

        </div>
    </div>

    <form wire:submit="save">

        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-6 py-6">
                <h2 class="text-base/7 font-semibold text-gray-900">Venda</h2>
                <p class="text-sm/6 text-gray-600">Selecione os produtos para realizar a venda.</p>

                <div class="mt-10 sm:col-span-6 pb-6">
                    <div x-data="{ isOpen: false, searchTerm: '' }">
                        <div class="relative">
                            <a @click="isOpen = !isOpen"
                                class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
                                <span class="mr-2">Procurar Produtos</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2 -mr-1" viewBox="0 0 20 20"
                                    fill="currentColor" aria-hidden="true">
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
                                <!-- Search input -->
                                <input wire:model.live="searchTerm" x-model="searchTerm"
                                    @input="if (searchTerm.length >= 3) { $wire.set('searchTerm', searchTerm) }"
                                    class="block w-full px-4 py-2 text-gray-800 border rounded-md border-gray-300 focus:outline-none"
                                    type="text" placeholder="Procure o Produto" autocomplete="off"
                                    @keydown.enter.prevent="return false" x-ref="searchInput">

                                <!-- Dropdown items -->
                                <template x-for="(item, index) in @js($products)" :key="index">
                                    <a href="#"
                                        class="block px-4 py-2 text-gray-700 hover:bg-gray-100 active:bg-blue-100 cursor-pointer rounded-md"
                                        @click="$wire.addProduct(item); searchTerm = ''; $refs.searchInput.focus();">
                                        <span x-text="item.brand.name"></span>
                                        <span x-text="'- ' + item.name"></span>
                                        <span class="ml-2 text-gray-500" x-text="'- R$ ' + item.amount"></span>
                                    </a>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="sm:col-span-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Código</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Nome</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Valor</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Quantidade</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Total</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @foreach ($selectedProducts as $item)
                                <tr class="border-b" wire:key="product-{{ $item['code'] }}">
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ $item['code'] }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-700">{{ $item['brand']['name'] ?? '' }} -
                                            {{ $item['name'] }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-700">R$ {{ $item['amount'] }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-700">
                                            <input type="number"
                                                class="w-20 px-2 py-1 text-sm text-gray-700 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500"
                                                wire:model="selectedProducts.{{ $item['code'] }}.quantity"
                                                min="1" step="1"
                                                @change="$wire.calculateTotalProduct('{{ $item['code'] }}')" />
                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-700">
                                            <span class="py-2 text-sm text-gray-800">R$
                                                {{ $item['total'] }}</span>
                                        </td>
                                        <td
                                            class="px-4 py-2 text-sm text-gray-700 flex justify-start items-center space-x-2">
                                            <span @click="$wire.removeProduct('{{ $item['code'] }}')"
                                                class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs hover:bg-red-200 hover:text-red-600 focus:outline-none cursor-pointer">
                                                Remover
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="px-4 py-2 text-sm text-gray-700">
                                    <h2 class="text-base/7 font-semibold text-gray-900">R$ {{ $total }}</h2>
                                </td>
                                <td></td>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12 py-6">
                <h2 class="text-base/7 font-semibold text-gray-900">Dados para Pagamento</h2>
                <p class="text-sm/6 text-gray-600">Nos informe os dados de pagamento.</p>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-2">
                        <label for="payment_method" class="block text-sm/6 font-medium text-gray-900">Método de
                            Pagamento</label>
                        <div class="mt-2 grid grid-cols-1">
                            <select required wire:model="payment_method" id="payment_method" name="payment_method"
                                class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                <option value="" disabled selected>Escolha o Método de Pagamento</option>
                                <option value="cash">Dinheiro</option>
                                <option value="pix">Pix</option>
                                <option value="credit_card">Cartão de Crédito</option>
                                <option value="bank_slip">Boleto</option>
                                <option value="bank_transfer">Transferência Bancária</option>
                            </select>
                            <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                                viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                                <path fill-rule="evenodd"
                                    d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>

                    <div class="sm:col-span-1">
                        <label for="installments" class="block text-sm/6 font-medium text-gray-900">N° de
                            Parcelas</label>
                        <div class="mt-2 grid grid-cols-1">
                            <select wire:model="installments" id="installments" name="installments"
                                class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                <option value="1" selected>1x</option>
                                @foreach (range(2, 12) as $number)
                                    <option value="{{ $number }}">{{ $number }}x</option>
                                @endforeach
                            </select>
                            <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                                viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                                <path fill-rule="evenodd"
                                    d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>

                    <div class="sm:col-span-1">
                        <x-input name="discount" wire:model="discount" type="number" min="0" step="0.01"
                            @change="$wire.calculateAmountReceived()">Desconto</x-input>
                    </div>

                    <div class="sm:col-span-1">
                        <label for="discount_type" class="block text-sm/6 font-medium text-gray-900">Tipo do
                            Desconto</label>
                        <div class="mt-2 grid grid-cols-1">
                            <select wire:model="discount_type" @change="$wire.calculateAmountReceived()"
                                id="discount_type" name="discount_type"
                                class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                <option value="percentage" selected>Porcentagem</option>
                                <option value="absolute_value">Valor Absoluto</option>
                            </select>
                            <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                                viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                                <path fill-rule="evenodd"
                                    d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>

                    <div class="sm:col-span-1">
                        <x-input name="amount_received" wire:model.live="amount_received" type="number"
                            min="0" step="0.01">Valor Total da Venda</x-input>
                    </div>

                </div>
            </div>
        </div>

        @if (session()->has('waring'))
            <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4" role="alert">
                <p class="font-bold">Alerta</p>
                <p>{{ session('waring') }}</p>
            </div>
        @endif

        @if (session()->has('success'))
            <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md"
                role="alert">
                <div class="flex">
                    <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path
                                d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                        </svg></div>
                    <div>
                        <p class="font-bold">Sucesso</p>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div role="alert">
                <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                    Erro
                </div>
                <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                    <p>{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="button" class="text-sm/6 font-semibold text-gray-900">Cancelar</button>
            <button type="submit"
                class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Vender
            </button>
        </div>
    </form>
</div>
