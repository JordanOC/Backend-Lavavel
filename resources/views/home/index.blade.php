@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('partials.sidebar')

        <div class="col-md-10">
            <div class="d-flex flex-column justify-content-center align-items-center mb-2">
                <div class="input-group w-50 mt-4">
                    <input type="text" class="form-control" placeholder="Procurar por nome da coleção..." id="searchQuery">
                    <button class="btn btn-outline-secondary" id="searchButton">Pesquisar</button>
                    <button class="btn btn-outline-secondary" id="clearButton">Limpar Pesquisa</button>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-2">
                @if($categories->count() > 0)
                    @foreach($categories->take(5) as $category)
                        <a href="#" class="text-decoration-none me-2 text-primary category-link" style="font-size: 0.9rem;" data-category="{{ $category->name }}">{{ $category->name }}</a>
                    @endforeach
                @else
                    <p>Nenhuma categoria disponível</p>
                @endif
            </div>

            <div class="row mt-3" id="product-list">
                @if($products->count() > 0)
                    @foreach($products as $product)
                        <div class="col-md-3 mb-4">
                            <div class="card h-100">
                                <img src="{{ asset($product->image_url) }}" class="card-img-top img-fluid" alt="{{ $product->name }}" style="max-height: 450px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">R${{ $product->price }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
            <div class="d-flex flex-column justify-content-center align-items-center mb-6" style="height: 600px;">
                        <h3 class="text-center">Você ainda não tem produtos, cadastre ou importe seu primeiro produto</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>

document.querySelectorAll('.category-link').forEach(function(link) {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        let category = this.getAttribute('data-category');

        fetch(`/products/category/${category}`)
        .then(response => response.json())
        .then(data => {
            let productList = document.getElementById('product-list');
            productList.innerHTML = '';

            if (data.length > 0) {
                data.forEach(product => {

                    productList.innerHTML += `
                        <div class="col-md-3 mb-4">
                            <div class="card h-100">
                                <img src="${product.image_url}" class="card-img-top img-fluid" alt="${product.name}" style="max-height: 450px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title">${product.name}</h5>
                                    <p class="card-text">R$${product.price}</p>
                                </div>
                            </div>
                        </div>
                    `;
                });
            } else {
                productList.innerHTML = '<p>Nenhum produto encontrado.</p>';
            }
        });
    });
});

document.getElementById('searchQuery').addEventListener('keyup', function() {
    let query = this.value;

    fetch(`/products/search?query=${query}`)
    .then(response => response.json())
    .then(data => {
        let productList = document.getElementById('product-list');
        productList.innerHTML = '';

        if (data.length > 0) {
            data.forEach(product => {

                productList.innerHTML += `
                    <div class="col-md-3 mb-4">
                        <div class="card h-100">
                            <img src="${product.image_url}" class="card-img-top img-fluid" alt="${product.name}" style="max-height: 450px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">${product.name}</h5>
                                <p class="card-text">R$${product.price}</p>
                            </div>
                        </div>
                    </div>
                `;
            });
        } else {
            productList.innerHTML = '<p>Nenhum produto encontrado.</p>';
        }
    });
});


    document.getElementById('clearButton').addEventListener('click', function() {
        document.getElementById('searchQuery').value = '';
        fetch('/products')
    });
</script>
@endsection
