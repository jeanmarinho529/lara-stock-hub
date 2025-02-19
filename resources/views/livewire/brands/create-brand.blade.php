@section('title', 'Nova Marca')
@section('page', 'Criar Nova Marca')

<div>
    <form wire:submit.prevent="submit" autocomplete="off">

        <div class="space-y-12">

            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-base font-semibold text-gray-900">Nova Marca</h2>
                <p class="text-sm text-gray-600">Insira os dados da nova marca.</p>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                    
                    <div class="sm:col-span-2">
                        <x-input placeholder="Nome da marca" is_required name="name" wire:model="name">Nome da Marca</x-input>
                    </div>
        <div class="mt-8 flex items-center justify-end gap-x-6">
            <a href="{{ url()->previous() }}" class="text-sm font-semibold text-gray-900">Voltar</a>
            <button type="submit"
                class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Salvar
            </button>
        </div>

    </form>
</div>
