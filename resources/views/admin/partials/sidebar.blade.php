<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <ul class="app-menu">
        <li>
            <a class="app-menu__item  {{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="app-menu__icon fa fa-dashboard"></i>
                <span class="app-menu__label">Dashboard</span>
            </a>
        </li>

        <!-- User Management -->
        <li>
            <a class="app-menu__item {{ request()->is('admin/users*') ? 'active' : '' }} {{ sidebar_open(['admin.users']) }}" href="{{ route('admin.users.index') }}">
                <i class="app-menu__icon fa fa-user"></i>
                <span class="app-menu__label">User Management</span>
            </a>
        </li>

        <!-- Bussiness management -->
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
                    <a class="app-menu__item {{ request()->is('admin/pin*') ? 'active' : '' }} {{ sidebar_open(['admin.pin']) }}"
                        href="{{ route('admin.pin.index') }}"><i class="app-menu__icon fa fa-map-pin"></i>
                        <span class="app-menu__label">Postcode management</span>
                    </a>
                </li>
                <!--- Suburb management --->
                <li>
                    <a class="app-menu__item {{ request()->is('admin/suburb*') ? 'active' : '' }} {{ sidebar_open(['admin.suburb']) }}"
                        href="{{ route('admin.suburb.index') }}"><i class="app-menu__icon fa fa-cogs"></i>
                        <span class="app-menu__label">Suburb management</span>
                    </a>
                </li>

            </div>

           <li class="text-light" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <a href="#" class="app-menu__item @if(request()->is('admin/category*') || request()->is('admin/subcategory*') || request()->is('admin/sub-category-level2*') || request()->is('admin/blog*')) {{ 'active' }} @endif">
                <span class="app-menu__label">Article Master</span>
                <i class="app-menu__icon fa fa-chevron-down"></i>
            </a>
        </li>
        <div id="collapseTwo" class="collapse @if(request()->is('admin/category*') || request()->is('admin/subcategory*') || request()->is('admin/sub-category-level2*') || request()->is('admin/blog*')) {{ 'show' }} @endif" aria-labelledby="headingOne" data-parent="#accordion">
                <!--- Category management --->
                <li>
                    <a class="app-menu__item {{ request()->is('admin/category*') ? 'active' : '' }} {{ sidebar_open(['admin.category']) }}"
                        href="{{ route('admin.category.index') }}">
                        <i class="app-menu__icon fa fa-archive"></i>
                        <span class="app-menu__label">Category Management</span>
                    </a>
                </li>
                <!--- Sub category management --->
                <li>
                    <a class="app-menu__item {{ request()->is('admin/subcategory*') ? 'active' : '' }} {{ sidebar_open(['admin.subcategory']) }}"
                        href="{{ route('admin.subcategory.index') }}">
                        <i class="app-menu__icon fa fa-sitemap"></i>
                        <span class="app-menu__label">Sub Category Management</span>
                    </a>
                </li>
                <!---  Sub category level2 management ---->
                <li>
                    <a class="app-menu__item {{ request()->is('admin/sub-category-level2*') ? 'active' : '' }} {{ sidebar_open(['admin.sub-category-level2']) }}"
                        href="{{ route('admin.sub-category-level2.index') }}">
                        <i class="app-menu__icon fa fa-sitemap"></i>
                        <span class="app-menu__label">Tertiary Management</span>
                    </a>
                </li>
                <li>
                    <a class="app-menu__item {{ request()->is('admin/blog*') ? 'active' : '' }} {{ sidebar_open(['admin.blog']) }}"
                        href="{{ route('admin.blog.index') }}">
                        <i class="app-menu__icon fa fa-file"></i>
                        <span class="app-menu__label">Article Management</span>
                    </a>
                </li>

               <!-- <li>
                    <a class="app-menu__item {{ request()->is('admin/blogfaqcat*') ? 'active' : '' }} {{ sidebar_open(['admin.blogfaqcat']) }}"
                        href="{{ route('admin.blogfaqcat.index') }}">
                        <i class="app-menu__icon fa fa-file"></i>
                        <span class="app-menu__label">Article Faq Category</span>
                    </a>
                </li>
                <li>
                    <a class="app-menu__item {{ request()->is('admin/blogsubcatfaq*') ? 'active' : '' }} {{ sidebar_open(['admin.blogsubcatfaq']) }}"
                        href="{{ route('admin.blogsubcatfaq.index') }}">
                        <i class="app-menu__icon fa fa-file"></i>
                        <span class="app-menu__label">Article Faq Subcategory</span>
                    </a>
                </li>-->
            </div>
            <li class="text-light" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                <a href="#" class="app-menu__item @if(request()->is('admin/dircategory*') || request()->is('admin/directory*')) {{ 'active' }} @endif">
                    <span class="app-menu__label">Directory Master</span>
                    <i class="app-menu__icon fa fa-chevron-down"></i>
                </a>
            </li>
            <div id="collapseThree" class="collapse @if(request()->is('admin/dircategory*') || request()->is('admin/directory*')) {{ 'show' }} @endif" aria-labelledby="headingOne" data-parent="#accordion">
                <li>
                    <a class="app-menu__item {{ request()->is('admin/dircategory*') ? 'active' : '' }} {{ sidebar_open(['admin.dircategory']) }}" href="{{ route('admin.dircategory.index') }}"><i class="app-menu__icon fa fa-folder"></i>
                        <span class="app-menu__label">Primary Category</span>
                    </a>
                </li>
                <li>
                    <a class="app-menu__item {{ request()->is('admin/dircategory/sub*') ? 'active' : '' }} {{ sidebar_open(['admin.dirsubcategory']) }}" href="{{ route('admin.dirsubcategory.index') }}"><i class="app-menu__icon fa fa-folder"></i>
                        <span class="app-menu__label">Secondary Category</span>
                    </a>
                </li>
                <li>
                    <a class="app-menu__item {{ request()->is('admin/directory*') ? 'active' : '' }} {{ sidebar_open(['admin.directory']) }}"
                        href="{{ route('admin.directory.index') }}"><i class="app-menu__icon fa fa-folder"></i>
                        <span class="app-menu__label">Directory Management</span>
                    </a>
                </li>
                <li>
                    <a class="app-menu__item {{ request()->is('admin/directory/google/category*') ? 'active' : '' }}" href="{{ route('admin.directory.google.category') }}"><i class="app-menu__icon fa fa-folder"></i>
                        <span class="app-menu__label">Directory Category</span>
                    </a>
                </li>
                <li>
                    <a class="app-menu__item {{ request()->is('admin/directory/category/match*') ? 'active' : '' }}" href="{{ route('admin.directory.category.match') }}"><i class="app-menu__icon fa fa-folder"></i>
                        <span class="app-menu__label">Category matching</span>
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
                    <a class="app-menu__item {{ request()->is('admin/collection*') ? 'active' : '' }} {{ sidebar_open(['admin.collection']) }}"
                        href="{{ route('admin.collection.index') }}">
                        <i class="app-menu__icon fa fa-cubes"></i>
                        <span class="app-menu__label">Collection Management</span>
                    </a>
                </li>
                <!---  Collection-Directory management ---->
                <li>
                    <a class="app-menu__item {{ request()->is('admin/collectiondir*') ? 'active' : '' }} {{ sidebar_open(['admin.collectiondir']) }}"
                        href="{{ route('admin.collectiondir.index') }}">
                        <i class="app-menu__icon fa fa-cubes"></i>
                        <span class="app-menu__label">Collection Directory Management</span>
                    </a>
                </li>
            </div>
        <!--- Event management -->    
        <li>
            <a class="app-menu__item {{ sidebar_open(['admin.event']) }}"
                href="{{ route('admin.event.index') }}"><i class="app-menu__icon fas fa-calendar-check"></i>
                <span class="app-menu__label">Event Management</span>
            </a>
        </li>
        <!-- deals management -->
        <li>
            <a class="app-menu__item {{ sidebar_open(['admin.event']) }}"
                href="{{ route('admin.deal.index') }}"><i class="app-menu__icon fas fa-tags"></i>
                <span class="app-menu__label">Deal Management</span>
            </a>
        </li>
        <!-- Job Management -->
        <li class="text-light" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true"
            aria-controls="collapseFive">
            <a href="#" class="app-menu__item @if (request()->is('admin/job/category*')||request()->is('admin/job/type*')||request()->is('admin/job*')) {{ 'active' }} @endif"><i class="fa fa-task"></i>
                <span class="app-menu__label">Job Master</span>
                <i class="app-menu__icon fa fa-chevron-down"></i>
            </a>
        </li>

        <div id="collapseFive" class="collapse @if (request()->is('admin/job*')) {{ 'show' }} @endif"
            aria-labelledby="headingOne" data-parent="#accordion">
            <li>
                <a class="app-menu__item {{ request()->is('admin/job/category*') ? 'active' : '' }}"
                    href="{{ route('admin.job.category.index') }}">
                    <i class="app-menu__icon fa fa-archive"></i>
                    <span class="app-menu__label">Category Management</span>
                </a>
            </li>
            <li>
                <a class="app-menu__item {{ request()->is('admin/job/type*') ? 'active' : '' }}"
                    href="{{ route('admin.job.type.index') }}">
                    <i class="app-menu__icon fa fa-archive"></i>
                    <span class="app-menu__label">Employment Type Management</span>
                </a>
            </li>
            <li>
                <a class="app-menu__item {{ request()->is('admin/job*') ? 'active' : '' }}"
                    href="{{ route('admin.job.index') }}"><i class="app-menu__icon fa fa-cogs"></i>
                    <span class="app-menu__label">Job Management</span>
                </a>
            </li>
        </div>
         {{-- <li>
            <a class="app-menu__item {{ sidebar_open(['admin.deal']) }}"
                href="{{ route('admin.deal.index') }}"><i class="app-menu__icon fa fa-group"></i>
                <span class="app-menu__label">Deal Management</span>
            </a>
        </li> --}}
         <li>
            <a class="app-menu__item {{ sidebar_open(['admin.csv']) }}"
                href="{{ route('admin.csv-activity.index') }}"><i class="app-menu__icon fa fa-group"></i>
                <span class="app-menu__label">CSV Activity Log</span>
            </a>
        </li>
           <li class="text-light" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
            <a href="#" class="app-menu__item @if(request()->is('admin/about-us*') || request()->is('admin/contact-us*') || request()->is('admin/faqmodule*') || request()->is('admin/faq*')|| request()->is('admin/splash*')|| request()->is('admin/forntendcollection*')) {{ 'active' }} @endif">
                <span class="app-menu__label">Frontend management</span>
                <i class="app-menu__icon fa fa-chevron-down"></i>
            </a>
        </li>
        <div id="collapseFive" class="collapse @if(request()->is('admin/about-us*') || request()->is('admin/contact-us*')  || request()->is('admin/splash*') || request()->is('admin/faqmodule*')|| request()->is('admin/faq*') || request()->is('admin/forntendcollection*')) {{ 'show' }} @endif" aria-labelledby="headingOne" data-parent="#accordion">
              <!---Splash -->
            <li>
                <a class="app-menu__item {{ request()->is('admin/splash*') ? 'active' : '' }} {{ sidebar_open(['admin.splash']) }}"
                    href="{{ route('admin.splash.index') }}"><i class="app-menu__icon fa fa-map-pin"></i>
                    <span class="app-menu__label">Splash Management</span>
                </a>
            </li>
            <!---Aboutus management-->
            <li>
                <a class="app-menu__item {{ request()->is('admin/about-us*') ? 'active' : '' }} {{ sidebar_open(['admin.about-us']) }}"
                    href="{{ route('admin.about-us.index') }}">
                    <i class="app-menu__icon fa fa-flag"></i>
                    <span class="app-menu__label">Aboutus Management</span>
                </a>
            </li>
            <!---Contactus management-->
            <li>
                <a class="app-menu__item {{ request()->is('admin/contact-us*') ? 'active' : '' }} {{ sidebar_open(['admin.contact-us']) }}"
                    href="{{ route('admin.contact-us.index') }}"><i class="app-menu__icon fa fa-map-pin"></i>
                    <span class="app-menu__label">Contactus Management</span>
                </a>
            </li>
            <!--- Faq  --->
         <li>
            <a class="app-menu__item {{ request()->is('admin/faqmodule*') ? 'active' : '' }} {{ sidebar_open(['admin.faqmodule']) }}"
            href="{{ route('admin.faqmodule.index') }}"><i class="app-menu__icon fa fa-cogs"></i>
            <span class="app-menu__label">Faq Management</span>
        </a>
        <!--- Faq question management --->
        <li>
            <a class="app-menu__item {{ request()->is('admin/faq*') ? 'active' : '' }} {{ sidebar_open(['admin.faq']) }}"
                href="{{ route('admin.faq.index') }}"><i class="app-menu__icon fa fa-cogs"></i>
                <span class="app-menu__label">Faq</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ request()->is('admin/forntendcollection*') ? 'active' : '' }} {{ sidebar_open(['admin.forntendcollection']) }}"
                href="{{ route('admin.forntendcollection.index') }}"><i class="app-menu__icon fa fa-cogs"></i>
                <span class="app-menu__label">Collection</span>
            </a>
        </li>
      </li>
        </div>
         <li>
            <a class="app-menu__item {{ request()->is('admin/contact-form*') ? 'active' : '' }} {{ sidebar_open(['admin.contact-form']) }}" href="{{ route('admin.contact-form.index') }}"><i class="app-menu__icon fa fa-handshake-o"></i>
            <span class="app-menu__label">Contact Form</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ request()->is('admin/email-subscription*') ? 'active' : '' }} {{ sidebar_open(['admin.email-subscription']) }}" href="{{ route('admin.email-subscription.index') }}"><i class="app-menu__icon fa fa-handshake-o"></i>
            <span class="app-menu__label">Subscription</span>
            </a>
        </li>
         <li class="text-light" data-toggle="collapse" data-target="#collapseSix" aria-expanded="true"
            aria-controls="collapseSix">
            <a href="#" class="app-menu__item @if (request()->is('admin/query*') || request()->is('admin/query*')) {{ 'active' }} @endif">
                <span class="app-menu__label">Query</span>
                <i class="app-menu__icon fa fa-chevron-down"></i>
            </a>
        </li>
        <!------  TICKET  -------->
        <div id="collapseSix" class="collapse @if (request()->is('admin/query*')) {{ 'show' }} @endif"
            aria-labelledby="headingOne" data-parent="#accordion">

            <li>
                <a class="app-menu__item {{ request()->is('admin/query/catagory*') ? 'active' : '' }}"
                    href="{{ route('admin.query.catagory.index') }}">
                    <i class="app-menu__icon fa fa-cubes"></i>
                    <span class="app-menu__label">Query Catagory</span>
                </a>
            </li>
            <li>
                <a class="app-menu__item {{ request()->is('admin/query*') ? 'active' : '' }}"
                    href="{{ route('admin.query.index') }}">
                    <i class="app-menu__icon fa fa-cubes"></i>
                    <span class="app-menu__label">User Queries</span>
                </a>
            </li>
        </div>
        <!--------- Help ------------>
         <li class="text-light" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="true"
            aria-controls="collapseSeven">
            <a href="#" class="app-menu__item @if (request()->is('admin/helpcategory*') || request()->is('admin/helpsubcategory*')|| request()->is('admin/userhelp*')) {{ 'active' }} @endif">
                <span class="app-menu__label">Help</span>
                <i class="app-menu__icon fa fa-chevron-down"></i>
            </a>
        </li>
        <div id="collapseSeven" class="collapse @if (request()->is('admin/helpcategory*')) {{ 'show' }} @endif"
            aria-labelledby="headingOne" data-parent="#accordion">
            <li>
                <a class="app-menu__item {{ request()->is('admin/helpcategory*') ? 'active' : '' }}"
                    href="{{ route('admin.helpcategory.index') }}">
                    <i class="app-menu__icon fa fa-cubes"></i>
                    <span class="app-menu__label">Category</span>
                </a>
            </li>
            <li>
                <a class="app-menu__item {{ request()->is('admin/helpsubcategory*') ? 'active' : '' }}"
                    href="{{ route('admin.helpsubcategory.index') }}">
                    <i class="app-menu__icon fa fa-cubes"></i>
                    <span class="app-menu__label">SubCatagory</span>
                </a>
            </li>
            <li>
                <a class="app-menu__item {{ request()->is('admin/userhelp*') ? 'active' : '' }}"
                    href="{{ route('admin.userhelp.index') }}">
                    <i class="app-menu__icon fa fa-cubes"></i>
                    <span class="app-menu__label">Help Article</span>
                </a>
            </li>
        </div>
        <!----user suggestion ----->
        <li>
            <a class="app-menu__item {{ sidebar_open(['admin/user-suggestion*']) }}"
                href="{{ route('admin.user-suggestion.index') }}">
                <i class="app-menu__icon fa fa-cubes"></i>
                <span class="app-menu__label">User Suggestion</span>
            </a>
        </li>

    </div>
     <!----- Demo Image ------>
        <li>
            <a class="app-menu__item {{ sidebar_open(['admin.demo-image*']) }}"
                href="{{ route('admin.demo-image.index') }}"><i class="app-menu__icon fa fa-cogs"></i>
                <span class="app-menu__label"> Placeholder Image</span>
            </a>
       </li>
        <!----- Settings ------>
        <li>
            <a class="app-menu__item {{ sidebar_open(['admin.settings*']) }}"
                href="{{ route('admin.settings.index') }}"><i class="app-menu__icon fa fa-cogs"></i>
                <span class="app-menu__label"> Settings</span>
            </a>
       </li>

        <!---  Council --->
         <li>
            <a class="app-menu__item {{ request()->is('admin/council*') ? 'active' : '' }} {{ sidebar_open(['admin.council']) }}" href="{{ route('admin.council.index') }}"><i class="app-menu__icon fa fa-handshake-o"></i>
            <span class="app-menu__label">Council</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ request()->is('admin/advocate*') ? 'active' : '' }} {{ sidebar_open(['admin.advocate']) }}" href="{{ route('admin.advocate.index') }}"><i class="app-menu__icon fa fa-handshake-o"></i>
            <span class="app-menu__label">Advocate</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ request()->is('admin/event-organiser*') ? 'active' : '' }} {{ sidebar_open(['admin.event-organiser']) }}" href="{{ route('admin.event-organiser.index') }}"><i class="app-menu__icon fa fa-handshake-o"></i>
            <span class="app-menu__label">Event Organiser</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ request()->is('admin/seo') ? 'active' : '' }} {{ sidebar_open(['admin.seo']) }}" href="{{ route('admin.seo.index') }}"><i class="app-menu__icon fa fa-handshake-o"></i>
            <span class="app-menu__label">SEO</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ request()->is('admin/email') ? 'active' : '' }} {{ sidebar_open(['admin.email.master']) }}" href="{{ route('admin.email.master.index') }}"><i class="app-menu__icon fa fa-envelope"></i>
            <span class="app-menu__label">Email master</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ request()->is('admin/job/scrap') ? 'active' : '' }} {{ sidebar_open(['admin.job.scrap.index']) }}" href="{{ route('admin.job.scrap.index') }}"><i class="app-menu__icon fa fa-database"></i>
            <span class="app-menu__label">Job Scrap</span>
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

