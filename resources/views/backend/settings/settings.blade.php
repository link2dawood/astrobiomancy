@section('title', 'Settings') 
@include('backend.includes.head')
<body scroll-spy="" id="top" class=" theme-template-dark theme-pink alert-open alert-with-mat-grow-top-right">
  <style>
.modal-dialog {
  padding-top:10%;
}
.modal-backdrop {
    
}
.select2-container--focus{
	box-shadow:inset 0 -3px 0 #e91e63;
}
.select2-container{
	width:100% !important;
}
</style>
<meta name="csrf-token" content="{{ csrf_token() }}" />

  <main>
	@include('backend.includes.sidebar')
     <div class="main-container">
		@include('backend.includes.header')
	<div class="main-container">
        <div class="main-content" autoscroll="true" bs-affix-target="" init-ripples="" style="padding-top:0px">
          <section class="forms-basic">
            <div id="errorwhileaddinguser" class="modal " tabindex="-1" >
					<div class="modal-dialog modal-confirm" style="" >
					
						<div class="modal-content">
							<div class="modal-header" style="padding-bottom: 0px;">
								<div class="icon-box" style="border:3px solid #e91e63;">
									<i class="md md-warning" style="font-size: 44px;font-weight: 1000;margin-top: 0px;color: #e91e63!important;bottom: 5px;padding-top: -36px !important;padding-bottom: -3px;margin-bottom: -12px;padding: -6px;padding-bottom: 6px;"></i>
								</div>		
								<h4 class="modal-title" style="margin-top: 6px;">{{session()->get('error')}}</h4>	
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							</div>
							<div class="modal-body">
								<p style="margin: 0px;"></p>
							</div>
							<div class="modal-footer" style="padding-bottom:0px">
								<button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
							</div>
						</div>
					</div>
				</div>
       <div class="row  m-b-40">
              
       <div class="col-md-12">
       <div class="well white">

				<form action="{{ url('dashboard/settings_save') }}" method="POST" enctype="multipart/form-data">


				{{ Form::input('hidden', '_token',csrf_token(), ['class' => 'form-control', 'id' => '', ]) }}
				 <div class="form-floating">
				
				<!-- Modal HTML -->
				<div id="myModal" class="modal " tabindex="-1" >
					<div class="modal-dialog modal-confirm" style="">
						<div class="modal-content">
							<div class="modal-header" style="padding-bottom: 0px;">
								<div class="icon-box" style="border:3px solid #28a745;">
									<i class="md md-check" style="font-size: 44px;font-weight: 1000;margin-top: 0px;color: #28a745!important;bottom: 5px;padding-top: -36px !important;padding-bottom: -3px;margin-bottom: -12px;padding: -6px;padding-bottom: 6px;"></i>
								</div>					
								<h4 class="modal-title" style="margin-top: 6px;">Saved!</h4>	
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							</div>
							<div class="modal-body">
								<p style="margin: 0px;">Data Saved Successfully</p>
							</div>
							<div class="modal-footer" style="padding-bottom:0px">
								<button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
							</div>
						</div>
					</div>
				</div>
				
				<fieldset>
           <legend>Settings</legend> 
						<div class="row">
							<div class="col-md-3">
							<div class="form-group" >
									<label for="inputEmail" class="control-label" style="margin-left: 13%;">Enable Blog</label>
									@if (isset($settings->enable_blog) && $settings->enable_blog==='1')
									{{ Form::input('checkbox', 'enable_blog','1', ['checked'=>'checked']) }}
									@else
									{{ Form::input('checkbox', 'enable_blog','1', []) }}
									@endif
							</div>
							</div>
							<div class="col-md-3">
							<div class="form-group" >
									<label for="inputEmail" class="control-label">Admin Email</label>
									{{ Form::input('text', 'admin_email',$settings->admin_email, ['class'=>'form-control']) }}

							</div>
							</div>
							<div class="col-md-3">
							<div class="form-group" >
									<label for="inputEmail" class="control-label">Facebook Link</label>
									{{ Form::input('text', 'facebook_link',$settings->facebook_link, ['class'=>'form-control']) }}

							</div>
							</div>
							<div class="col-md-3">
							<div class="form-group" >
									<label for="inputEmail" class="control-label" >Twitter Link</label>
									{{ Form::input('text', 'twitter_link',$settings->twitter_link, ['class'=>'form-control']) }}

							</div>
							</div>
							<div class="col-md-3">
							<div class="form-group" >
									<label for="inputEmail" class="control-label">Instagram Link</label>
									{{ Form::input('text', 'instagram_link',$settings->instagram_link, ['class'=>'form-control']) }}

							</div>
							</div>
							<div class="col-md-12">
							<div class="form-group" >
									<label for="inputEmail" class="control-label">Stripe</label>
									{{ Form::input('text', 'stripe_text',$settings->stripe_text, ['class'=>'form-control']) }}

							</div>
							</div>
							<div class="col-md-6">
							<div class="form-group" >
									<label for="inputEmail" class="control-label">Client Message Length </label>
									{{ Form::input('text', 'client_message_length',$settings->client_message_length, ['class'=>'form-control']) }}

							</div>
							</div>
							<div class="col-md-6">
							<div class="form-group" >
									<label for="inputEmail" class="control-label">Admin Message Length </label>
									{{ Form::input('text', 'admin_message_length',$settings->admin_message_length, ['class'=>'form-control']) }}

							</div>
							</div>
							<div class="col-md-6">
							<div class="form-group" >
									<label for="inputEmail" class="control-label">Max # of Files For Question</label>
									{{ Form::input('number', 'max_num_of_files',$settings->max_num_of_files, ['class'=>'form-control']) }}

							</div>
							</div>
						</div>
						</div>
					
					  <div class="form-group" >
					
						<button type="submit" name="save_exist" value="save_exist" class="btn btn-sm btn-primary">Save</button>
						
            </div>
            </fieldset>
                  </div>
				  {{ Form::close() }}
                </div>
              </div>
            </div>
		 </section>
        </div>
      </div>
	 </div>
    </main>
    <style>
    .glyphicon-spin-jcs {
      -webkit-animation: spin 1000ms infinite linear;
      animation: spin 1000ms infinite linear;
    }
    
    @-webkit-keyframes spin {
      0% {
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
      }
      100% {
        -webkit-transform: rotate(359deg);
        transform: rotate(359deg);
      }
    }
    
    @keyframes spin {
      0% {
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
      }
      100% {
        -webkit-transform: rotate(359deg);
        transform: rotate(359deg);
      }
    }
    </style>
    
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
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
    ga('create', 'UA-62479268-1', 'auto');
    ga('send', 'pageview');
	
	
    </script>
    
	<script charset="utf-8" src="{{url('public/asserts/js/vendors.min.js')}}"></script>
    <script charset="utf-8" src="{{url('public/asserts/js/app.min.js')}} "></script>
  </body>
</html>
<script src="https://cdn.tiny.cloud/1/i1klei5i485h8ijgmj8q78rbugybwoq5i98egx3u3ofngezi/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
$('form input').keydown(function (e) {
    if (e.keyCode == 13) {
        e.preventDefault();
        return false;
    }
});
@if(session()->has('error'))
	$('#errorwhileaddinguser').modal('show');
@endif
$('.select2').select2();
 tinymce.init({
    selector: 'textarea#description',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
  });

</script>

@include('backend.includes.footer')