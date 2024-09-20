<div class="col-md-2 bg-light">
    <div class="d-flex flex-column p-3">
        <h4>LIBZZ</h4>
        <hr>
        <ul class="nav flex-column mb-auto">
            <li class="nav-item mb-2">
                <a href="{{ route('adicionar.itens') }}" class="nav-link text-dark">Adicionar Produtos</a>
            </li>
            <li class="nav-item mb-2">
                <a href="#" class="nav-link text-dark">Editar Categorias</a>
            </li>
        </ul>
        <hr>
        <ul class="nav flex-column mb-auto">
            <li class="nav-item mb-2">
                @if (Auth::check())
                    <a href="{{ route('users.edit', ['user' => Auth::user()->id]) }}" class="nav-link text-dark">Perfil</a>
                @else
                    <a href="{{ route('login') }}" class="nav-link text-dark">Login</a>
                @endif
            </li>
            <li class="nav-item mb-2">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

                <a href="#" class="nav-link text-dark" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Sair
                </a>
            </li>
        </ul>
    </div>
</div>
