<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ImportProductImages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function handle()
    {
        $imageUrl = $this->product->image_url;

        $imageContents = file_get_contents($imageUrl);

        Storage::put('products/' . $this->product->id . '.jpg', $imageContents);

        $this->product->update([
            'local_image_path' => 'products/' . $this->product->id . '.jpg',
        ]);
    }
}
