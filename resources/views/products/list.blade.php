@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Lista de Produtos</h2>

    @include('partials.tabs')

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Preço</th>
                <th>Categoria</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>R${{ $product->price }}</td>
                <td>{{ $product->category_name }}</td>
                <td>
                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editProductModal"
                            onclick="fillEditForm({{ $product->id }}, '{{ $product->name }}', '{{ $product->price }}', '{{ $product->category_id }}', '{{ $product->description }}')">
                        Editar
                    </button>

                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este produto?')">Excluir</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Editar Produto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProductForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="hidden" id="editProductId" name="product_id">

                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Nome do Produto</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_price" class="form-label">Preço</label>
                        <input type="number" class="form-control" id="edit_price" name="price" step="0.01" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_category_id" class="form-label">Categoria</label>
                        <select id="edit_category_id" name="category_id" class="form-select" required>
                            <option value="" disabled>Selecione uma Categoria</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Descrição</label>
                        <textarea class="form-control" id="edit_description" name="description" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
function fillEditForm(id, name, price, category_id, description) {
    document.getElementById('editProductId').value = id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_price').value = price;
    document.getElementById('edit_category_id').value = category_id;
    document.getElementById('edit_description').value = description;

    document.getElementById('editProductForm').action = '/products/' + id;
}
</script>

@endsection
