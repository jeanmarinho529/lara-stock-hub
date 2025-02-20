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
                        <x-input is_required name="document" wire:model="document"
                            x-mask:dynamic="documentMask">Documento</x-input>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="document_type" class="block text-sm/6 font-medium text-gray-900">Tipo do
                            Documento*</label>
                        <div class="mt-2 grid grid-cols-1">
                            <select required wire:model="document_type" id="document_type" name="document_type"
                                class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                <option value="" disabled selected>Selecione o Tipo do Documento</option>
                                <option value="cpf">CPF</option>
                                <option value="cnpj">CNPJ</option>
                            </select>
                            <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                                viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                                <path fill-rule="evenodd"
                                    d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>


                    <div class="sm:col-span-2">
                        <label for="type" class="block text-sm/6 font-medium text-gray-900">Tipo*</label>
                        <div class="mt-2 grid grid-cols-1">
                            <select required wire:model="type" id="type" name="type"
                                class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                <option value="" disabled selected>Selecione o Tipo</option>
                                <option value="client">Cliente</option>
                                <option value="supplier">Fornecedor</option>
                            </select>
                            <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                                viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                                <path fill-rule="evenodd"
                                    d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <x-input is_required name="cell_number" wire:model="cell_number"
                            x-mask:dynamic="numberMask">Celular</x-input>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="cell_number_is_whatsapp" class="block text-sm/6 font-medium text-gray-900">Celular é
                            Whatsapp*</label>
                        <div class="mt-2 grid grid-cols-1">
                            <select is_required wire:model="cell_number_is_whatsapp" id="cell_number_is_whatsapp"
                                name="cell_number_is_whatsapp"
                                class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                <option value="" disabled selected>Celular é Whatsapp</option>
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select>
                            <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                                viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                                <path fill-rule="evenodd"
                                    d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
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

