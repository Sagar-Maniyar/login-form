<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Navbar</a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="{{ route('login.view') }}">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
        </li>
      </ul>
  
      <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>
  
      @if(auth()->check())
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
        <button class="btn btn-outline-danger my-2 my-sm-0 mx-2" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          Logout
        </button>
      @else
        {{--  <a href="{{ route('login.view') }}" class="btn btn-outline-primary my-2 my-sm-0 mx-2">Login</a>  --}}
        <a href="{{ route('register.view') }}" class="btn btn-outline-success my-2 my-sm-0 mx-2">Register</a>

      @endif
    </div>
  </nav>
  
</body>
</html>
