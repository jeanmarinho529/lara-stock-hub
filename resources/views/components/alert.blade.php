<div class="my-2">
    @if (session()->has('success'))
        <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert">
            <div class="flex">
                <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <path
                            d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                    </svg></div>
                <div>
                    <p class="font-bold">Sucesso</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if (session()->has('waring'))
        <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4" role="alert">
            <p class="font-bold">Alerta</p>
            <p>{{ session('waring') }}</p>
        </div>
    @endif

    @if (session()->has('error'))
        <div role="alert">
            <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                Erro
            </div>
            <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                <p>{{ session('error') }}</p>
            </div>
        </div>
    @endif
</div>
