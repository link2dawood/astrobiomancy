@section('title', 'Login') 
@include('backend.includes.head')
  <body class="page-login" init-ripples="">
    <div class="center">
      <div class="card bordered z-depth-2" style="margin:0% auto; max-width:400px;">
        <div class="card-header" style="margin: 0px;padding: 0px;">
          <div class="brand-logo">
            <div id="">
             
            </div> 
             </div>
        </div>
        <div class="card-content">
          <div class="m-b-30">
            <div class="card-title strong pink-text" style="color:#ba9456">Login</div>
            <p class="card-title-desc"> Welcome to dashboard! </p>
          </div>
          @if(session()->has('message'))
			<div class="alert alert-danger">
				{{ session()->get('message') }}
			</div>
			@endif
			{{ Form::open(array('url' => '/login_action')) }}
            <div class="form-group">
              <label for="inputEmail" class="control-label">Email</label>
              	{{ Form::input('hidden', '_token',csrf_token(), ['class' => 'form-control', 'id' => '', ]) }}
				{{ Form::input('text', 'email', '', ['placeholder'=>'Email Address','class' => 'form-control','required'=>'required'])}}
			  </div>
            <div class="form-group">
              <label for="inputPassword" class="control-label">Password</label>
              {{ Form::input('password', 'password', '', ['placeholder'=>'Password','class' => 'form-control','required'=>'required']) }}
			  </div>
           
        </div>
        <div class="card-action clearfix">
          <div class="pull-right">
			 {{ Form::input('submit', 'Login', 'Login', ['class' => 'btn btn-link black-text']) }}
	      </div>
        </div>
		 {{ Form::close() }}
      </div>
    </div>
    
    <script>
    (function(i, s, o, g, r, a, m)
    {
      i['GoogleAnalyticsObject'] = r;
      i[r] = i[r] || function()
      {
        (i[r].q = i[r].q || []).push(arguments)
      }, i[r].l = 1 * new Date();
      a = s.createElement(o), m = s.getElementsByTagName(o)[0];
      a.async = 1;
      a.src = g;
      m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
    ga('create', 'UA-62479268-1', 'auto');
    ga('send', 'pageview');
    </script>
    
    <script charset="utf-8" src="{{url('public/asserts/js/vendors.min.js')}}"></script>
    <script charset="utf-8" src="{{url('public/asserts/js/app.min.js')}} "></script>
  </body>
</html>
