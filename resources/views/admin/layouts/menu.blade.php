<!-- Horizontal-menu -->
<div class="horizontal-main hor-menu clearfix">
    <div class="horizontal-mainwrapper container clearfix">
        <nav class="horizontalMenu clearfix">
            <ul class="horizontalMenu-list">
                <li aria-haspopup="true"><a href="{{ route('admin.dashboard') }}" class="sub-icon @if(Route::current()->getName() == 'admin.dashboard') active @endif"> Dashboard </a></li>
                <li aria-haspopup="true"><a href="#" class="sub-icon"> Category </a></li>
            </ul>
        </nav>
        <!--Nav end -->
    </div>
</div>
<!-- Horizontal-menu end -->