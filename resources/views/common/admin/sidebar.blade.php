<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar user panel (optional) -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="/img/admin/user{{ Auth::user()->user_id }}-160x160.jpg" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</p>
        <!-- Status -->
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>

    <!-- search form (Optional) -->
    {{--
    <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
          <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
        </span>
      </div>
    </form>
    --}}
    <!-- /.search form -->

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
      <li class="header">MENU</li>
      <!-- Optionally, you can add icons to the links -->
      <li class="{{ set_active('admin/dashboard') }}"><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
      <li class="{{ set_active('admin/bookings') }}"><a href="/admin/bookings"><i class="fa fa-book"></i> <span>Bookings</span></a></li>
      <li class="treeview {{ set_parent_active('admin/partners') }}">
        <a href="#"><i class="fa fa-users"></i> <span>Affiliates</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li class="{{ set_active('admin/partners') }}"><a href="/admin/partners"><i class="fa fa-circle-o"></i> View Affiliates</a></li>
          <li class="{{ set_active('admin/partners/create') }}"><a href="/admin/partners/create"><i class="fa fa-circle-o"></i> Add a new Affiliate</a></li>
        </ul>
      </li>
      <li class="treeview {{ set_parent_active('admin/articles') }}">
        <a href="#"><i class="fa fa-clipboard"></i> <span>Articles</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li class="{{ set_active('admin/articles') }}"><a href="/admin/articles"><i class="fa fa-circle-o"></i> View Articles</a></li>
          <li class="{{ set_active('admin/articles/create') }}"><a href="/admin/articles/create"><i class="fa fa-circle-o"></i> Add a new Article</a></li>
        </ul>
      </li>
      <li class="treeview {{ set_parent_active('admin/locations') }}">
        <a href="#"><i class="fa fa-map"></i> <span>Locations</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li class="{{ set_active('admin/locations') }}"><a href="/admin/locations"><i class="fa fa-circle-o"></i> View Locations</a></li>
          <li class="{{ set_active('admin/locations/create') }}"><a href="/admin/locations/create"><i class="fa fa-circle-o"></i> Add a new Location</a></li>
        </ul>
      </li>
      <li class="treeview {{ set_parent_active('admin/parking') }}">
        <a href="#"><i class="fa fa-car"></i> <span>Parkings</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li class="{{ set_active('admin/parking') }}"><a href="/admin/parking"><i class="fa fa-circle-o"></i> View Parkings</a></li>
          <li class="{{ set_active('admin/parking/create') }}"><a href="/admin/parking/create"><i class="fa fa-circle-o"></i> Add a new Parking</a></li>
        </ul>
      </li>
      <li class="treeview {{ set_parent_active('admin/tags') }}">
        <a href="#"><i class="fa fa-tags"></i> <span>Parking Features</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li class="{{ set_active('admin/tags') }}"><a href="/admin/tags"><i class="fa fa-circle-o"></i> View Features</a></li>
          <li class="{{ set_active('admin/tags/create') }}"><a href="/admin/tags/create"><i class="fa fa-circle-o"></i> Add a new Feature</a></li>
        </ul>
      </li>
    </ul><!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>