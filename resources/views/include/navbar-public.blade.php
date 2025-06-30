  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
      <a class="navbar-brand" href="{{route('home')}}">
        <img src=" {{asset('./images/logo.png')}}" alt="PMYBALS Logo" />
      </a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarMenu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div
        class="collapse navbar-collapse justify-content-end"
        id="navbarMenu">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="{{route('home')}}" class="nav-link active">Home</a>
          </li>
          <li class="nav-item">
            <a href="{{route('loan.application')}}" class="nav-link">Apply</a>
          </li>
          <li class="nav-item">
            <a href="{{route('track.application')}}" class="nav-link">Track</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
