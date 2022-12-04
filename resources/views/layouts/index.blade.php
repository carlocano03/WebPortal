<!DOCTYPE html>
<html lang="en">
<head>
   <meta name="csrf-token" content="{!! csrf_token() !!}">
  <meta content="text/html; charset=utf-8">
  <meta name="keywords" content="UP Provident Fund Inc. Members Portal">
  <meta name="description" content="UP Provident Fund Inc. Members Portal">
  <meta name="author" content="White Widget">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

 
<link href="//cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css" rel="stylesheet">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link href="{!! asset('dist/style.css') !!}" rel="stylesheet">
<link href="{!! asset('dist/font-awesome-4.7.0/css/font-awesome.min.css') !!}" rel="stylesheet">
<link href="{!! asset('dist/select2-4.0.13/css/select2.min.css') !!}" rel="stylesheet">
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"></script>  
<script>
  WebFont.load({
    google: {
      families: ['Fira Sans:300,400,500,600,700']
    }
  });
</script>
<script src="{{ asset('/dist/vendor.js') }}"></script>
<script src="{{ asset('/dist/dashboard.js') }}"></script>
<script src="{{ asset('/dist/select2-4.0.13/js/select2.min.js') }}"></script>


 



</head>
<body id="uppfi">
   @section('content')
   @show
   @yield('scripts')
</body>
</html>