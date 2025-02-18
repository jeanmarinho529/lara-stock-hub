@section('title', 'Todas as Vendas')
@section('page', 'Todas as Vendas')

<div>
    <div class="sm:col-span-6">
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Vendido Em</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Vendido Por</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Vendido Para</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Total</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Método de Pagamento</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">N° de Parcelas</th>
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
                        <td class="px-4 py-2 text-sm text-gray-700">R$ {{ $order['amount_received'] }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">
                            <span class="py-2 text-sm text-gray-800">{{ $order['display_payment_method'] }}</span>
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-700">
                            <span class="py-2 text-sm text-gray-800">{{ $order['installments'] }}x</span>
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