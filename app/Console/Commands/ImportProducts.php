<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Product;

class ImportProducts extends Command
{
    protected $signature = 'import:products';
    protected $description = 'Import products from an external API';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Importing products...');

        $response = Http::get(env('API_EXTERNAL_URL'));
        $products = $response->json();

        foreach ($products as $productData) {
            Product::updateOrCreate(
                ['name' => $productData['title']],
                [
                    'name' => $productData['title'],
                    'price' => $productData['price'],
                    'description' => $productData['description'],
                    'category' => $productData['category'],
                    'image_url' => $productData['image'],
                    'category_id' => $productData['category_id'] ?? 0,
                ]
            );
        }

        $this->info('Products imported successfully!');
    }
}
