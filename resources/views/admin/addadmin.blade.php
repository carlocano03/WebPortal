@extends('layouts/main')
@section('content_body')
  <div class="container mp-container">
    <div class="row no-gutters mp-mt4 justify-content-center">
      <div class="col-12 col-lg-6 mp-ph2 mp-pv2">
        <div class="mp-pt4 mp-text-fs-large mp-text-c-accent">
           <a href="{{ url('/admin/manage-admin') }}" class="mp-link mp-link--accent">
            <i class="mp-icon icon-arrow-left mp-mr1 mp-text-fs-medium"></i>
            <span class="mp-text-fs-large">Back to Admins</span>
          </a>
        </div>
      </div>
    </div>
    <div class="row no-gutters mp-mb4 justify-content-center">
      <div class="col-12 col-lg-6 mp-ph2 mp-pv2">
        <div class="mp-ph4 mp-pv4 mp-card mp-card--plain">
          <div class="mp-text-fs-small {{ Session::has('error') or Session::has('success') ? 'mp-mb4' : '' }}">
            @if(Session::has('error'))
            <span style="color:red"><strong>{{ Session::get('error') }}</strong></span>
            @endif
            @if(Session::has('success'))
            <span style="color:green"><strong>{{ Session::get('success') }}</strong></span>
            @endif
          </div>
        
       {{ Form::open(array('url' => '/admin/save', 'method' => 'post')) }}

           <div class="mp-pb4 mp-input-group">
              <label class="mp-input-group__label" for="lastName">
                Last Name
              </label>
              <input 
                class="mp-input-group__input mp-text-field" 
                type="text" 
                id="lastName" 
                name="lastName"
                autofocus 
                required 
              />
            </div>
            <div class="mp-pb4 mp-input-group">
              <label class="mp-input-group__label" for="First Name">
                First Name
              </label>
              <input 
                class="mp-input-group__input mp-text-field" 
                type="text" 
                id="firstName" 
                name="firstName"
                required 
              />
            </div>
            <div class="mp-pb4 mp-input-group">
              <label class="mp-input-group__label" for="email">
                Email
              </label>
              <input 
                class="mp-input-group__input mp-text-field" 
                type="email" 
                id="email" 
                name="email"
                required 
              />
            </div>
            <div class="mp-pb4 mp-input-group">
              <label class="mp-input-group__label" for="role">
                Role
              </label>
              <select 
                class="mp-input-group__input mp-select-field" 
                id="role" 
                name="role"
                required 
              >
                <option value="SUPER_ADMIN">Super Admin</option>
                <option value="CLUSTER_ADMIN">Cluster Admin</option>
              </select>
            </div>
            <div id="clusterBlock" style="display: none;" class="mp-pb4 mp-input-group">
              <label class="mp-input-group__label" for="cluster">
                Cluster
              </label>
              <select 
                class="mp-input-group__input mp-select-field" 
                id="cluster" 
                name="cluster"
                required 
              >
                
                @foreach($clusters as $cluster)
                  <option value="{{$cluster->id}}">
                    {{$cluster->name}}
                  </option>
               @endforeach
              </select>
            </div>
            <div class="mp-pt3 row justify-content-end align-items-center">
              <div class="col col-auto">
                <button type="submit" class="mp-button mp-button--accent">Create Admin</button>
              </div>
            </div>
          {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
<script src="{{ asset('/dist/adminsAdd.js') }}"></script>
@endsection
