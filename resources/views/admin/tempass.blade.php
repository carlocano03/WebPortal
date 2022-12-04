@extends('layouts/main')
@section('content_body')
<div class="container mp-container">
  <div class="row no-gutters mp-mt5">
    <div class="col-12 mp-ph2 mp-pv2 mp-text-fs-large mp-text-c-accent">
      Download Temporary Passwords
    </div>
  </div>
 
  <div class="row no-gutters mp-mb4">
    <div class="col-12 mp-ph2 mp-pv2">

      <div class="row no-gutters">
        <div class="col">
          <div class="mp-pb4 mp-pv4 mp-card mp-card--tabbed" align="center">
            <table style="width:100%" class="mp-table mp-text-fs-small">
            <thead class="mp-text-fs-large" >
              <tr>
                <th style="text-align:center">Date Uploaded</th>
                <th style="text-align:center">Cluster</th>
                <th style="text-align:center">File</th>
              </tr>
            </thead>
            <tbody>
             @foreach($tempass as $temp)
          
              
              <tr>
                <td style="text-align:center"> {{date('M d, Y g:i:a', strtotime($temp->uploaded_date))}}</td>
                <td style="text-align:center"> {{$temp->name}}</td>
               <td style="text-align:center"><a href="{{ asset('storage/app/passwords/'.$temp->filename) }}" download> {{$temp->filename}}</a></td>
              </tr>
             @endforeach
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>
</div>
</div>
@endsection