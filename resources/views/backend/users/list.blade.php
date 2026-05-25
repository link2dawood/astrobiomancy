@section('title', 'Users List') 
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

				      		<h3 style="padding-bottom:0px;border:none;font-size:20px;color:black; padding: 12px; " class="table-title p-20">Users 
				      			<a href="{{url('dashboard/users/add')}}">
	                      <i class="md md-add green lighten-1 icon-color" style="height:21px;width:21px;line-height:21px;font-size:21px;"></i></a>
                  </h3>
				      	</div>
				      	
								</div>
				       </legend>
				 
              </fieldset>
                  
				  
                </div>
              </div>
            
            <div class="row m-b-40">
				
              <div class="col-md-12">
             <div class="card no-margin">
							<!-- Modal HTML -->
				 		 <div class="table-responsive white">
                   <table class="table table-full table-full-small">
                      <colgroup>
                        <col class="auto-cell-size p-r-20">
                      </colgroup>
                      <thead>
                        <tr>
												  <th >Email</th>
												  <th >Name</th>
						  					  <th >Action</th>
                        </tr>
                      </thead>
                      <tbody id="myTable">
											  @foreach ($users as $user)
											  <tr>
												  <td >{{$user->email}}</td>
												  <td >{{$user->name}}</td>
						  					  <td >
						  					  	<a href="{{url('dashboard/users/edit/'.$user->id)}}"><i class="md md-edit light-blue lighten-1 icon-color icon-color-custom"></i></a>

													  <a   onclick="delete_record('{{$user->id}}');"><i class="md md-delete red darken-2 icon-color icon-color-custom"></i></a>
												  </td>
                        </tr>
                        @endforeach
					  					</tbody>
					  
            					</table>
				
				

									
                  </div>
                  
                  <div class="row" >
                  <div class="col-md-12" >
								
										<br><br>
										{{ $users->onEachSide(1)->links() }}
										
										
									</div>
									</div>


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
		var final_url=APP_URL+'/dashboard/users/delete/'+del_id;
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

@include('backend.includes.footer')
