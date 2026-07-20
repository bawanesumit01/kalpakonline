 @php $user = auth()->user(); @endphp

 <aside class="mdc-drawer mdc-drawer--dismissible mdc-drawer--open">
     <div class="mdc-drawer__header">
         <a href="{{ route('dashboard') }}" class="brand-logo">
             <img src="{{ asset('/assets/images/kalpak-logo.jpeg') }}" class="w-100" alt="logo">
         </a>
     </div>
     <div class="mdc-drawer__content">
         <div class="user-info">
             <p class="name">{{ auth()->user()->name }}</p>
             <p class="email">{{ auth()->user()->email }}</p>
         </div>
         <div class="mdc-list-group">
             <nav class="mdc-list mdc-drawer-menu">
                 @if ($user->hasPermission('dashboard'))
                     <div class="mdc-list-item mdc-drawer-item">
                         <a class="mdc-drawer-link gap-3 {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                             href="{{ route('dashboard') }}">
                             <i class="fa-solid fa-house"></i> Dashboard
                         </a>
                     </div>
                 @endif
                 @if ($user->hasPermission('vendors') && $user->role === 'superadmin')
                     <div class="mdc-list-item mdc-drawer-item">
                         <a class="mdc-drawer-link gap-3 {{ request()->routeIs('vendor.index') ? 'active' : '' }}"
                             href="{{ route('vendor.index') }}">
                             <i class="fa-solid fa-shop"></i> Vendor
                         </a>
                     </div>
                 @endif
                 @if ($user->hasPermission('category') && ($user->role === 'superadmin' || $user->role === 'admin'))
                     <div class="mdc-list-item mdc-drawer-item">
                         <a class="mdc-drawer-link gap-3 {{ request()->routeIs('category.index') ? 'active' : '' }}"
                             href="{{ route('category.index') }}">
                             <i class="fa-solid fa-tags"></i> Category
                         </a>
                     </div>
                 @endif
                 @if ($user->hasPermission('products') && ($user->role === 'superadmin' || $user->role === 'admin'))
                     <div class="mdc-list-item mdc-drawer-item">
                         <a class="mdc-drawer-link gap-3 {{ request()->routeIs('products.index') ? 'active' : '' }}"
                             href="{{ route('products.index') }}">
                             <i class="fa-solid fa-boxes-stacked"></i> Products
                         </a>
                     </div>
                 @endif

                 <!-- Orders Management - Only Superadmin -->
                 @if ($user->role === 'superadmin')
                     <div class="mdc-list-item mdc-drawer-item">
                         <a class="mdc-drawer-link gap-3 {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"
                             href="{{ route('admin.orders.index') }}">
                             <i class="fa-solid fa-receipt"></i> Orders
                         </a>
                     </div>
                 @endif

                 <!-- Customers Management - Only Superadmin -->
                 @if ($user->role === 'superadmin')
                     <div class="mdc-list-item mdc-drawer-item">
                         <a class="mdc-drawer-link gap-3 {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}"
                             href="{{ route('admin.customers.index') }}">
                             <i class="fa-solid fa-users"></i> Customers
                         </a>
                     </div>
                 @endif

                 <!-- Enquiries Management - Only Superadmin -->
                 @if ($user->role === 'superadmin')
                     <div class="mdc-list-item mdc-drawer-item">
                         <a class="mdc-drawer-link gap-3 {{ request()->routeIs('admin.enquiries.*') ? 'active' : '' }}"
                             href="{{ route('admin.enquiries.index') }}">
                             <i class="fa-solid fa-envelope"></i> Enquiries
                         </a>
                     </div>
                 @endif

                 <!-- Delivery Tracking Management - Only Superadmin -->
                 @if ($user->role === 'superadmin')
                     <div class="mdc-list-item mdc-drawer-item">
                         <a class="mdc-drawer-link gap-3 {{ request()->routeIs('admin.delivery.*') ? 'active' : '' }}"
                             href="{{ route('admin.delivery.index') }}">
                             <i class="fa-solid fa-motorcycle"></i> Deliveries
                         </a>
                     </div>
                 @endif

                 <!-- Marquee Settings - Only Superadmin -->
                 @if ($user->role === 'superadmin')
                     <div class="mdc-list-item mdc-drawer-item">
                         <a class="mdc-drawer-link gap-3 {{ request()->routeIs('admin.marquee.*') ? 'active' : '' }}"
                             href="{{ route('admin.marquee.index') }}">
                             <i class="fa-solid fa-rectangle-ad"></i> Marquee
                         </a>
                     </div>

                     <!-- Hero Slider Settings - Only Superadmin -->
                     <div class="mdc-list-item mdc-drawer-item">
                         <a class="mdc-drawer-link gap-3 {{ request()->routeIs('hero-slider.*') ? 'active' : '' }}"
                             href="{{ route('hero-slider.index') }}">
                             <i class="fa-solid fa-film"></i> Hero Slider
                         </a>
                     </div>

                     <!-- Site Settings - Only Superadmin -->
                     <div class="mdc-list-item mdc-drawer-item">
                         <a class="mdc-drawer-link gap-3 {{ request()->routeIs('site-settings.*') ? 'active' : '' }}"
                             href="{{ route('site-settings.edit') }}">
                             <i class="fa-solid fa-sliders"></i> Site Settings
                         </a>
                     </div>
                 @endif

                 <!--<div class="mdc-list-item mdc-drawer-item">-->
                 <!--    <a class="mdc-expansion-panel-link gap-3" href="#" data-toggle="expansionPanel"-->
                 <!--        data-target="ui-sub-menu">-->
                 <!--        <i class="fa-solid fa-table-list"></i> UI Features-->
                 <!--        <i class="fa-solid fa-angle-right"></i>-->
                 <!--    </a>-->
                 <!--    <div class="mdc-expansion-panel" id="ui-sub-menu">-->
                 <!--        <nav class="mdc-list mdc-drawer-submenu">-->
                 <!--            <div class="mdc-list-item mdc-drawer-item">-->
                 <!--                <a class="mdc-drawer-link" href="#">-->
                 <!--                    Buttons-->
                 <!--                </a>-->
                 <!--            </div>-->
                 <!--            <div class="mdc-list-item mdc-drawer-item">-->
                 <!--                <a class="mdc-drawer-link" href="#">-->
                 <!--                    Typography-->
                 <!--                </a>-->
                 <!--            </div>-->
                 <!--        </nav>-->
                 <!--    </div>-->
                 <!--</div>-->


             </nav>
         </div>
         <div class="profile-actions">
             <a class="pt-1 {{ request()->routeIs('site-settings.*') ? 'active' : '' }}"
                             href="{{ route('site-settings.edit') }}">Settings</a>
             <span class="divider pt-4"></span>
             <form method="POST" action="{{ route('logout') }}">
                 @csrf

                 <a :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" style="cursor: pointer;">
                     Logout
                 </a>
             </form>
         </div>

     </div>
 </aside>
