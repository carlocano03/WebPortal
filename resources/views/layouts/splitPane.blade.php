@extends('layouts/index')
@section('content')
<div class="mp-split-pane">
  <div class="mp-split-pane__left">
    <div class="container-fluid mp-pt3 mp-pb5 mp-mvauto mp-mhauto">
      <div class="row align-items-center justify-content-center">
        <div class="col-12 col-sm-10">
           @section('left')
            @show
        </div>
      </div>
    </div>
  </div>
  <div class="mp-split-pane__right">
@section('right')
@show
  </div>
</div>
@endsection