<nav class="sidebar">
  <div class="sidebar-header">
    <a href="#" class="sidebar-brand">
      Noble<span>UI</span>
    </a>
    <div class="sidebar-toggler not-active">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>

  <div class="sidebar-body">
    <ul class="nav">

      <li class="nav-item nav-category">Home</li>
      <li class="nav-item {{ active_class(['/']) }}">
        <a href="{{ url('/') }}" class="nav-link">
          <i class="link-icon" data-feather="box"></i>
          <span class="link-title">Dashboard</span>
        </a>
      </li>

      <li class="nav-item nav-category">CRUD</li>
      <li class="nav-item {{ active_class(['/shelters*']) }}">
        <a href="{{ route("shelter.index") }}" class="nav-link">
          <i class="link-icon" data-feather="box"></i>
          <span class="link-title">Oporavilišta</span>
        </a>
      </li>
      <li class="nav-item {{ active_class(['/user*']) }}">
        <a href="{{ route("user.index") }}" class="nav-link">
          <i class="link-icon" data-feather="user"></i>
          <span class="link-title">Korisnici</span>
        </a>
      </li>

      <li class="nav-item nav-category">Docs</li>
      <li class="nav-item">
        <a href="https://www.nobleui.com/laravel/documentation/docs.html" target="_blank" class="nav-link">
          <i class="link-icon" data-feather="hash"></i>
          <span class="link-title">Documentation</span>
        </a>
      </li>


    </ul>
  </div>
</nav>