<div class="mp-header">
  
  <div class="mp-header__logo">
    <a href="/">
      <img src="{!! asset('assets/images/uppfi-logo-sm.png') !!}" alt="UPPFI">
    </a>
  </div>
  <div class="mp-header__title">
    <a class="mp-link mp-link--accent" href="/">
     University of the Philippines Provident Fund Inc.
    </a>
  </div>
  <div class="mp-header__mobile-menu-toggle" align="right" style="float:right!important">
    <a class="mp-link mp-link--accent"  style="font-size: 12px; padding-right: 0px!important;" href="{{ url('/logout') }}">
            <strong>Log out</strong>
          </a>
  </div>
  <div class="mp-header__options">
   @include('layouts.profileTag')
  </div>
  @include('layouts.mainMenu')
</div>
