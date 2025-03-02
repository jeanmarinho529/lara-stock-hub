@section('title', 'Todas as Vendas')
@section('page', 'Todas as Vendas')

<div>
    <div class="sm:col-span-6">
        <div class="overflow-x-auto">

            <div class="mb-10 grid grid-cols-1 sm:grid-cols-10 gap-x-6 gap-y-8">
                <div class="sm:col-span-3">
                    <x-input type="date" name="date" wire:model.live="date">Filtro Data</x-input>
                </div>

                <div class="sm:col-span-3">
                    <x-select name="payment_method" label="Tipo de Pagamento" wire:model.live="payment_method">
                        <option value="" selected>Filtre por Tipo de Pagamento</option>
                        <option value="credit_card">Cartão de Crédito</option>
                        <option value="pix">PIX</option>
                        <option value="cash">Dinheiro</option>
                        <option value="bank_transfer">Transferência Bancária</option>
                        <option value="bank_slip">Boleto</option>
                    </x-select>
                </div>

                <div class="sm:col-span-2">
                    <x-select name="sort" label="Ordem" wire:model.live="sort">
                        <option value="desc" selected>Ordem</option>
                        <option value="desc">Recentes</option>
                        <option value="asc">Antigas</option>
                    </x-select>
                </div>

                <div class="sm:mt-9 sm:col-span-2">
                    <a href="{{ route('orders.create', $clientDefaultId) }}"
                        class="rounded-md bg-indigo-600 px-3 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Venda Avulsa
                    </a>
                </div>
            </div>

            <table class="min-w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Vendido Em</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Vendido Por</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Vendido Para</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">V. Total</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">V. Final</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Método de Pagamento</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Qt. de Produtos</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600"></th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($orders as $order)
                    <tr class="border-b">
                        <td class="px-4 py-2 text-sm text-gray-700">
                            {{ $order['display_created_at'] }}
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $order['user']['name'] }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $order['client']['name'] }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">R$ {{ $order['gross_amount'] }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">R$ {{ $order['final_amount'] }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">
                            <span class="py-2 text-sm text-gray-800">{{ $order['installments'] }}x - {{ $order['display_payment_method'] }}</span>
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-700">
                            <span class="py-2 text-sm text-gray-800">{{ $order['quantity_products'] }}</span>
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-700 flex justify-start items-center space-x-2">
                            <a
                                href="{{ route('orders.show', $order['id']) }}"
                                class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs hover:bg-blue-200 hover:blue-blue-600 focus:outline-none cursor-pointer">
                                Detalhes
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="pagination mt-6">
        {{ $orders->links() }}
    </div>
</div>