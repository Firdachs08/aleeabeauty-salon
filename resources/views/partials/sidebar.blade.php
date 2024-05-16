<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
                <div class="sidebar-brand-text mx-3">{{ __('Homepage') }}</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ request()->is('admin/dashboard') || request()->is('admin/dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.dashboard.index') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>{{ __('Dashboard') }}</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <span>{{ __('User Management') }}</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}" href="{{ route('admin.permissions.index') }}"> <i class="fa fa-briefcase mr-2"></i> {{ __('Permissions') }}</a>
                        <a class="collapse-item {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}" href="{{ route('admin.roles.index') }}"><i class="fa fa-briefcase mr-2"></i> {{ __('Roles') }}</a>
                        <a class="collapse-item {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}"> <i class="fa fa-user mr-2"></i> {{ __('Users') }}</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseProduct" aria-expanded="true" aria-controls="collapseTwo">
                    <span>{{ __('Product Management') }}</span>
                </a>
                <div id="collapseProduct" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item {{ request()->is('admin/tags') || request()->is('admin/tags/*') ? 'active' : '' }}" href="{{ route('admin.tags.index') }}"> <i class="fa fa-briefcase mr-2"></i> {{ __('Tags') }}</a>

                        <a class="collapse-item {{ request()->is('admin/categories') || request()->is('admin/categories/*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}"> <i class="fa fa-briefcase mr-2"></i> {{ __('Categories') }}</a>

                        <a class="collapse-item {{ request()->is('admin/products') || request()->is('admin/products/*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}"> <i class="fa fa-briefcase mr-2"></i> {{ __('Products') }}</a>


                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseServices" aria-expanded="true" aria-controls="collapseServices">
                    <span>{{ __('Services Management') }}</span>
                </a>
                <div id="collapseServices" class="collapse" aria-labelledby="headingServices" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item {{ request()->is('admin/schedule') || request()->is('admin/schedule/*') ? 'active' : '' }}" href="{{ route('admin.schedule.index') }}"> <i class="fa fa-briefcase mr-2"></i> {{ __('Schedule') }}</a>
                        <a class="collapse-item {{ request()->is('admin/category') || request()->is('admin/category/*') ? 'active' : '' }}" href="{{ route('admin.category.index') }}"> <i class="fa fa-briefcase mr-2"></i> {{ __('Service Category') }}</a>
                        <a class="collapse-item {{ request()->is('admin/obtained') || request()->is('admin/obtained/*') ? 'active' : '' }}" href="{{ route('admin.obtained.index') }}"> <i class="fa fa-briefcase mr-2"></i> {{ __('Services Obtained') }}</a>
                        <a class="collapse-item {{ request()->is('admin/service') || request()->is('admin/service/*') ? 'active' : '' }}" href="{{ route('admin.service.index') }}"> <i class="fa fa-briefcase mr-2"></i> {{ __('Services') }}</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseOrder" aria-expanded="true" aria-controls="collapseTwo">
                    <span>{{ __('Transaction Management') }}</span>
                </a>
                <div id="collapseOrder" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item {{ request()->is('admin/orders') || request()->is('admin/orders/*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}"> <i class="fa fa-briefcase mr-2"></i> {{ __('Orders') }}</a>
                        <a class="collapse-item {{ request()->is('admin/booking') || request()->is('admin/booking/*') ? 'active' : '' }}" href="{{ route('admin.booking.index') }}"> <i class="fa fa-briefcase mr-2"></i> {{ __('Booking') }}</a>
                    </div>
                </div>
            </li>

           

        </ul>
