@section('title', 'Home Page') 
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

				<form action="{{ url('/dashboard/pages/home_save') }}" method="POST" enctype="multipart/form-data">


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
           <legend>Home Page</legend> 
						<div class="row">
							<div class="col-md-4">
							<div class="form-group" >
								<label for="inputEmail" class="control-label">Top Heading Text</label>
									{{ Form::input('text', 'top_header_heading', $homepage->top_header_heading, ['class' => 'form-control', 'id' => '']) }}
							</div>
							</div>
							<div class="col-md-4">
							<div class="form-group" >
								<label for="inputEmail" class="control-label">Top Sub Heading</label>
									{{ Form::input('text', 'top_header_subheading',$homepage->top_header_subheading, ['class' => 'form-control', 'id' => '']) }}
							</div>
							</div>

							<div class="col-md-4">
							<div class="form-group" >
								<label for="inputEmail" class="control-label"></label>
									{{ Form::input('file', 'image') }}
									@if ($homepage->banner_image!='')
									<img src="{{url('public/uploads/images/'.$homepage->banner_image)}}" style="width: 100px;">
									@endif
							</div>
							</div>
							</div>

							<div class="row">
							<div class="col-md-4">
							<div class="form-group" >
								<label for="inputEmail" class="control-label">Get Started Lable</label>
									{{ Form::input('text', 'get_started_label',$homepage->get_started_label, ['class' => 'form-control', 'id' => '']) }}
							</div>
							</div>
							<div class="col-md-4">
							<div class="form-group" >
								<label for="inputEmail" class="control-label">Get Started Link</label>
									{{ Form::input('text', 'get_started_link',$homepage->get_started_link, ['class' => 'form-control', 'id' => '']) }}
							</div>
							</div>
							<div class="col-md-4">
							<div class="form-group" >
								<label for="inputEmail" class="control-label">Welcome Label</label>
									{{ Form::input('text', 'welcome_lable',$homepage->welcome_lable, ['class' => 'form-control', 'id' => '']) }}
							</div>
							</div>
							
							
							<div class="col-md-12" style="margin-top:15px">
							<div class="form-group" >
							<label for="inputEmail" class="control-label">Weclome_text</label>
								<textarea class="form-control" name="weclome_text" id="content" placeholder="Content">{{$homepage->weclome_text}}</textarea>
							</div>
							</div>

							<div class="col-md-12">
								<br>
								<button type="button" class="btn btn-primary add-row">Add Queston Answser</button>
								<br>
							</div>
							<div class=" append-data" style="margin-bottom: 20px;">
								@php
										$qa_json = json_decode($homepage->qa_json, true);
										$counter = 0;
								@endphp
								@if (isset($qa_json[0]))
								@foreach ($qa_json as $key=>$qa)
								@php
									$counter = $key; 
								@endphp
								<div class="row row-{{$key}}" style="margin:0px">
			
							 <div class="col-md-5 row-{{$key}}">
								<div class="form-group amt-data" style="margin: 0px;">
								<label for="inputEmail" class="control-label"></label>
								<input type="text" name="question[]" class=" form-control" placeholder="Question" value="{{@$qa['question']}}">
							</div>
							</div>
							<div class="col-md-5 row-{{$key}}">
								<div class="form-group amt-data" style="margin: 0px;">
								<label for="inputEmail" class="control-label"></label>
								<input type="text" name="answer[]" class=" form-control" placeholder="Answer" value="{{$qa['answer']}}">
							</div>
							</div>
												
							
							<div class="col-md-2 row-{{$key}}">
								<div class="form-group btns-extra" style="margin: 0px;">
									<button type="button" class="btn btn-sm btn-danger remove" data-id="{{$key}}" style="padding:5px">Remove</button>
								</div>
								</div>
							</div>
							@endforeach
							@endif
							</div>
							<div class="col-md-12">
								<hr style="margin:0px;padding:0px">
							</div>
							<div class="col-md-12">
								<h5>Offer Section</h5>
							</div>
							@php
								$offer_json = json_decode($homepage->offer_json, true);
								$offer_key = 0;
							@endphp
							<div class="col-md-6">
								<div class="form-group amt-data" style="margin: 0px;">
								<label for="inputEmail" class="control-label"></label>
								<input type="text" name="offer_heading" class=" form-control" placeholder="Offer Heading " value="{{@$offer_json['offer_heading']}}">
							</div>
							</div>
								<div class="col-md-6">
								<div class="form-group amt-data" style="margin: 0px;">
								<label for="inputEmail" class="control-label"></label>
								<input type="text" name="offer_p1" class=" form-control" placeholder="Offer First Heading" value="{{@$offer_json['offer_p1']}}">
							</div>
							</div>
							<div class="col-md-6">
								<div class="form-group amt-data" style="margin: 0px;">
								<label for="inputEmail" class="control-label"></label>
								<input type="text" name="offer_p2" class=" form-control" placeholder="Offer Second Heading" value="{{@$offer_json['offer_p2']}}">
							</div>
							</div>
							<div class="col-md-12">
								<br>
								<button type="button" class="btn btn-primary add-row-offer">Add Offer</button>
								<br>
							</div>
							<div class="offer-data" style="margin-bottom: 20px;">
								@if (isset($offer_json['offer_data_links'][0]))
								@foreach ($offer_json['offer_data_links'] as $key2=>$offerdata)
								@php
									$offer_key = $key2;
								@endphp
								<div class="row row-offer-{{$key}}" style="padding:0px;margin:0px">
								 <div class="col-md-3 row-{{$key}}">
										<div class="form-group amt-data" style="margin: 0px;">
												<label for="inputEmail" class="control-label"></label>
												<input type="text" name="offer_name[]" class=" form-control" placeholder="Name" value="{{$offerdata['name']}}">
										</div>
										</div>
										<div class="col-md-3 row-offer-{{$key}}">
													<div class="form-group amt-data" style="margin: 0px;">
														<label for="inputEmail" class="control-label"></label>
														<input type="text" name="offer_link[]" class=" form-control" placeholder="Link" value="{{$offerdata['offer_link']}}">
													</div>
													</div>
										<div class="col-md-3 row-offer-{{$key}}">
												<div class="form-group amt-data" style="margin: 0px;">
													<label for="inputEmail" class="control-label"></label>
													<input type="text" name="offer_icon[]" class=" form-control" placeholder="Icon Name" value="{{$offerdata['offer_icon']}}"><a href="https://feathericons.com/" target="_blank">Get Name Of Icon</a>
												</div>
										</div>
									<div class="col-md-3 row-offer-{{$key}}">
											<div class="form-group btns-extra" style="margin: 0px;">
												<button type="button" class="btn btn-sm btn-danger remove-offer-link" data-id="{{$key}}" style="padding:5px">Remove</button>
											</div>
									</div>
								</div>
								@endforeach
								@endif
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
    selector: 'textarea#content',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
  });


var count =  '{{$counter}}';
count = parseInt(count)+1;
$('body').on('click', '.add-row', function(){
 		var html = '<div class=" row-'+count+'">';
			
		html+='<div class="col-md-5 row-'+count+'">'+
							'<div class="form-group amt-data" style="margin: 0px;">'+
								'<label for="inputEmail" class="control-label"></label>'+
								'<input type="text" name="question[]" class=" form-control" placeholder="Question">'+
							'</div>'+
							'</div>';
		html+='<div class="col-md-5 row-'+count+'">'+
							'<div class="form-group amt-data" style="margin: 0px;">'+
								'<label for="inputEmail" class="control-label"></label>'+
								'<input type="text" name="answer[]" class=" form-control" placeholder="Answer">'+
							'</div>'+
							'</div>';
		
		html+='<div class="col-md-2 row-'+count+'">'+
							'<div class="form-group btns-extra" style="margin: 0px;">'+
								'<button type="button" class="btn btn-sm btn-danger remove" data-id="'+count+'" style="padding:5px">Remove</button>'+
							'</div>'+
							'</div></div>';
		$('.append-data').append(html);		
		count= count+1;
});


var count_offer = '{{$offer_key}}';
count_offer = parseInt(count_offer)+1;
$('body').on('click', '.add-row-offer', function(){
 		var html = '<div class="row row-offer-'+count_offer+'" style="padding:0px;margin:0px">';
		html+='<div class="col-md-3 row-'+count_offer+'">'+
							'<div class="form-group amt-data" style="margin: 0px;">'+
								'<label for="inputEmail" class="control-label"></label>'+
								'<input type="text" name="offer_name[]" class=" form-control" placeholder="Name">'+
							'</div>'+
							'</div>';
		html+='<div class="col-md-3 row-offer-'+count_offer+'">'+
							'<div class="form-group amt-data" style="margin: 0px;">'+
								'<label for="inputEmail" class="control-label"></label>'+
								'<input type="text" name="offer_link[]" class=" form-control" placeholder="Link">'+
							'</div>'+
							'</div>';
		html+='<div class="col-md-3 row-offer-'+count_offer+'">'+
							'<div class="form-group amt-data" style="margin: 0px;">'+
								'<label for="inputEmail" class="control-label"></label>'+
								'<input type="text" name="offer_icon[]" class=" form-control" placeholder="Icon Name"><a href="https://feathericons.com/" target="_blank">Get Name Of Icon</a>'+
							'</div>'+
							'</div>';
		html+='<div class="col-md-3 row-offer-'+count_offer+'">'+
							'<div class="form-group btns-extra" style="margin: 0px;">'+
								'<button type="button" class="btn btn-sm btn-danger remove-offer-link" data-id="'+count_offer+'" style="padding:5px">Remove</button>'+
							'</div>'+
							'</div></div>';
		$('.offer-data').append(html);		
		count_offer= count_offer+1;
});

$('body').on('click', '.remove-offer-link', function(){
		var id = $(this).attr('data-id');
		$('.row-offer-'+id).remove();
});

$('body').on('click', '.remove', function(){
		var id = $(this).attr('data-id');
		$('.row-'+id).remove();
});
</script>

@include('backend.includes.footer')

