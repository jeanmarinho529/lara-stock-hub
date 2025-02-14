<div>
    <!-- Campo de entrada para o nome do produto -->
    <input type="text" wire:model.live="searchProduct" placeholder="Digite o nome do produto">

    <!-- Exibe os produtos encontrados após a busca -->
    @if (strlen($searchProduct) >= 3 && count($products) > 0)
    <select>
        @foreach ($products as $product)
        <option>{{ $product }}</option>
        @endforeach
    </select>
    
    @elseif(strlen($searchProduct) >= 3 && count($products) == 0)
    <p>Nenhum produto encontrado.</p>
    @endif
</div>