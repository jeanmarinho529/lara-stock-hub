<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\ProductTransaction;
use Livewire\Component;

class Sale extends Component
{
    // tem que adicionar quantidade

    public string $searchProduct = "";
    public array $productItems = [];
    public $products = [];

    public function render()
    {
        return view('livewire.sale')->layout('layouts.app');
    }

    public function addProduct()
    {
        $product = Product::select('id', 'name', 'code', 'amount')
            ->where('code', $this->searchProduct)
            ->orWhere('name', $this->searchProduct)
            ->first();

        $this->productItems[] = $product;
    }

    public function sales()
    {
        ProductTransaction::first();
    }

    // Método que é chamado toda vez que a variável searchProduct é atualizada
    public function updatedSearchProduct()
    {
        // Realiza a busca apenas se o texto tiver pelo menos 3 caracteres
        if (strlen($this->searchProduct) >= 3) {
            // Exemplo de busca fictícia: substitua isso pela lógica real de busca
            $this->products = $this->buscarProdutos($this->searchProduct);
        } else {
            $this->products = [];  // Limpar resultados se tiver menos de 3 caracteres
        }
    }

    // Exemplo de função que simula a busca de produtos
    private function buscarProdutos($term)
    {
        // Aqui, você faria a busca real no banco de dados, mas estamos simulando a busca.
        $todosProdutos = [
            'Produto 1',
            'Produto 2',
            'Produto 3',
            'Produto 4',
            'Produto 5'
        ];

        // Filtra os produtos que contêm o termo buscado
        return array_filter($todosProdutos, function ($produto) use ($term) {
            return stripos($produto, $term) !== false;
        });
    }
}
