<ul class="list-unstyled accordion-menu">
    <li class="sidebar-title">
      Main
    </li>
    <li class="{{ request()->is('/') ? 'active-page' : '' }}">
      <a href="{{route('dashboard.index')}}"><i data-feather="home"></i>Dashboard</a>
    </li>
    <li class="sidebar-title">
      Apps
    </li>
     <li class="{{ request()->is('incoming-orders') ? 'active-page' : '' }}">
        <a href="{{route('incoming-orders.index')}}"><i data-feather="book"></i>Daftar Pesanan Masuk</a>
    </li>
    <li class="{{ request()->is('category') ? 'active-page' : '' }}">
        <a href="{{route('category.index')}}"><i data-feather="clipboard"></i>Daftar Category</a>
    </li>
    <li class="{{ request()->is('menu') ? 'active-page' : '' }}">
        <a href="{{route('menu.index')}}"><i data-feather="archive"></i>Daftar Menu</a>
    </li>

  </ul>
