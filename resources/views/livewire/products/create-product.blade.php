@section('title', 'Novo Produto')
@section('page', 'Novo Produto')

<div>
    <form wire:submit="save" autocomplete="off">

        <div class="space-y-12">

            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-base/7 font-semibold text-gray-900">Novo Produto</h2>
                <p class="text-sm/6 text-gray-600">Insira os dados do novo Produto.</p>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                    <div class="sm:col-span-2">
                        <x-input is_required name="name" wire:model="name">Nome</x-input>
                    </div>

                    <div class="sm:col-span-2">
                        <x-input is_required name="code" wire:model="code"
                            x-mask:dynamic="documentMask">Código</x-input>
                    </div>

                    <div class="sm:col-span-2">
                        <x-input is_required name="amount" wire:model="amount"
                            x-mask:dynamic="documentMask">Valor</x-input>
                    </div>

                    <div class="sm:col-span-2">
                        <x-input is_required name="minimun_quantity" wire:model="minimun_quantity"
                            x-mask:dynamic="documentMask">Quantidade</x-input>
                    </div>

                    <div class="sm:col-span-2">
                        <x-input is_required name="description" wire:model="description"
                            x-mask:dynamic="numberMask">Descrição</x-input>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="type" class="block text-sm/6 font-medium text-gray-900">Tipo*</label>
                        <div class="mt-2 grid grid-cols-1">
                            <select required wire:model="type" id="type" name="type"
                                class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                <option value="" disabled selected>Selecione o Tipo</option>
                                <option value="product">Produto</option>
                                <option value="service">Seriviço</option>
                            </select>
                            @error('type')
                                <span class="error text-red-600 sm:text-sm/6">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>



                    <div class="sm:col-span-2">
                        <label for="brand_id" class="block text-sm/6 font-medium text-gray-900">Marca*</label>
                        <div class="mt-2 grid grid-cols-1">
                            <select wire:model="brand_id" id="brand_id" name="brand_id"
                                class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                <option value="" disabled selected>Selecione a Marca</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand['id'] }}">{{ $brand['name'] }}</option>
                                @endforeach
                            </select>
                            @error('brand_id')
                                <span class="error text-red-600 sm:text-sm/6">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <div class="mt-2 grid grid-cols-1">
                            </div>
                        </div>
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
