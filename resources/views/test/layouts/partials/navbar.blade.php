<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item @if(Route::current()->getName() == 'test.index') active @endif">
                <a class="nav-link" href="{{route('test.index')}}">Anasayfa
                    @if(Route::current()->getName() == 'test.index') <span class="sr-only">(current)</span> @endif
                </a>
            </li>
            <li class="nav-item @if(Route::current()->getName() == 'test.companies') active @endif">
                <a class="nav-link" href="{{route('test.companies')}}">Şirketler
                    @if(Route::current()->getName() == 'test.companies') <span class="sr-only">(current)</span> @endif
                </a>
            </li>
            <li class="nav-item @if(Route::current()->getName() == 'test.departments') active @endif">
                <a class="nav-link" href="{{route('test.departments')}}">Departmanlar
                    @if(Route::current()->getName() == 'test.departments') <span class="sr-only">(current)</span> @endif
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    Dropdown
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#">Disabled</a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
</nav>
