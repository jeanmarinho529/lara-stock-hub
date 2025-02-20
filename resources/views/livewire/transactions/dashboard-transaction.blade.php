@section('title', 'Financeiro Dashboard')
@section('page', 'Financeiro Dashboard')

<div>

    <div class="border-b border-gray-900/10 pb-12">

        <div class="flex items-center justify-between flex-wrap">
            <div>
                <h2 class="text-base/7 font-semibold text-gray-900">KPIs Financeiro</h2>
                <p class="text-sm/6 text-gray-600">Dados do financeiro do dia {{ $date }}.</p>
            </div>
            <div>
                <x-input type="date" name="date" wire:model.live="date"></x-input>
            </div>
        </div>

        <div class="pt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">
                <div class="flex justify-between mb-6">
                    <div>
                        <div class="flex items-center mb-1">
                            <div class="text-2xl font-semibold">R$ {{ $totalAmountDay }}</div>
                        </div>
                        <div class="text-sm font-medium text-gray-400">Total de Vendas</div>
                    </div>
                </div>

                <a href="/gebruikers" class="text-[#f84525] font-medium text-sm hover:text-red-800">Detalhes</a>
            </div>
            <div class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">
                <div class="flex justify-between mb-6">
                    <div>
                        <div class="text-2xl font-semibold mb-1">R$ {{ $salesCashInflow }}</div>
                        <div class="text-sm font-medium text-gray-400">Entrada no Caixa</div>
                    </div>
                </div>
                <a href="" class="text-[#f84525] font-medium text-sm hover:text-red-800">Detalhes</a>
            </div>
            <div class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">
                <div class="flex justify-between mb-4">
                    <div>
                        <div class="flex items-center mb-1">
                            <div class="text-2xl font-semibold">R$ {{ $averageTicket }}</div>
                        </div>
                        <div class="text-sm font-medium text-gray-400">Ticket Médio</div>
                    </div>
                </div>
                <a href="/dierenartsen" class="text-[#f84525] font-medium text-sm hover:text-red-800">Detalhes</a>
            </div>
        </div>

        <h2 class="text-base/7 font-semibold text-gray-900">Detalhe de Vendas Por Método de Pagamento</h2>
        <p class="text-sm/6 text-gray-600">Detalhamento dos valores vendidos por método de pagamento.</p>


        <div class="pt-6 sm:col-span-6">
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Método de Pagamento</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Total</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Data</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach ($paymentMethodDetails as $paymentMethodDetail)
                            <tr class="border-b">
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $paymentMethodDetail['payment_method'] }}
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-700">R$ {{ $paymentMethodDetail['total'] }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $date }}</td>

                                <td class="px-4 py-2 text-sm text-gray-700 flex justify-start items-center space-x-2">
                                    <a href="{{ route('orders.show', $paymentMethodDetail['payment_method']) }}"
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

    <div class="border-b border-gray-900/10 py-12">

        <div class="flex items-center justify-between flex-wrap">
            <div>
                <h2 class="text-base/7 font-semibold text-gray-900">Valores a Receber</h2>
                <p class="text-sm/6 text-gray-600">Valores a receber do ano de {{ $year }}.</p>
            </div>
            <div>
                <x-input type="number" name="year" min="2025" step="1" wire:model.live="year"></x-input>
            </div>
        </div>

        <div class="pt-6 sm:col-span-6">
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Mês</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Total</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Total Recebido</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Total a Receber</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach ($detailReceivables as $detailReceivable)
                            <tr class="border-b">
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $detailReceivable['month'] }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">R$ {{ $detailReceivable['amount'] }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">R$ {{ $detailReceivable['amount_paid'] }}
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-700">R$
                                    {{ $detailReceivable['amount_receive'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


    </div>
</div>
