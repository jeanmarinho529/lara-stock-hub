<?php

namespace App\Imports;

use App\Models\Product; 
use Maatwebsite\Excel\Concerns\ToModel;




class ProdutosImport implements ToModel
{
    public function model(array $row)
{
    #dd($row);
    return new Product([
        'name' => $row[0],            
        'amount' => (float)$row[1],  
        'description' => $row[2],    
        'user_id' => (int)$row[3],     
        'store_id' => (int)$row[4],        
        'minimum_quantity' => (int)$row[5], 
    ]);

}

}

