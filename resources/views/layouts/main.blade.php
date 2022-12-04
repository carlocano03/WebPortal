@extends('layouts/index')
@section('content')
<style type="text/css">
 /* @media screen and (min-width: 320px) and (max-width: 767px) and (orientation: portrait) {
  html {
    transform: rotate(-90deg);
    transform-origin: left top;
    width: 100vh;
    height: 100vw;
    
    position: absolute;
    top: 100%;
    left: 0;
  }
}*/
</style>
<div class="mp-dashboard">
  <div class="mp-dashboard__topbar">
    @include('layouts.header')
  </div>
  <div class="mp-dashboard__body">
    <div class="mp-dashboard__nav" style="overflow: visible;">
      @include('layouts.nav')
    </div>
    <div class="mp-dashboard__content mp-bg {{ getUserdetails()->usertype=='admin' ? 'mp-bg--admin' : 'mp-bg--member' }} mp-bg--member mp-bg--dashboard">
      @section('content_body')
      @show
    </div>
  </div>
</div>
@endsection
