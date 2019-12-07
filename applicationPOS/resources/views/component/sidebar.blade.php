<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SimplePOS</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item  @if(Route::currentRouteName() == 'home') active @endif">
        <a class="nav-link" href="/home">
            <i class="fas fa-fw fa-barcode"></i>
            <span>Transaction</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="/transaction/list">
            <i class="fas fa-fw fa-list-alt"></i>
            <span>Transaction List</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Management
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="/item">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Item</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/user">
            <i class="fas fa-fw fa-person-booth"></i>
            <span>Staff</span></a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
