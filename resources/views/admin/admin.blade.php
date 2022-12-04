@extends('layouts/main')
@section('content_body')
<style type="text/css">
  ul.pagination {
list-style-type:none;
margin:0;
padding:0;
text-align:center;
}

ul.pagination li {
display:inline;
padding:2px 5px 0;
text-align:center;
}

ul.pagination li a {
padding:2px;
}
</style>
  <div class="container mp-container">
    <div class="row no-gutters mp-mt5">
      <div class="col-12 mp-ph2 mp-pv2 mp-text-fs-large mp-text-c-accent">
        Admins
      </div>
    </div>
    <div class="row no-gutters mp-mb4">
      <div class="col-12 mp-ph2 mp-pv2">
        <div class="row no-gutters">
          <div class="col">
            <div class="mp-ph4 mp-pv4 mp-card">
              <div class="row no-gutters mp-search-header">
              
                <div class="col-lg-8 col-md-4 d-sm-none d-md-block"></div>
                <div class="col-lg-4 col-md-8 col-sm-12 mp-pb3 mp-input-search__container">
                    <div class="mp-input-search__input_div">
                     
                       
                        <input class="mp-input-search__input" type="text" id="search" placeholder="Search" value="{{ isset($_GET['q']) ? $_GET['q'] : '' }}"/>

                    </div>
                      <button class="mp-input-search__button mp-button mp-button--accent" id="search_btn_albums" type="button">  <i class="mp-icon icon-magnifier mp-text-c-white mp-text-fw-xheavy mp-text-fs-large"></i></button>
                      <a class="mp-pl3 mp-input-add__link" href="{{url('/admin/add' )}}">
                    <i class="mp-icon icon-user-follow mp-text-c-primary mp-text-fs-xlarge"></i>
                  </a>
                  
                  </div>

              </div>
              <div class="mp-overflow-x">
                <table class="mp-table mp-text-fs-small">
                  <thead>
                    <tr>
                      <th>
                        Name
                      </th>
                      <th>
                        Email
                      </th>
                      <th>
                        Role
                      </th>
                      <th>
                        Cluster
                      </th>
                      <th>
                        Created
                      </th>  
                    </tr>
                  </thead>
                  <tbody>
                   @foreach($admins as $admin)
                      <tr>
                        <td>{{ $admin->last_name.', '.$admin->first_name.' '.$admin->middle_name}}</td>
                        <td >
                          {{ $admin->email}}
                        </td>
                        <td>{{ $admin->role }}</td>
                        <td>{{ $admin->name }}</td>
                        <td>{{ date("Y-m-d", strtotime($admin->created_at)) }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
                @if(isset($_GET['q']))
                {!! $admins->appends(['q' => $_GET['q']])->links('pagination.default') !!} 
                @else
                {!! $admins->links('pagination.default') !!}
                @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')   
 <script type="text/javascript">

      $('#search_btn_albums').click(function(){
        keyword = $('#search').val();        
        location.href = "manage-admin?q="+keyword;
      });
    </script>
@endsection
