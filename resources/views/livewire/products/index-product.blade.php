@section('title', 'Todos os Produtos')
@section('page', 'Todos os Produtos')

<div>

@if (session()->has('message'))
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
                        <p class="text-sm">{{ session('message') }}</p>
                    </div>
                </div>
            </div>
        @endif




    <div class="sm:col-span-6">
        <div class="overflow-x-auto">

            <div class="mb-10 grid grid-cols-1 sm:grid-cols-9 gap-x-6 gap-y-8">
                <div class="sm:col-span-7">
                    <x-input name="filter" wire:model.live="filter"
                        placeholder="Filtre por Nome, Código, Tipo" autocomplete="off">Filtro</x-input>
                </div>


                <div class="sm:mt-9 sm:col-span-1">
                    <a href="{{ route('products.create')}}"
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
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Valor</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600"></th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($products as $products)
                        <tr class="border-b">
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $products['type'] }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $products['name'] }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $products->brand->name ?? 'Sem Marca' }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $products['code'] }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">R$ {{ $products['amount'] }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


</div>
