<!--app-header-->
<div class="app-header header hor-topheader d-flex">
    <div class="container">
        <div class="d-flex">
            <a class="header-brand" href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('assets/images/brand/logo.png') }}" class="header-brand-img main-logo" alt="Hogo logo">
                <img src="{{ asset('assets/images/brand/icon.png') }}" class="header-brand-img icon-logo" alt="Hogo logo">
            </a><!-- logo-->
            <a id="horizontal-navtoggle" class="animated-arrow hor-toggle"><span></span></a>
            <a href="#" data-toggle="search" class="nav-link nav-link  navsearch"><i class="fa fa-search"></i></a><!-- search icon -->
            
            <div class="d-flex order-lg-2 ml-auto header-rightmenu">
                <div class="dropdown">
                    <a  class="nav-link icon full-screen-link" id="fullscreen-button">
                        <i class="fe fe-maximize-2"></i>
                    </a>
                </div><!-- full-screen -->

                <div class="dropdown header-user">
                    <a class="nav-link leading-none siderbar-link"  data-toggle="sidebar-right" data-target=".sidebar-right">
                        <span class="mr-3 d-none d-lg-block ">
                            <span class="text-gray-white"><span class="ml-2">{{ Auth::user()->name }}</span></span>
                        </span>
                        <span class="avatar avatar-md brround"><img src="{{ asset('assets/images/users/1.png') }}" alt="Profile-img" class="avatar avatar-md brround"></span>
                    </a>
                </div><!-- profile -->
                <div class="dropdown">
                </div><!-- Right-siebar-->
            </div>
        </div>
    </div>
</div>
<!--app-header end-->

<div class="sidebar sidebar-right sidebar-animate">
    <div class="tab-menu-heading siderbar-tabs border-0">
        <div class="tabs-menu ">
            <!-- Tabs -->
            <ul class="nav panel-tabs">
                <li class=""><a href="#tab"  class="active" data-toggle="tab">Profile</a></li>
            </ul>
        </div>
    </div>
    <div class="panel-body tabs-menu-body side-tab-body p-0 border-0 ">
        <div class="tab-content border-top">
            <div class="tab-pane active " id="tab">
                <div class="card-body p-0">
                    <div class="header-user text-center mt-4 pb-4">
                        <span class="avatar avatar-xxl brround"><img src="{{ asset('assets/images/users/1.png') }}" alt="Profile-img" class="avatar avatar-xxl brround"></span>
                        <div class="dropdown-item text-center font-weight-semibold user h3 mb-0">{{ Auth::user()->first_name }}</div>
                        <?php /* <small>{{ Auth::user()->roles->first()->name }}</small> */?>
                        <small>Admin</small>
                    </div>
                    <div class="card-body border-top">
                        <div class="row">
                            <div class="col-4 text-center">
                                <a class="" href="javascript:;"><i class="dropdown-icon mdi  mdi-message-outline fs-30 m-0 leading-tight"></i></a>
                                <div>Inbox</div>
                            </div>
                            <div class="col-4 text-center">
                                <a class="" href="javascript:;"><i class="dropdown-icon mdi mdi-tune fs-30 m-0 leading-tight"></i></a>
                                <div>Settings</div>
                            </div>
                            <div class="col-4 text-center">
                                <?php /*<a class="" href="javascript:;"><i class="dropdown-icon mdi mdi-logout-variant fs-30 m-0 leading-tight"></i></a>
                                <div>Sign out</div> */ ?>
                                <a class="" href="javascript:;"
                                   onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();"><i class="dropdown-icon mdi mdi-logout-variant fs-30 m-0 leading-tight"></i>
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- End Rightsidebar-->