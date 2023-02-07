<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>

	<!-- Fonts -->
	<link rel="dns-prefetch" href="//fonts.gstatic.com">
	<link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

	<!-- Scripts -->
	@vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
<div id="app">
	<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
		<div class="container">
			<a class="navbar-brand" href="{{ url('/') }}">
				{{ config('app.name', 'Laravel') }}
			</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<!-- Left Side Of Navbar -->
				<ul class="navbar-nav me-auto">
					<li class="nav-item">
						<a href="{{ route('home') }}" class="nav-link @if(Route::is('home')) active @endif">Calendar</a>
					</li>

					<li class="nav-item">
						<a href="{{ route('leaves.create') }}" class="nav-link @if(Route::is('leaves.create')) active @endif">Submit leave request</a>
					</li>

					@if(Auth::user()->isManager())
						<li class="nav-item">
							<a href="{{ route('leaves.index') }}" class="nav-link @if(Route::is('leaves.index')) active @endif">Manage leaves</a>
						</li>
					@endif
				</ul>

				<!-- Right Side Of Navbar -->
				<ul class="navbar-nav ms-auto">
					<!-- Authentication Links -->
					@guest
						@if (Route::has('login'))
							<li class="nav-item">
								<a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
							</li>
						@endif

						@if (Route::has('register'))
							<li class="nav-item">
								<a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
							</li>
						@endif
					@else
						<li class="nav-item dropdown">
							<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
								{{ Auth::user()->name }}
							</a>

							<div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href="{{ route('logout') }}"
									 onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
									{{ __('Logout') }}
								</a>

								<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
									@csrf
								</form>
							</div>
						</li>
					@endguest
				</ul>
			</div>
		</div>
	</nav>

	<main class="py-4">
		@if(session('success'))
			<div class="container-fluid pt-5 px-5">
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					{{ session('success') }}
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			</div>
		@endif

		@if(session('error'))
			<div class="container-fluid pt-5 px-5">
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-bs-dismiss="alert" aria-label="Close"></button>
					{{ session('error') }}
				</div>
			</div>
		@endif
		@yield('content')
	</main>
</div>
@stack('scripts')
</body>
</html>
