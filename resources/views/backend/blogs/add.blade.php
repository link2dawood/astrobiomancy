@section('title', 'Add Post') 
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

				<form action="{{ url('dashboard/blog/post/add_action') }}" method="POST" enctype="multipart/form-data">


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
           <legend>Add Post</legend> 
						<div class="row">
							<div class="col-md-4">
							<div class="form-group" >
								<label for="inputEmail" class="control-label">Title</label>
									{{ Form::input('text', 'title','', ['class' => 'form-control', 'id' => '']) }}
							</div>
							</div>
							<div class="col-md-4">
							<div class="form-group" >
								<label for="inputEmail" class="control-label">Meta Keyword</label>
									{{ Form::input('text', 'meta_keyword','', ['class' => 'form-control', 'id' => '']) }}
							</div>
							</div>
							
							<div class="col-md-4" style="margin-top:10px">
							<div class="form-group" >
								<label for="inputEmail" class="control-label"></label>
									<select class="form-control select2" name="author_id">
											<option value="">Select Author</option>
											@foreach ($users as $user)
												<option value="{{$user->id}}">{{$user->name}}</option>
											@endforeach
									</select>
							</div>
							</div>
							<div class="col-md-4" style="margin-top:10px">
							<div class="form-group" >
								<label for="inputEmail" class="control-label"></label>
									<select class="form-control select2" name="category_id">
											<option value="">Select Category</option>
											@foreach ($category as $cat)
												<option value="{{$cat->id}}">{{$cat->name}}</option>
											@endforeach
									</select>
							</div>
							</div>
							<div class="col-md-4" style="margin-top:10px">
							<div class="form-group" >
								<label for="inputEmail" class="control-label"></label>
									<select class="form-control select2" name="status">
											<option value="">Select Status</option>
											<option value="Pending">Pending</option>
											<option value="Published">Published</option>
											
									</select>
							</div>
							</div>
							
							<div class="col-md-4" style="margin-top:15px">
							<div class="form-group" >
								<label for="inputEmail" class="control-label"></label>
									{{ Form::input('file', 'image','', []) }}
							</div>
							</div>
							<div class="col-md-12" style="margin-top:15px">
							<div class="form-group" >
								<textarea class="form-control" name="description" id="description" placeholder="Description"></textarea>
							</div>
							</div>

							<div class="col-md-3" style="margin-top:15px">
								<label class="control-label">Language</label>
								<select class="form-control" name="lang">
									@foreach($locales as $loc)
										<option value="{{ $loc }}">{{ strtoupper($loc) }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-5" style="margin-top:15px">
								<label class="control-label">Translation of</label>
								<select class="form-control select2" name="translation_of">
									<option value="">— None (this is an original post) —</option>
									@foreach($translation_parents as $p)
										<option value="{{ $p->id }}">[{{ strtoupper($p->lang) }}] {{ $p->title }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-4" style="margin-top:15px"></div>
							<div class="col-md-6" style="margin-top:15px">
								<label class="control-label">Meta Title</label>
								<input type="text" name="meta_title" class="form-control" maxlength="70" placeholder="Page title shown in search results">
							</div>
							<div class="col-md-6" style="margin-top:15px">
								<label class="control-label">Meta Description</label>
								<input type="text" name="meta_description" class="form-control" maxlength="160" placeholder="Search snippet, ~155 chars">
							</div>

						</div>
						</div>
					
					  <div class="form-group" >
					
						<button type="submit" name="save_exist" value="save_exist" class="btn btn-sm btn-primary">Save</button>
						<a href="{{url('dashboard/blog/post')}}" class="btn btn-sm btn-success" style="color:white">Back</a>
						
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