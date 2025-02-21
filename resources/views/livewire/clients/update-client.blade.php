@section('title', 'Editar Cliente')
@section('page', 'Editar Cliente')

<div>
    <form wire:submit="save" autocomplete="off">

        <div class="space-y-12">

            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-base/7 font-semibold text-gray-900">Novo do Cliente</h2>
                <p class="text-sm/6 text-gray-600">Insira os Dados do Novo Cliente.</p>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                    <div class="sm:col-span-2">
                        <x-input is_required name="name" wire:model="name">Nome</x-input>
                    </div>

                    <div class="sm:col-span-2">
                        <x-input is_required name="cell_number" wire:model="cell_number"
                            x-mask:dynamic="numberMask">Celular</x-input>
                    </div>

                    <div class="sm:col-span-2">
                        <x-select is_required wire:model="cell_number_is_whatsapp" name="cell_number_is_whatsapp"
                            label="Celular é Whatsapp">
                            <option value="" disabled selected>Celular é Whatsapp</option>
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </x-select>
                    </div>

                    <div class="sm:col-span-2">
                        <x-select is_required wire:model="type" name="type" label="Tipo">
                            <option value="" disabled selected>Selecione o Tipo</option>
                            <option value="client">Cliente</option>
                            <option value="supplier">Fornecedor</option>
                        </x-select>
                    </div>

                    <div class="sm:col-span-2">
                        <x-input name="document" wire:model="document" x-mask:dynamic="documentMask">Documento</x-input>
                    </div>

                    <div class="sm:col-span-2">
                        <x-select wire:model="document_type" name="document_type" label="Tipo do Documento">
                            <option value="" disabled selected>Selecione o Tipo do Documento</option>
                            <option value="cpf">CPF</option>
                            <option value="cnpj">CNPJ</option>
                        </x-select>
                    </div>

                    <div class="sm:col-span-2">
                        <x-input name="phone_number" wire:model="phone_number"
                            x-mask:dynamic="numberMask">Telefone</x-input>
                    </div>

                    <div class="sm:col-span-2">
                        <x-input name="email" wire:model="email" type="email">E-mail</x-input>
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



    <script>
        function documentMask(input) {
            return input.length <= 14 ?
                '999.999.999-99' :
                '99.999.999/9999-99'
        }

        function numberMask(input) {
            console.log(input.length)
            return input.length <= 14 ?
                '(99) 9999-9999' :
                '(99) 99999-9999'
        }
    </script>

</div>
