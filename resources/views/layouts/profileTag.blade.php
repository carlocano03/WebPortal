<div class="mp-profile-tag ">

  <div class="mp-profile-tag__info">
    <div class="mp-profile-tag__name">
      {{ getUserdetails()->last_name }}, {{ getUserdetails()->first_name}}
    </div>
    <div class="mp-profile-tag__meta">
       @if(getUserdetails()->usertype=='member')
      <div class="mp-profile-tag__campus">
      {{ getUserdetails()->campus_name }}
      </div>
      <div class="mp-profile-tag__position">
        {{ getUserdetails()->position_id }}
      </div>
       @elseif(getUserdetails()->usertype=='admin')
     <div class="mp-profile-tag__campus">
      {{ getUserdetails()->name }}
      </div>
      <div class="mp-profile-tag__position">
        {{ ucwords(strtolower(str_replace('_',' ', getUserdetails()->role))) }}
      </div>
       @endif
        <div class="mp-profile-tag__position">
          <a class="mp-link mp-link--accent" href="{{ url('/logout') }}">
            <strong>Log out</strong>
          </a>
      </div>
    </div>
  </div>
    @if(getUserdetails()->usertype=='member')
  <div class="">
    <img src="{!! asset('assets/images/user-default.png') !!}" alt="UPPFI">
  </div>
  @else
  <div class="mp-profile-tag__photo">
    <img src="{!! asset('assets/images/user-default.png') !!}" alt="UPPFI">
  </div>
  @endif


</div>

