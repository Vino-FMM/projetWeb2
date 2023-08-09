<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Vino | cellier</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    </head>
    <style>
      .filter-container {
    position: relative;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.filter {
    position: absolute;
    top: 100%;
    right: 0;
    width: 300px;
    padding: 1rem;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease-out;
    transform: translateX(100%);
}

.filter.show {
    transform: translateX(0);
}

.toggle-filter {
    display: block;
    padding: 0.5rem 1rem;
    /* background-color: #007bff; */
    color: #fff;
    text-decoration: none;
    transition: background-color 0.3s ease-out;
}

/* .toggle-filter:hover {
    background-color: #0062cc;
} */

.toggle-filter.active {
    background-color: #dc3545;
}

.toggle-filter.active:hover {
    background-color: #c82333;
}  
    </style>
    <body>
    @php $locale = session('locale') @endphp
        <nav>
        <span><img src="https://s2.svgbox.net/materialui.svg?ic=wine_bar&color=fff" width="32" height="32">VINO</span>
            <div>
                <input type="checkbox" id="toggler" hidden>
                <label for="toggler" class="toggler-label">
                    <span></span>
                    <span></span>
                    <span></span>
                </label>
                <div id="navbarSupportedContent">
                    <ul>
                        <li><a href="{{ route('home') }}">Accueil</a></li>
                        <li><a href="#!">À propos</a></li>
                        @if (auth()->check())
                        <li><a href="{{ route('logout') }}">Se déconnecter</a></li>
                        @else
                        <li><a href="{{ route('login') }}">Se connecter</a></li>
                        <li><a href="{{ route('register') }}">S'enregistrer</a></li>
                        @endif
                    </ul>
                </div>
            </div>   
        </nav>
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <!-- Header-->
        @yield('content')
        <!-- Footer-->
        <!-- <footer class="py-5 bg-dark">
            <div class="container px-5"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p></div>
        </footer> -->
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="{{ asset('js/scripts.js') }}"></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>
</html>
