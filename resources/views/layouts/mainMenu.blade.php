
<div class="mp-main-menu">
  <div class="mp-main-menu__overlay"></div>
  <div class="mp-main-menu__content">
    <ul class="mp-main-menu__list">
        @if(getUserdetails()->usertype=='admin')
     
        <li class="mp-main-menu__item">
          <a class="mp-link" href="{{ url('/admin/update-password/') }}">
            <i class="mp-icon icon-settings"></i>
            <span>Update Password</span>
          </a>
        </li>
        @if(getUserdetails()->role=='SUPER_ADMIN')
         <li class="mp-main-menu__item">
          <a class="mp-link" href="{{ url('/admin/manage-admin') }}">
            <i class="mp-icon icon-lock"></i>
            <span>Manage Admins</span>
          </a>
        </li>
        @endif

   <!--      <li class="mp-main-menu__item">
          <a class="mp-link" href="{{ url('/logout') }}">
            <i class="mp-icon icon-power"></i>
            <span>Log out</span>
          </a>
        </li> -->
        @endif


      
    </ul>
  </div>
</div>
