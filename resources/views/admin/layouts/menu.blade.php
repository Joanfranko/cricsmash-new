<!-- Horizontal-menu -->
<div class="horizontal-main hor-menu clearfix">
    <div class="horizontal-mainwrapper container clearfix">
        <nav class="horizontalMenu clearfix">
            <ul class="horizontalMenu-list">
                <li aria-haspopup="true"><a href="{{ route('admin.dashboard') }}" class="sub-icon @if(Route::current()->getName() == 'admin.dashboard') active @endif"> Dashboard </a></li>
                @role('SuperAdmin')
                    <li aria-haspopup="true"><a href="{{ route('admin.roles') }}" class="sub-icon @if(Route::current()->getName() == 'admin.roles') active @endif"> Roles </a></li> 
                    <li aria-haspopup="true"><a href="{{ route('admin.permissions') }}" class="sub-icon @if(Route::current()->getName() == 'admin.permissions') active @endif"> Permissions </a></li>
                    <li aria-haspopup="true"><a href="{{ route('admin.users') }}" class="sub-icon @if(Route::current()->getName() == 'admin.users') active @endif"> Users </a></li>
                @endrole
                <li aria-haspopup="true"><a href="{{ route('admin.category') }}" class="sub-icon @if(Route::current()->getName() == 'admin.category') active @endif"> Category </a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.news') }}" class="sub-icon @if(Route::current()->getName() == 'admin.news') active @endif"> News </a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.reference') }}" class="sub-icon @if(Route::current()->getName() == 'admin.reference') active @endif"> Reference </a></li>
                <li aria-haspopup="true"><a href="{{ route('admin.notification') }}" class="sub-icon @if(Route::current()->getName() == 'admin.notification') active @endif"> Notification </a></li>
            </ul>
        </nav>
        <!--Nav end -->
    </div>
</div>
<!-- Horizontal-menu end -->