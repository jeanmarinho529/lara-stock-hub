@section('title', 'Todos os Clientes')
@section('page', 'Todos os Clientes')

<div>

    <div class="sm:col-span-6">
        <div class="overflow-x-auto">

            <div class="mb-10 grid grid-cols-1 sm:grid-cols-9 gap-x-6 gap-y-8">
                <div class="sm:col-span-7">
                    <x-input name="filter" wire:model.live="filter"
                        placeholder="Filtre por Nome, Documento, Email, Celular" autocomplete="off">Filtro</x-input>
                </div>

                <div class="sm:mt-9 sm:col-span-1">
                    <a href="{{ route('clients.create') }}"
                        class="rounded-md bg-indigo-600 px-3 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Novo Cliente
                    </a>
                </div>

                <div class="sm:mt-9 sm:col-span-1">
                    <a href="{{ route('orders.create', 1) }}"
                        class="rounded-md bg-indigo-600 px-3 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Venda Avulsa
                    </a>
                </div>
            </div>

            <table class="min-w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Tipo</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Nome</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Documento</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Celular</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">WhatsApp</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600"></th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($clients as $client)
                        <tr class="border-b">
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $client['display_type'] }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $client['name'] }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $client['document'] }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">
                                <span class="py-2 text-sm text-gray-800">{{ $client['cell_number'] }}</span>
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-700">
                                <span
                                    class="py-2 text-sm text-gray-800">{{ $client['cell_number_is_whatsapp'] ? 'Sim' : 'Não' }}</span>
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-700 flex justify-start items-center space-x-2">
                                <a href="{{ route('clients.update', $client['id']) }}"
                                    class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs hover:bg-blue-200 hover:blue-blue-600 focus:outline-none cursor-pointer">
                                    Editar
                                </a>
                                <a href="{{ route('orders.create', $client['id']) }}"
                                    class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs hover:bg-red-200 hover:blue-red-600 focus:outline-none cursor-pointer">
                                    Vender
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="pagination mt-6">
        {{ $clients->links() }}
    </div>
</div>
