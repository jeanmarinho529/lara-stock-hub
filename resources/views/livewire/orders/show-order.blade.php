@section('title', 'Detalhes da Venda')
@section('page', 'Detalhes da Venda')

<div>
    <div class="space-y-12">
        <div class="border-b border-gray-900/10 pb-12">
            <h2 class="text-base/7 font-semibold text-gray-900">Dados do Cliente</h2>
            <p class="text-sm/6 text-gray-600">Dados do cliente para verificação.</p>

            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="sm:col-span-2">
                    <x-input name="clientForm.name" value="{{ $client['name'] }}" disabled>Nome</x-input>
                </div>

                <div class="sm:col-span-2">
                    <x-input name="clientForm.document" value="{{ $client['document'] }}" disabled>Documento</x-input>
                </div>

                <div class="sm:col-span-2">
                    <x-input name="clientForm.cell_number" value="{{ $client['cell_number'] }}"
                        disabled>Celular</x-input>
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-12">
        <div class="border-b border-gray-900/10 pb-12 pt-6">
            <h2 class="text-base/7 font-semibold text-gray-900">Dados da Venda</h2>
            <p class="text-sm/6 text-gray-600">Dados da venda.</p>

            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="sm:col-span-2">
                    <x-input name="order.display_create_at" value="{{ $order['display_created_at'] }}" disabled>Vendido
                        Em</x-input>
                </div>

                <div class="sm:col-span-2">
                    <x-input name="order.user.name" value="{{ $order['user']['name'] }}" disabled>Vendido Por</x-input>
                </div>

                <div class="sm:col-span-2">
                    <x-input name="order.display_payment_method" value="{{ $order['display_payment_method'] }}"
                        disabled>Forma de Pagamento</x-input>
                </div>

                <div class="sm:col-span-2">
                    <x-input name="order.installments" value="{{ $order['installments'] }}x" disabled>N°
                        Parcelas</x-input>
                </div>

                <div class="sm:col-span-2">
                    <x-input name="order.amount" value="R$ {{ $order['gross_amount'] }}" disabled>Valor Total</x-input>
                </div>

                <div class="sm:col-span-2">
                    <x-input name="order.amount_received" value="R$ {{ $order['final_amount'] }}" disabled>Valor
                        Final</x-input>
                </div>

                <div class="sm:col-span-6">
                    <label for="description" class="block text-sm/6 font-medium text-gray-900">
                        Descrição
                    </label>

                    <textarea disabled ="description" name="description" rows="3"
                        class="
                        block w-full rounded-md bg-white px-3 py-1.5 text-base 
                        text-gray-900 outline-1 -outline-offset-1 outline-gray-300 
                        placeholder:text-gray-400 focus:outline-2 
                        focus:-outline-offset-2 focus:outline-indigo-600 
                        sm:text-sm/6 disabled:bg-gray-200 disabled:cursor-not-allowed"
                        placeholder="Descreva sua venda aqui...">{{ $order['description'] }}</textarea>
                </div>

            </div>
        </div>
    </div>


    <div class="space-y-12">
        <div class="border-b border-gray-900/10 pb-12 pt-6">
            <h2 class="text-base/7 font-semibold text-gray-900">Produtos Vendidos</h2>
            <p class="text-sm/6 text-gray-600">Dados dos produtos vendios.</p>

            @foreach ($productTransactions as $key => $productTransaction)
                <div class="pt-6">
                    <h2 class="text-base/7 font-semibold text-gray-900">Produto #{{ $key + 1 }}</h2>

                    <div class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-6">
                        <div class="sm:col-span-2">
                            <x-input name="productTransactions.product.name"
                                value="{{ $productTransaction['product']['name'] }}" disabled>Nome</x-input>
                        </div>

                        <div class="sm:col-span-2">
                            <x-input name="productTransactions.product.brand.name"
                                value="{{ $productTransaction['product']['brand']['name'] }}" disabled>Marca</x-input>
                        </div>

                        <div class="sm:col-span-2">
                            <x-input name="productTransactions.product.code"
                                value="{{ $productTransaction['product']['code'] }}" disabled>Código</x-input>
                        </div>

                        <div class="sm:col-span-2">
                            <x-input name="productTransactions.amount" value="R$ {{ $productTransaction['amount'] }}"
                                disabled>Valor do Produto</x-input>
                        </div>

                        <div class="sm:col-span-2">
                            <x-input name="productTransactions.quantity"
                                value="{{ abs($productTransaction['quantity']) }}" disabled>Quantidade</x-input>
                        </div>

                        <div class="sm:col-span-2">
                            <x-input name="productTransactions.display_local"
                                value="{{ $productTransaction['display_local'] }}" disabled>Local de Saída</x-input>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

    <div class="space-y-12">
        <div class="border-b border-gray-900/10 pb-12 pt-6">
            <h2 class="text-base/7 font-semibold text-gray-900">Valores a Receber</h2>
            <p class="text-sm/6 text-gray-600">Dados dos valores a receber.</p>

            <div class="overflow-x-auto mt-10">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Acordo de Pagamento Em
                            </th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Pago Em</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Total</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Total Liquido Recebido
                            </th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Método de Pagamento</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Status</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach ($transactions as $transaction)
                            <tr class="border-b">
                                <td class="px-4 py-2 text-sm text-gray-700">
                                    {{ $transaction['display_payment_estimate_at'] }}
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-700">
                                    {{ $transaction['display_payment_completed_at'] }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">R$ {{ $transaction['gross_amount'] }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">R$ {{ $transaction['paid_amount'] }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">
                                    <span
                                        class="py-2 text-sm text-gray-800">{{ $transaction['display_payment_method'] }}</span>
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-700">
                                    <span
                                        class="py-2 text-sm text-gray-800">{{ $transaction['display_status'] }}</span>
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-700 flex justify-start items-center space-x-2">
                                    <a href="{{ route('orders.show', $order['id']) }}"
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
    </div>
</div>


</div>
