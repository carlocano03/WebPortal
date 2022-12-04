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
        Members
      </div>
    </div>
    <div class="row no-gutters mp-mb4">
      <div class="col-12 mp-ph2 mp-pv2">
        <div class="row no-gutters">
          <div class="col">
            <div class="mp-ph4 mp-pv4 mp-card">
                
                <div class="mp-text-right">
                   @if(getUserdetails()->role=='SUPER_ADMIN')
                    <a href="{{url('/admin/summary')}}" class="mp-link mp-link--normal" >Generate Summary Report</a> &nbsp;&nbsp;&nbsp;&nbsp;
                     @endif
                     <!-- <a href="{{url('/admin/add_member')}}" class="mp-link mp-link--normal" >Add New Member</a> -->
                  </div>
                 
              <div class="row no-gutters mp-search-header">
              
                <div class="col-lg-8 col-md-4 d-sm-none d-md-block"></div>
                <div class="col-lg-4 col-md-8 col-sm-12 mp-pb3 mp-input-search__container">
                    <div class="mp-input-search__input_div">
                     
                       
                        <input class="mp-input-search__input" type="text" id="search" placeholder="Search" value="{{ isset($_GET['q']) ? $_GET['q'] : '' }}"/>

                    </div>
                      <button class="mp-input-search__button mp-button mp-button--accent" id="search_btn_albums" type="button">  <i class="mp-icon icon-magnifier mp-text-c-white mp-text-fw-xheavy mp-text-fs-large"></i></button>
                  
                  </div>

              </div>
              <div class="mp-overflow-x">
                <table class="mp-table mp-text-fs-small">
                  <thead>
                    <tr>
                      <th>
                        Member ID
                      </th>
                      <th>
                        Member Name
                      </th>
                      <th class="mp-text-center">
                        Membership Date
                      </th>
                      <th>
                        Campus
                      </th>
                      <th>
                        Class
                      </th>
                      <th>
                        Position
                      </th>
                      <th>
                        Created
                      </th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                   @foreach($members as $member)
                  
                      <tr>
                        <td>{{ $member->member_no }}</td>
                        <td class="mp-text-fw-heavy">
                          {{ $member->last_name.', '.$member->first_name.' '.$member->middle_name}}
                        </td>
                        <td class="mp-text-center">{{ date("m/d/y", strtotime($member->memdate)) }}</td>
                        <td>{{ $member->campus }}</td>
                        <td>{{ $member->department }}</td>
                        <td>{{ $member->position_id }}</td>
                        <td>{{ date("Y-m-d", strtotime($member->created_at)) }}</td>
                        <td class="mp-text-right">
                          <a data-md-tooltip="View Member" href="{{url('/admin/member_soa/'.$member->id)}}">
                            <i class="mp-icon md-tooltip icon-book-open mp-text-c-primary mp-text-fs-large"></i>
                          </a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
                @if(isset($_GET['q']))
                {!! $members->appends(['q' => $_GET['q']])->links('pagination.default') !!} 
                @else
                {!! $members->links('pagination.default') !!}
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
        location.href = "members?q="+keyword;
      });
    </script>
@endsection
