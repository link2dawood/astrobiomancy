@section('title', 'Orders List') 
@include('backend.includes.head')
@php
$user_data=Auth::User();
@endphp
<body scroll-spy="" id="top" class=" theme-template-dark theme-pink alert-open alert-with-mat-grow-top-right">
<style>
.modal-dialog {
  padding-top:10%;
}
.modal-backdrop {
    
}

.preview-table >tbody>tr>th,.preview-table >tbody>tr>td{
	padding-top: 4px;
    padding-bottom: 3px;
    color: black !important;
    font-weight: unset;
    font-size: 15px !important;
	border:1px #d6d0d0 solid;
}
.preview-table>tbody>tr>th{
	width:33%;
	text-transform:none;
}
.selected_row{
	background: #90CAF9 !important;
    color: white;
}
@media screen and (max-width: 990px) {
  .go-button{
  	margin-left: 0px !important;
  }
}
.select2-container {
	text-align: left;
    width: 100% !important;
}
#invoice-total {
	color: red;
	font-size: 14px;
}

#os-price-total {
	color: red;
	font-size: 14px;
}
.checkbox input[type=checkbox]:checked:before, .checkbox-inline input[type=checkbox]:checked:before, input[type=checkbox]:checked:before {
	top:unset !important;
}
</style>

	<main>
	@include('backend.includes.sidebar')
     <div class="main-container">
		@include('backend.includes.header')
 		<div id="save_data_model" class="modal " tabindex="-1" >
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

		<div id="deleted_record" class="modal " tabindex="-1">
					<div class="modal-dialog modal-confirm" style="">
						<div class="modal-content">
							<div class="modal-header" style="padding-bottom: 0px;">
								<div class="icon-box" style="border:3px solid #28a745;">
									<i class="md md-check" style="font-size: 44px;font-weight: 1000;margin-top: 0px;color: #28a745!important;bottom: 5px;padding-top: -36px !important;padding-bottom: -3px;margin-bottom: -12px;padding: -6px;padding-bottom: 6px;"></i>
								</div>				
								<h4 class="modal-title" style="margin-top: 6px;">Deleted!</h4>	
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							</div>
							<div class="modal-body">
								<p style="margin: 0px;">Your data has been deleted.</p>
							</div>
							<div class="modal-footer" style="padding-bottom:0px">
								<button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
							</div>
						</div>
					</div>
				</div>
			<div id="update_record" class="modal " tabindex="-1">
					<div class="modal-dialog modal-confirm" style="">
						<div class="modal-content">
							<div class="modal-header" style="padding-bottom: 0px;">
								<div class="icon-box" style="border:3px solid #28a745;">
									<i class="md md-check" style="font-size: 44px;font-weight: 1000;margin-top: 0px;color: #28a745!important;bottom: 5px;padding-top: -36px !important;padding-bottom: -3px;margin-bottom: -12px;padding: -6px;padding-bottom: 6px;"></i>
								</div>				
								<h4 class="modal-title" style="margin-top: 6px;">Updated!</h4>	
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							</div>
							<div class="modal-body">
								<p style="margin: 0px;">Data Updated Successfully</p>
							</div>
							<div class="modal-footer" style="padding-bottom:0px">
								<button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Ok</button>
							</div>
						</div>
					</div>
				</div>	
			<div id="delete_record" class="modal " tabindex="-1" >
					<div class="modal-dialog modal-confirm" style="" >
					
						<div class="modal-content">
							<div class="modal-header" style="padding-bottom: 0px;">
								<div class="icon-box" style="border:3px solid #e91e63;">
									<i class="md md-warning" style="font-size: 44px;font-weight: 1000;margin-top: 0px;color: #e91e63!important;bottom: 5px;padding-top: -36px !important;padding-bottom: -3px;margin-bottom: -12px;padding: -6px;padding-bottom: 6px;"></i>
								</div>		
								<h4 class="modal-title" style="margin-top: 6px;">Are you Sure?</h4>	
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							</div>
							<div class="modal-body">
								<p style="margin: 0px;">You won't be able to revert this!</p>
							</div>
							<div class="modal-footer" style="padding-bottom:0px">
								<button type="button" class="btn btn-sm btn-success" onclick="delete_it()">Yes, delete it!</button>
								<button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
							</div>
						</div>
					</div>
			</div>	

 	  <div class="main-content" autoscroll="true" bs-affix-target="" init-ripples="" style="padding-top:0px">
     	 <section>
        
        <div class="col-md-12" style="padding:0px">
        <div class="well white" style="  padding-bottom: 0px;  padding-top: 5px;margin-bottom: 16px;">
				<fieldset>
		      <legend> 
		      	<div class="row">
		      	<div class="col-md-6" style="padding:0px">   
		      		<h3 style="padding-bottom:0px;border:none;font-size:20px;color:black; padding: 12px; " class="table-title p-20">Chat</h3>
		      	</div>
		      	
		      	
						</div>
         </legend>
				 
        </fieldset>
        </div>
        </div>
        
        @foreach ($order_chat as $ordchat)
        @if($ordchat->type==='user')

        <div class="col-md-12" style="padding:0px">
        <div class="well white" style="  padding-bottom: 0px;  padding-top: 5px;margin-bottom: 16px;background: #faf4f4 !important;">
				<fieldset>
		      <legend> 
		      	<div class="row">
		      	<div class="col-md-12" style="padding:0px">   
		      		<h3 style="padding-bottom:0px;border:none;font-size:14px;color:black; padding: 12px;font-weight:400 " class="table-title p-20">{{$ordchat->userdata->name}} <br>
		      			{{date('d M, Y H:i:s', strtotime($ordchat->created_at))}}
		      		</h3>
		      		<hr style="padding: 0px;margin: 0px;">
		      	</div>
		      	<div class="col-md-12">
		      		<p class="m-0 p-0" style="margin: 0px;font-size: 13px;"><b>Read</b> @if($ordchat->is_read==1) Yes @else No @endif</p>
              @if($ordchat->is_read==1)
              <p class="m-0 p-0" style="margin: 0px;font-size: 13px;"><b>Read Time</b>  {{date('d M, Y H:i:s', strtotime($ordchat->read_at))}}</p>
              @endif
              
              <form action="{{url('dashboard/orders/updatereadchat')}}" method="POST">
									@csrf
									<input type="hidden" name="id" value="{{$ordchat->id}}" style="width: 80%;">
									<input type="text" name="read_text" value="{{$ordchat->read_text}}" style="width: 80%;">
									<button type="submit" class="btn btn-primary">Submit</button>
              </form>

              <p style="margin: 0px;font-size: 13px;">{{$ordchat->message}}</p>
               	@php
                  $attachments = [];
                  if ( $ordchat->attachment!='') {
                      $attachments = explode(',', $ordchat->attachment);
                  }
              	@endphp
	              @foreach ($attachments as $atc)
	                  @if ($atc!='')
	                      <a href="{{url('public/uploads/orderchat/'.$atc)}}" target="_blank"> {{$atc}}</a>  <br> 
	                  @endif
	              @endforeach
		      	</div>
		      	</div>
         </legend>
				 
        </fieldset>
        </div>
        </div>
        @elseif($ordchat->type==='admin')
        <div class="col-md-12" style="padding:0px">
        <div class="well white" style="padding-bottom: 0px;  padding-top: 5px;margin-bottom: 16px;">
				<fieldset>
		      <legend> 
		      	<div class="row">
		      	<div class="col-md-12" style="padding:0px">   
		      		<h3 style="padding-bottom:0px;border:none;font-size:14px;color:black; padding: 12px;font-weight:400 " class="table-title p-20">{{$ordchat->userdata->name}} <br>
		      			{{date('d M, Y H:i:s', strtotime($ordchat->created_at))}}
		      		</h3>
		      		<hr style="padding: 0px;margin: 0px;">
			    	</div>
		      	<div class="col-md-12">
		      		  <p style="margin: 5px;font-size: 13px;">{{$ordchat->message}}</p>
		      		  @php
                  $attachments = [];
                  if ( $ordchat->attachment!='') {
                      $attachments = explode(',', $ordchat->attachment);
                  }
              	@endphp
	              @foreach ($attachments as $atc)
                  @if ($atc!='')
                      <a href="{{url('public/uploads/orderchat/'.$atc)}}" target="_blank"> {{$atc}}</a>  <br> 
                  @endif
	              @endforeach
		      		  <a href="{{url('dashboard/orders/'.$orders->id.'?chatid='.$ordchat->id)}}"><i class="md md-edit light-blue lighten-1 icon-color icon-color-custom"></i></a>
		      		  
							  <a   onclick="delete_record('{{$ordchat->id}}');"><i class="md md-delete red darken-2 icon-color icon-color-custom"></i></a>
							  <br>  <br>
  		    	</div>
		      	
						</div>
         </legend>
				 
        </fieldset>
        </div>
        </div>
        @endif

        @endforeach
      <form action="{{url('dashboard/ordersupdate')}}" method="POST" enctype="multipart/form-data">
      @csrf  
       <div class="col-md-12" style="padding:0px">
        <div class="well white" style="padding-bottom: 0px;  padding-top: 5px;margin-bottom: 16px;">
				<fieldset>
		      <legend> 
		      	<div class="row">
		      	<div class="col-md-12" style="padding:0px">   
		      		<h3 style="padding-bottom:0px;border:none;font-size:14px;color:black; padding: 12px;font-weight:600 " class="table-title p-20">Reply
		      		</h3>
		      		<hr style="margin:0px;padding:0px">
			    	</div>
		      	<div class="col-md-12">
						<div class="form-group">
							<label for="inputEmail" class="control-label">Questions left</label>
							<input type="number" class="form-control" name="number_of_question" value="{{$orders->number_of_question}}">
						</div>
						</div>
						<div class="col-md-12">
						<div class="form-group">
							<label for="inputEmail" class="control-label">Finished</label>
							<br>
							<input type="checkbox" name="status" @if($orders->status==='completed') checked @endif>
						</div>
						</div>
						<div class="col-md-12">
						<div class="form-group">
							<input type="hidden" name="order_id" value="{{$orders->id}}">
							@if (isset($_GET['chatid']))
							<input type="hidden" name="chatid" value="{{$_GET['chatid']}}">
							@endif
							<label for="inputEmail" class="control-label">Answer</label>
							<textarea name="message" class="form-control message" maxlength="{{$settings->admin_message_length}}">@if(isset($editChat->message)){{$editChat->message}}@endif</textarea>
							<p style="text-align: right;">
						  <input type="text" name="attachment_name" id="attachment_name" style="display:none">

							<input type="file" name="attachment" id="file" style="display:none">
                <label for="file">
                <img width="20px" src="data:image/png;base64,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">
                </label>
								<span class="count-text">0</span>/{{$settings->admin_message_length}}
							</p>
           	  <div class="row fil-uploaded"> </div>
						</div>
						</div>
		      	<div class="col-md-12">
		      		 <div class="form-group" >
								<button type="submit" name="save_exist" value="save_exist" class="btn btn-sm btn-primary">Save</button>
						
            		</div>
		      	</div>
						</div>
         </legend>
				 
        </fieldset>
        </div>
        </div>
      </form>
        <div class="row m-b-40">
				
              <div class="col-md-12">
             <div class="card no-margin">
							<!-- Modal HTML -->
				 		
                  
                 

                </div>
              </div>
            </div>
          </section>
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
<script>


@if(session()->has('message') && session()->get('message')==='update')
	$("#update_record").modal('show');
@endif
@if(session()->has('message') && session()->get('message')==='deleted')
	$("#deleted_record").modal('show');
@endif
@if(session()->has('message') && session()->get('message')==='add')
	$("#save_data_model").modal('show');
@endif
@if(session()->has('general'))
	$("#general_model").modal('show');
@endif
@if(session()->has('error'))
	$("#errorMsg").modal('show');
@endif
var del_id='';
var APP_URL = {!! json_encode(url('/')) !!}

function delete_record(id){
	del_id=id;
	single_delete='1';
	$("#delete_record").modal('show');
}
function delete_it(){
	if(single_delete==='1'){
		var final_url=APP_URL+'/dashboard/orderschat/delete/'+del_id;
		window.location.replace(final_url);
	}else if(single_delete==='0'){
		var final_url=APP_URL+'/delete_blukjobs?ids='+selected_ids;
		window.location.replace(final_url);
	}
}

$(document).keypress(function(e) { 
    if (e.keyCode === 13) { 
       $("#update_record").modal('hide');
       $("#deleted_record").modal('hide');
       $("#delete_record").modal('hide');
       $("#preview-model").modal('hide');
       $("#preview-model-company").modal('hide');
	   $("#save_data_model").modal('hide');
    } 
});
$('.preview-model').on('click',function(){
	 $(".preview-text").html('');
	 $(".preview-text").html($(this).attr('data-conetent'));
	 $("#preview-model").modal('show');
	  $("#preview-model").modal('hide');
});


$(document).ready(function() {
    $('.select2').select2();
});	


</script>
<script>
    $('.message').on('input', function(){
        $('.count-text').html($('.message').val().length);
    });

     var max_num_of_files = {{$settings->max_num_of_files}};
    var multiimage = 0;
    $('#file').change(function(){
        var formData = new FormData();
        formData.append('file', $(this)[0].files[0]);
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        
        if ($('.attachments').length == max_num_of_files) {
            alert("You can only upload "+max_num_of_files+" number of files");
            return ;
        }
        $.ajax({
            url: '{{url("users/orders/uploadtempfile")}}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken // Include CSRF token as a header
            },
            success: function(response){
                if (response.status ==false) {
                    alert(response.message);
                }
                
                if (response.extension==='jpg' || response.extension==='jpeg' || response.extension==='png' ) {
                    $('.fil-uploaded').append('<div class="col-md-3 attachments attach-'+multiimage+'"><img src="'+response.tempurl+'" style="width:100px"><br><span class="btn btn-danger btn-sm delete-file" data-counter="'+multiimage+'">X</span><input type="hidden" name="attachment_name[]" value="'+response.name+'"></div>');
                } else {
                    $('.fil-uploaded').append('<div class="col-md-3 attachments attach-'+multiimage+'"><a  href="'+response.tempurl+'" style="width:100px" target="_blank">'+response.name+'</a><br><span class="btn btn-danger btn-sm delete-file" data-counter="'+multiimage+'">X</span><input type="hidden" name="attachment_name[]" value="'+response.name+'"></div>');
                }
                 $('#file').val('');
                multiimage= multiimage+1;
            },
            error: function(xhr, status, error){
                console.error(xhr.responseText);
            }
        });
    });

    $('body').on( 'click','.delete-file', function(){
        var counter = $(this).attr('data-counter');
        $('.attach-'+counter).remove();
       
    });
</script>
@include('backend.includes.footer')
