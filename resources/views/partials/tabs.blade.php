<ul class="nav nav-tabs">
    <li class="nav-item">
        <a href="{{ url('/home') }}" class="btn btn-primary">⬅️</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Request::routeIs('products.create') ? 'active' : '' }}" href="{{ route('products.create') }}">Novo Produto</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Request::routeIs('products.list') ? 'active' : '' }}" href="{{ route('products.list') }}">Editar</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">Importar Produto</a>
    </li>
</ul>
