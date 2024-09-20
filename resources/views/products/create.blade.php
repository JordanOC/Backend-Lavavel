@extends('layouts.app')

@section('content')
<div class="container mt-4">
<div class="row">
    <h2>Adicionar itens</h2>
    @include('partials.tabs')

    <div class="mt-4">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
            <div class="mb-3">
                <label for="category_id" class="form-label">Selecionar Categoria</label>
                <div class="input-group">
                    <select id="category_id" name="category_id" class="form-select" required>
                        <option value="" disabled selected>Selecione uma Categoria</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                        ➕
                    </button>
                    <button type="button" class="btn btn-outline-info ms-2" data-bs-toggle="modal" data-bs-target="#manageCategoriesModal">
                        🔁
                    </button>
            </div>



        </div>

            <div class="mb-3">
                <label for="name" class="form-label">Nome do Produto</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Preço</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Descrição</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>

            <div class="mb-3">
                <label for="image_url" class="form-label">URL da Imagem</label>
                <input type="file" class="form-control" id="image_url" name="image_url" required>
            </div>

            <button type="submit" class="btn btn-primary">Criar Produto</button>
        </form>
    </div>
    </div>

    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Adicionar Categoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="categoryForm">
                        @csrf
                        <div class="mb-3">
                            <label for="new_category_name" class="form-label">Nome da Categoria</label>
                            <input type="text" class="form-control" id="new_category_name" name="new_category_name" required>
                        </div>
                        <button type="button" class="btn btn-primary" id="saveCategory">Criar Categoria</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="manageCategoriesModal" tabindex="-1" aria-labelledby="manageCategoriesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="manageCategoriesModalLabel">Gerenciar Categorias</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mt-2">
                        @foreach($categories as $category)
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>{{ $category->name }}</span>
                                    <div>
                                        <button type="button" class="btn btn-outline-secondary btn-sm me-1" onclick="openEditCategoryModal({{ $category->id }}, '{{ $category->name }}')">
                                            Editar
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="openDeleteCategoryModal({{ $category->id }})">
                                            Excluir
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Editar Categoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCategoryForm">
                        @csrf
                        <input type="hidden" id="edit_category_id" name="edit_category_id">
                        <div class="mb-3">
                            <label for="edit_category_name" class="form-label">Nome da Categoria</label>
                            <input type="text" class="form-control" id="edit_category_name" name="edit_category_name" required>
                        </div>
                        <button type="button" class="btn btn-primary" id="updateCategory">Atualizar Categoria</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCategoryModalLabel">Excluir Categoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja excluir esta categoria?</p>
                    <input type="hidden" id="delete_category_id">
                    <button type="button" class="btn btn-danger" id="confirmDeleteCategory">Excluir</button>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<script>
document.getElementById('saveCategory').addEventListener('click', function() {
    let categoryName = document.getElementById('new_category_name').value;
    let token = document.querySelector('input[name=_token]').value;

    fetch('{{ route('categories.store') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({
            name: categoryName
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Fechar o modal
            let addCategoryModal = document.getElementById('addCategoryModal');
            let modal = bootstrap.Modal.getInstance(addCategoryModal);
            modal.hide();

            // Adicionar a nova categoria no dropdown
            let categorySelect = document.getElementById('category_id');
            let newOption = new Option(data.category.name, data.category.id);
            categorySelect.add(newOption, undefined);

            // Selecionar automaticamente a nova categoria
            categorySelect.value = data.category.id;
        } else {
            alert('Erro ao criar categoria.');
        }
    })
    .catch(error => console.error('Erro:', error));
});

// Função para abrir o modal de edição com dados da categoria
function openEditCategoryModal(categoryId, categoryName) {
    document.getElementById('edit_category_id').value = categoryId;
    document.getElementById('edit_category_name').value = categoryName;
    let editCategoryModal = new bootstrap.Modal(document.getElementById('editCategoryModal'));
    editCategoryModal.show();
}

document.getElementById('updateCategory').addEventListener('click', function() {
    let categoryId = document.getElementById('edit_category_id').value;
    let categoryName = document.getElementById('edit_category_name').value;
    let token = document.querySelector('input[name=_token]').value;

    fetch(`/categories/${categoryId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({
            name: categoryName
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            let categorySelect = document.getElementById('category_id');
            let option = categorySelect.querySelector(`option[value="${categoryId}"]`);
            option.textContent = data.category.name;

            let editCategoryModal = document.getElementById('editCategoryModal');
            let modal = bootstrap.Modal.getInstance(editCategoryModal);
            modal.hide();
        } else {
            alert('Erro ao atualizar categoria.');
        }
    })
    .catch(error => console.error('Erro:', error));
});

// Função para abrir o modal de exclusão
function openDeleteCategoryModal(categoryId) {
    document.getElementById('delete_category_id').value = categoryId;
    let deleteCategoryModal = new bootstrap.Modal(document.getElementById('deleteCategoryModal'));
    deleteCategoryModal.show();
}


document.getElementById('confirmDeleteCategory').addEventListener('click', function() {
    let categoryId = document.getElementById('delete_category_id').value;
    let token = document.querySelector('input[name=_token]').value;

    fetch(`/categories/${categoryId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Fechar o modal
            let deleteCategoryModal = document.getElementById('deleteCategoryModal');
            let modal = bootstrap.Modal.getInstance(deleteCategoryModal);
            modal.hide();

            // Recarregar a página
            location.reload();
        } else {
            alert('Erro ao excluir categoria.');
        }
    })
    .catch(error => console.error('Erro:', error));
});

// Função para abrir o modal de edição de categoria
function openEditCategoryModal(categoryId, categoryName) {
    document.getElementById('edit_category_id').value = categoryId;
    document.getElementById('edit_category_name').value = categoryName;
    var myModal = new bootstrap.Modal(document.getElementById('editCategoryModal'));
    myModal.show();
}

// Função para abrir o modal de exclusão de categoria
function openDeleteCategoryModal(categoryId) {
    document.getElementById('delete_category_id').value = categoryId;
    var myModal = new bootstrap.Modal(document.getElementById('deleteCategoryModal'));
    myModal.show();
}

</script>
@endsection
