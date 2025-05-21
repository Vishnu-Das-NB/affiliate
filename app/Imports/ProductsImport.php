<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Product([
            'name' => $row['name'],
            'description' => $row['description'],
            'image' => $row['image'],
            'affiliate_link' => $row['affiliate_link'],
            'is_dod' => filter_var($row['is_dod'], FILTER_VALIDATE_BOOLEAN),
        ]);
    }
}
