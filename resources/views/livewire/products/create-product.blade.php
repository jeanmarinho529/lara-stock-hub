@section('title', 'Novo Produto')
@section('page', 'Novo Produto')

<div>
    <x-alert></x-alert>

    <form wire:submit="save" autocomplete="off">
        <div class="space-y-12">

            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-base/7 font-semibold text-gray-900">Novo Produto</h2>
                <p class="text-sm/6 text-gray-600">Insira os dados do novo produto.</p>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                    <div class="sm:col-span-2">
                        <x-input is_required name="name" wire:model="name">Nome</x-input>
                    </div>

                    <div class="sm:col-span-2">
                        <x-input is_required name="code" wire:model="code">Código</x-input>
                    </div>

                    <div class="sm:col-span-2">
                        <x-input is_required type="number" min="0" name="amount" step="0.01"
                            wire:model="amount">Valor</x-input>
                    </div>

                    <div class="sm:col-span-2">
                        <x-select name="type" wire:model="type" is_required label="Tipo">
                            <option value="" disabled selected>Selecione o Tipo</option>
                            <option value="product">Produto</option>
                            <option value="service">Seriviço</option>
                        </x-select>
                    </div>

                    <div class="sm:col-span-2">
                        <x-input is_required type="number" min="0" name="minimum_quantity"
                            wire:model="minimum_quantity">Quantidade Mínima de Produtos</x-input>
                    </div>

                    <div class="sm:col-span-2">
                        <x-select name="unit_measurement" wire:model="unit_measurement" is_required label="Unidade de Medida">
                            <option value="" disabled selected>Selecione a Unidade de Medida</option>
                            <option value="unit">UN - Unidade</option>
                            <option value="meter">M - Metro</option>
                            <option value="centimeter">CM - Centímetro</option>
                            <option value="kilogram">KG - Kilograma</option>
                            <option value="gram">G - Grama</option>
                            <option value="liter">L - Litro</option>
                            <option value="milliliter">ML - Mililitro</option>
                        </x-select>
                    </div>

                    <div class="sm:col-span-6">
                        <x-select name="brand_id" wire:model="brand_id" is_required label="Marca do Produto">
                            <option value="null" disabled selected>Selecione a Marca</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand['id'] }}">{{ $brand['name'] }}</option>
                            @endforeach
                        </x-select>
                    </div>

                    <div class="sm:col-span-6">
                        <label for="description" class="block text-sm/6 font-medium text-gray-900">
                            Descrição
                        </label>

                        <textarea id="description" name="description" wire:model="description" rows="3"
                            class="
                            block w-full rounded-md bg-white px-3 py-1.5 text-base 
                            text-gray-900 outline-1 -outline-offset-1 outline-gray-300 
                            placeholder:text-gray-400 focus:outline-2 
                            focus:-outline-offset-2 focus:outline-indigo-600 
                            sm:text-sm/6"
                            placeholder="Descreva seu produto aqui..."></textarea>
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

</div>
