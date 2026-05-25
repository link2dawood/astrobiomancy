@extends('website.layouts.app')
@section('title', 'User Account ')
@section('content')
<style>
    
</style>
<section class="bg-light pt-15 " style="background: #feefd2 !important">
<div class="container px-5">
    <div class="row gx-5">
        @include('website.account.sidebar')
        <div class="col-lg-8 col-xl-9">
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{session()->get('message')}}
                </div>
            @endif
            @foreach ($order_chat as $ordchat)
            @if($ordchat->type==='user')
            <div class="card mb-4" >
                <div class="card-header d-flex justify-content-between">
                    <div class="me-2 text-dark">
                        {{$ordchat->userdata->name}}
                        <div class="text-xs text-muted">{{date('d M, Y H:i:s', strtotime($ordchat->created_at))}}</div>
                    </div>
                </div>
                <div class="card-body">
                    <p class="m-0 p-0"><b>Read: </b> @if($ordchat->is_read==1) {{$ordchat->read_text}} @else No @endif</p>
                    @if($ordchat->is_read==1)
                    <p class="m-0 p-0"><b>Read Time: </b>  {{date('d M, Y H:i:s', strtotime($ordchat->read_at))}}</p>
                     @endif
                    <p>{{$ordchat->message}}</p>
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
            @elseif($ordchat->type==='admin')
            <div class="card mb-4" >
                <div class="card-header d-flex justify-content-between" style="background: #ff9536;color: white !important;">
                    <div class="me-2 ">
                        {{$ordchat->userdata->name}}
                        <div class="text-xs ">{{date('d M, Y H:i:s', strtotime($ordchat->created_at))}}</div>
                    </div>
                </div>
                <div class="card-body">
                    <p>{{$ordchat->message}}</p>
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
            @endif
            @endforeach

            @if ($orders->number_of_question>0)
            <div class="card mb-4" >
                <div class="card-header" style="color: #4a515b;">Post Question</div>
                <div class="card-body">
                    <h4>@php echo $orders->customer_ask_question_page; @endphp</h4>
                    <form action="{{url('users/ordersaveques')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <input type="hidden" id="id" name="order_id" value="{{$orders->id}}">
                        <div class="col-md-12">
                            <label>Question</label>
                           <textarea class="form-control question" name="question" rows="10" maxlength="{{$settings->client_message_length}}"></textarea>
                           <br>
                           <p style="text-align: right;">
                           
                            <input type="file" name="attachment" id="file" style="display:none">
                            <label for="file">
                            <img width="20px" src="data:image/png;base64,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">
                            </label>
                            <span class="count-text">0</span>/{{$settings->client_message_length}}</p>
                            <div class="row fil-uploaded"> </div>
                        </div>
                      
                        <div class="col-md-12">
                            <button class="btn fw-500 btn-teal mt-2" type="submit">Send</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
<div class="svg-border-rounded text-dark">
    <!-- Rounded SVG Border-->
   <hr class="m-0 p-0">
   <br>
</div>
</section>

@endsection
@section('footer_section')
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>

<script>
    $('.question').on('input', function(){
        $('.count-text').html($('.question').val().length);
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

@endsection