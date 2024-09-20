<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Jobs\ImportProductImages;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = Product::all();
        $categories = Category::all();

        $view = request()->routeIs('home') ? 'home.index' : 'products.list';

        return view($view, compact('products', 'categories'));

    }

    public function search(Request $request)
    {
        $searchTerm = $request->get('query');

        $products = Product::where('name', 'LIKE', "%{$searchTerm}%")->get();

        return response()->json($products);
    }

    public function searchByCategory($category)
    {
        $products = Product::whereHas('category', function ($query) use ($category) {
            $query->where('name', $category);
        })->get();

        return response()->json($products);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        return view('products.show', compact('product'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image_url' => 'required|file|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image_url')) {
            $imageName = time() . '.' . $request->image_url->extension();
            $request->image_url->move(public_path('images'), $imageName);
        }

        $category = Category::find($request->category_id);

        $product = Product::create([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'category_id' => $category->id,
            'category' => $category->name,
            'image_url' => 'images/' . $imageName,
        ]);

        ImportProductImages::dispatch($product);

        return redirect()->route('products.index')->with('success', 'Produto criado com sucesso e sua importação de imagens esta sendo processada!');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product->update([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'category_id' => $request->input('category_id'),
        ]);

        return redirect()->route('products.list')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.list')->with('success', 'Produto excluído com sucesso!');
    }
}
