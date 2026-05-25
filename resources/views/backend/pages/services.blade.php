@section('title', 'Service ') 
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

				<form action="{{ url('/dashboard/services/save') }}" method="POST" enctype="multipart/form-data">


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
           <legend>Service</legend> 
						<div class="row">
							<div class="col-md-4">
							<div class="form-group" >
								<label for="inputEmail" class="control-label">Main Heading</label>
									{{ Form::input('text', 'main_heading', $services->main_heading, ['class' => 'form-control', 'id' => '']) }}
									{{ Form::input('hidden', 'id', $services->id, ['class' => 'form-control', 'id' => '']) }}
							</div>
							</div>
							<div class="col-md-4">
							<div class="form-group" >
								<label for="inputEmail" class="control-label">Second Heading</label>
									{{ Form::input('text', 'second_heading',$services->second_heading, ['class' => 'form-control', 'id' => '']) }}
							</div>
							</div>
							
							<div class="col-md-12" style="margin-top:15px">
							<div class="form-group" >
							<label for="inputEmail" class="control-label">Content</label>
								<textarea class="form-control" name="description" id="content" placeholder="Content">{{$services->description}}</textarea>
							</div>
							</div>
							<div class="col-md-12">
								<br>
								<button type="button" class="btn btn-primary add-row">Add</button>
								<br>
							</div>
						
							<div class=" append-data" style="margin-bottom: 20px;">
								@php
										$packages_details = json_decode($services->packages_details, true);
										$counter = 0;
								@endphp
								@if (isset($packages_details[0]))
								@foreach ($packages_details as $key=>$pkgdetails)
								@php
									$counter = $key; 
								@endphp
								<div class="row row-{{$key}}" style="margin:0px">
			
							 <div class="col-md-4 row-{{$key}}">
								<div class="form-group amt-data" style="margin: 0px;">
								<label for="inputEmail" class="control-label"></label>
								<input type="text" name="package_name[]" class=" form-control" placeholder="Package Name" value="{{@$pkgdetails['package_name']}}">

								<input type="hidden" name="package_id[]" class=" form-control" placeholder="Package Name" value="@if(isset($pkgdetails['package_id'])){{$pkgdetails['package_id']}}@else{{rand(100,100000)}}@endif">
								

							</div>
							</div>
							<div class="col-md-4 row-{{$key}}">
								<div class="form-group amt-data" style="margin: 0px;">
								<label for="inputEmail" class="control-label"></label>
								<input type="text" name="package_details[]" class=" form-control" placeholder="Details" value="{{$pkgdetails['package_details']}}">
							</div>
							</div>
							<div class="col-md-4 row-{{$key}}">
								<div class="form-group amt-data" style="margin: 0px;">
								<label for="inputEmail" class="control-label"></label>
								<input type="text" name="package_details_terms[]" class=" form-control" placeholder="Terms And Conditions" value="{{@$pkgdetails['package_details_terms']}}">
							</div>
							</div>
							<div class="col-md-6 row-{{$key}}">
								<br>
							<div class="form-group amt-data" style="margin-top: 10px;">
								<label for="inputEmail" class="control-label">Customer Ask Question</label>
								<br>
								<textarea  name="customer_ask_question_page[]" class=" form-control cs-ask-ques-pg">{{@$pkgdetails['customer_ask_question_page']}}</textarea>
							</div>
							</div>	
							<div class="col-md-2 row-{{$key}}">
							<div class="form-group amt-data" style="margin: 0px;">
								<label for="inputEmail" class="control-label"></label>
								<input type="number" name="number_of_question[]" class=" form-control" placeholder="Number Of Questions" value="{{$pkgdetails['number_of_question']}}">
							</div>
							</div>
											
							<div class="col-md-2 row-{{$key}}">
							<div class="form-group desc-data" style="margin: 0px;">
								<label for="inputEmail" class="control-label"></label>
								<input type="text" name="package_amount[]" class=" form-control" placeholder="Amount"  value="{{$pkgdetails['package_amount']}}">
							</div>
							</div>
							<div class="col-md-1 row-{{$key}}">
								<div class="form-group btns-extra" style="margin-top: 10px;">
									<button type="button" class="btn btn-sm btn-danger remove" data-id="{{$key}}" style="padding:5px">Remove</button>
								</div>
								</div>
								<div class="col-md-12">
									<hr>
								</div>
							</div>
							@endforeach
							@endif
							</div>

						</div>
						</div>
					
					  <div class="form-group" >
						<br>
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
    selector: 'textarea#content',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
  });
 tinymce.init({
    selector: 'textarea.cs-ask-ques-pg',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
  });

var count =  '{{$counter}}';
count = parseInt(count)+1;
$('body').on('click', '.add-row', function(){
 		var html = '<div class=" row-'+count+'">';
		var package_id =	Math.floor(100000 + Math.random() * 900000)
		html+='<div class="col-md-4 row-'+count+'">'+
							'<div class="form-group amt-data" style="margin: 0px;">'+
								'<label for="inputEmail" class="control-label"></label>'+
								'<input type="text" name="package_name[]" class=" form-control" placeholder="Package Name"><input type="hidden" name="package_id[]" class=" form-control" value="'+package_id+'">'+
							'</div>'+
							'</div>';
		html+='<div class="col-md-4 row-'+count+'">'+
							'<div class="form-group amt-data" style="margin: 0px;">'+
								'<label for="inputEmail" class="control-label"></label>'+
								'<input type="text" name="package_details[]" class=" form-control" placeholder="Details">'+
							'</div>'+
							'</div>';
		html+='<div class="col-md-4 row-'+count+'">'+
							'<div class="form-group amt-data" style="margin: 0px;">'+
								'<label for="inputEmail" class="control-label"></label>'+
								'<input type="text" name="package_details_terms[]" class=" form-control" placeholder="Terms And Conditions">'+
							'</div>'+
							'</div>';	
		html+='<div class="col-md-6 row-'+count+'">'+
							'<div class="form-group amt-data" style="margin-top: 10px;">'+
								'<br><label for="inputEmail" class="control-label">Customer Ask Question</label><br>'+
								'<textarea name="customer_ask_question_page[]" class="cs-ask-ques-pg form-control"></textarea>'+
							'</div>'+
							'</div>';										
		html+='<div class="col-md-2 row-'+count+'">'+
							'<div class="form-group amt-data" style="margin: 0px;">'+
								'<label for="inputEmail" class="control-label"></label>'+
								'<input type="number" name="number_of_question[]" class=" form-control" placeholder="Number Of Questions">'+
							'</div>'+
							'</div>';					
		html+='<div class="col-md-2 row-'+count+'">'+
							'<div class="form-group desc-data" style="margin: 0px;">'+
								'<label for="inputEmail" class="control-label"></label>'+
								'<input type="text" name="package_amount[]" class=" form-control" placeholder="Amount">'+
							'</div>'+
							'</div>';
		html+='<div class="col-md-1 row-'+count+'">'+
							'<div class="form-group btns-extra" style="margin-top: 10px;">'+
								'<button type="button" class="btn btn-sm btn-danger remove" data-id="'+count+'" style="padding:5px">Remove</button>'+
							'</div>'+
							'</div><div class="col-md-12"><hr></div></div>';
		$('.append-data').append(html);		
		count= count+1;
		tinymce.init({
    selector: 'textarea.cs-ask-ques-pg',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
  });
});

$('body').on('click', '.remove', function(){
		var id = $(this).attr('data-id');
		$('.row-'+id).remove();
});
</script>

@include('backend.includes.footer')
