<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <ul class="app-menu">
        <li>
            <a class="app-menu__item  {{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="app-menu__icon fa fa-dashboard"></i>
                <span class="app-menu__label">Dashboard</span>
            </a>
        </li>
            <!---User Management-->
            <li>
                <a class="app-menu__item {{ request()->is('admin/users') ? 'active' : '' }} {{ sidebar_open(['admin.users']) }}"
                    href="{{ route('admin.users.index') }}">
                    <i class="app-menu__icon fa fa-user"></i>
                    <span class="app-menu__label">User Management</span>
                </a>
            </li>
             <!--  Bussiness management -->
             <li>
                <a class="app-menu__item {{ request()->is('admin/bussinesslead*') ? 'active' : '' }} {{ sidebar_open(['admin.bussinesslead']) }}" href="{{ route('admin.bussinesslead.index') }}"><i class="app-menu__icon fa fa-handshake-o"></i>
                    <span class="app-menu__label">BussinessLead management</span>
                </a>
            </li>
            <li class="text-light" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <a href="#" class="app-menu__item @if(request()->is('admin/state*') || request()->is('admin/pin*') || request()->is('admin/suburb*')) {{ 'active' }} @endif">
                    <span class="app-menu__label">Master management</span>
                    <i class="app-menu__icon fa fa-chevron-down"></i>
                </a>
            </li>
            <div id="collapseOne" class="collapse @if(request()->is('admin/state*') || request()->is('admin/pin*') || request()->is('admin/suburb*')) {{ 'show' }} @endif" aria-labelledby="headingOne" data-parent="#accordion">
                <!---State management-->
                <li>
                    <a class="app-menu__item {{ request()->is('admin/state*') ? 'active' : '' }} {{ sidebar_open(['admin.state']) }}"
                        href="{{ route('admin.state.index') }}">
                        <i class="app-menu__icon fa fa-flag"></i>
                        <span class="app-menu__label">State management</span>
                    </a>
                </li>
                <!---Pin code management-->
                <li>
                    <a class="app-menu__item {{ request()->is('admin/pin') ? 'active' : '' }} {{ sidebar_open(['admin.pin']) }}"
                        href="{{ route('admin.pin.index') }}"><i class="app-menu__icon fa fa-map-pin"></i>
                        <span class="app-menu__label">Pin code management</span>
                    </a>
                </li>
                <!--- Suburb management --->
                <li>
                    <a class="app-menu__item {{ request()->is('admin/suburb') ? 'active' : '' }} {{ sidebar_open(['admin.suburb']) }}"
                        href="{{ route('admin.suburb.index') }}"><i class="app-menu__icon fa fa-cogs"></i>
                        <span class="app-menu__label">Suburb management</span>
                    </a>
                </li>

            </div>

           <li class="text-light" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <a href="#" class="app-menu__item @if(request()->is('admin/category*') || request()->is('admin/subcategory*') || request()->is('admin/sub-category-level2*') || request()->is('admin/blog*')) {{ 'active' }} @endif">
                <span class="app-menu__label">Blog Master</span>
                <i class="app-menu__icon fa fa-chevron-down"></i>
            </a>
        </li>
        <div id="collapseTwo" class="collapse @if(request()->is('admin/category*') || request()->is('admin/subcategory*') || request()->is('admin/sub-category-level2*') || request()->is('admin/blog*')) {{ 'show' }} @endif" aria-labelledby="headingOne" data-parent="#accordion">
                <!--- Category management --->
                <li>
                    <a class="app-menu__item {{ request()->is('admin/category') ? 'active' : '' }} {{ sidebar_open(['admin.category']) }}"
                        href="{{ route('admin.category.index') }}">
                        <i class="app-menu__icon fa fa-archive"></i>
                        <span class="app-menu__label">Category management</span>
                    </a>
                </li>
                <!--- Sub category management --->
                <li>
                    <a class="app-menu__item {{ request()->is('admin/subcategory') ? 'active' : '' }} {{ sidebar_open(['admin.subcategory']) }}"
                        href="{{ route('admin.subcategory.index') }}">
                        <i class="app-menu__icon fa fa-sitemap"></i>
                        <span class="app-menu__label">Sub category management</span>
                    </a>
                </li>
                <!---  Sub category level2 management ---->
                <li>
                    <a class="app-menu__item {{ request()->is('admin/sub-category-level2') ? 'active' : '' }} {{ sidebar_open(['admin.sub-category-level2']) }}"
                        href="{{ route('admin.sub-category-level2.index') }}">
                        <i class="app-menu__icon fa fa-sitemap"></i>
                        <span class="app-menu__label">Sub category 2 management</span>
                    </a>
                </li>
                <li>
                    <a class="app-menu__item {{ request()->is('admin/blog') ? 'active' : '' }} {{ sidebar_open(['admin.blog']) }}"
                        href="{{ route('admin.blog.index') }}">
                        <i class="app-menu__icon fa fa-file"></i>
                        <span class="app-menu__label">Blog Management</span>
                    </a>
                </li>
            </div>
            <li class="text-light" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                <a href="#" class="app-menu__item @if(request()->is('admin/dircategory*') || request()->is('admin/directory*')) {{ 'active' }} @endif">
                    <span class="app-menu__label">Directory Master</span>
                    <i class="app-menu__icon fa fa-chevron-down"></i>
                </a>
            </li>
            <div id="collapseThree" class="collapse @if(request()->is('admin/dircategory*') || request()->is('admin/directory*')) {{ 'show' }} @endif" aria-labelledby="headingOne" data-parent="#accordion">
                <li>
                    <a class="app-menu__item {{ request()->is('admin/dircategory') ? 'active' : '' }} {{ sidebar_open(['admin.dircategory']) }}"
                    href="{{ route('admin.dircategory.index') }}"><i class="app-menu__icon fa fa-folder"></i>
                <span class="app-menu__label">Directory Category management</span>
                </a>
                </li>
                <!---  Directory  management ---->
                <li>
                    <a class="app-menu__item {{ request()->is('admin/directory') ? 'active' : '' }} {{ sidebar_open(['admin.directory']) }}"
                        href="{{ route('admin.directory.index') }}"><i class="app-menu__icon fa fa-folder"></i>
                        <span class="app-menu__label">Directory management</span>
                    </a>
                </li>
            </div>

            <!---  Collection management ---->
            <li class="text-light" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                <a href="#" class="app-menu__item @if(request()->is('admin/collection*') || request()->is('admin/collectiondir*'))  {{ 'active' }} @endif">
                    <span class="app-menu__label">Collection Master</span>
                    <i class="app-menu__icon fa fa-chevron-down"></i>
                </a>
            </li>
            <div id="collapseFour" class="collapse @if(request()->is('admin/collection*') || request()->is('admin/collectiondir*')) {{ 'show' }} @endif" aria-labelledby="headingOne" data-parent="#accordion">
                <!---  Collection management ---->
                <li>
                    <a class="app-menu__item {{ request()->is('admin/collection') ? 'active' : '' }} {{ sidebar_open(['admin.collection']) }}"
                        href="{{ route('admin.collection.index') }}">
                        <i class="app-menu__icon fa fa-cubes"></i>
                        <span class="app-menu__label">Collection management</span>
                    </a>
                </li>
                <!---  Collection-Directory management ---->
                <li>
                    <a class="app-menu__item {{ request()->is('admin/collectiondir') ? 'active' : '' }} {{ sidebar_open(['admin.collectiondir']) }}"
                        href="{{ route('admin.collectiondir.index') }}">
                        <i class="app-menu__icon fa fa-cubes"></i>
                        <span class="app-menu__label">Collection Directory management</span>
                    </a>
                </li>
            </div>
           <li class="text-light" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
            <a href="#" class="app-menu__item @if(request()->is('admin/about-us*') || request()->is('admin/contact-us*') || request()->is('admin/faq*')) {{ 'active' }} @endif">
                <span class="app-menu__label">Frontend management</span>
                <i class="app-menu__icon fa fa-chevron-down"></i>
            </a>
        </li>
        <div id="collapseFive" class="collapse @if(request()->is('admin/about-us*') || request()->is('admin/contact-us*') || request()->is('admin/faq*')) {{ 'show' }} @endif" aria-labelledby="headingOne" data-parent="#accordion">
            <!---State management-->
            <li>
                <a class="app-menu__item {{ request()->is('admin/about-us*') ? 'active' : '' }} {{ sidebar_open(['admin.about-us']) }}"
                    href="{{ route('admin.about-us.index') }}">
                    <i class="app-menu__icon fa fa-flag"></i>
                    <span class="app-menu__label">About us</span>
                </a>
            </li>
            <!---Pin code management-->
            <li>
                <a class="app-menu__item {{ request()->is('admin/contact-us') ? 'active' : '' }} {{ sidebar_open(['admin.contact-us']) }}"
                    href="{{ route('admin.contact-us.index') }}"><i class="app-menu__icon fa fa-map-pin"></i>
                    <span class="app-menu__label">Contact us</span>
                </a>
            </li>
            <!--- Suburb management --->
            <li>
                <a class="app-menu__item {{ request()->is('admin/faq') ? 'active' : '' }} {{ sidebar_open(['admin.faq']) }}" href="{{ route('admin.faq.index') }}"><i class="app-menu__icon fa fa-cogs"></i>
                    <span class="app-menu__label">FAQ</span>
                </a>
            </li>
        </div>

        <!----- Settings ------>
        <li>
            <a class="app-menu__item {{ sidebar_open(['admin.settings']) }}"
                href="{{ route('admin.settings.index') }}"><i class="app-menu__icon fa fa-cogs"></i>
                <span class="app-menu__label"> Settings</span>
            </a>
        </li>
        <!---  Blog management ---->

        {{-- <li>
            <a class="app-menu__item {{ sidebar_open(['admin.business']) }}"
                href="{{ route('admin.business.index') }}"><i class="app-menu__icon fa fa-group"></i>
                <span class="app-menu__label">Business Management</span>
            </a>
        </li> --}}
        {{-- <li>
            <a class="app-menu__item {{ sidebar_open(['admin.event']) }}"
                href="{{ route('admin.event.index') }}"><i class="app-menu__icon fa fa-group"></i>
                <span class="app-menu__label">Event Management</span>
            </a>
        </li> --}}
        {{-- <li>
            <a class="app-menu__item {{ sidebar_open(['admin.deal']) }}"
                href="{{ route('admin.deal.index') }}"><i class="app-menu__icon fa fa-group"></i>
                <span class="app-menu__label">Deal Management</span>
            </a>
        </li> --}}

        {{-- <li>
            <a class="app-menu__item {{ sidebar_open(['admin.loop']) }}"
                href="{{ route('admin.loop.index') }}"><i class="app-menu__icon fa fa-cogs"></i>
                <span class="app-menu__label">Local Loops</span>
            </a>
        </li> --}}
        {{-- <li>
            <a class="app-menu__item {{ sidebar_open(['admin.notification']) }}"
                href="{{ route('admin.notification.index') }}"><i class="app-menu__icon fa fa-cogs"></i>
                <span class="app-menu__label">Send Notifications</span>
            </a>
        </li> --}}
        {{-- <li>
            <a class="app-menu__item {{ sidebar_open(['admin.category']) }}"
                href="{{ route('admin.category.index') }}"><i class="app-menu__icon fa fa-cogs"></i>
                <span class="app-menu__label">Category Management</span>
            </a>
        </li> --}}
        {{-- <li>
            <a class="app-menu__item {{ sidebar_open(['admin.banner']) }}"
                href="{{ route('admin.banner.index') }}"><i class="app-menu__icon fa fa-cogs"></i>
                <span class="app-menu__label">Banner Management</span>
            </a>
        </li> --}}
        {{-- <li>
            <a class="app-menu__item {{ sidebar_open(['admin.blog']) }}"
                href="{{ route('admin.blog.index') }}"><i class="app-menu__icon fa fa-cogs"></i>
                <span class="app-menu__label">Blog Management</span>
            </a>
        </li> --}}
        {{-- --}}
    </ul>
</aside>
