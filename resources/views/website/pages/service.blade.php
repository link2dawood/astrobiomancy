@extends('website.layouts.app')
@section('title', 'Service '.$service->main_heading)
@section('content')
<style>
.second-step {
    display: none;
}
.third-step{
    display: none;
}
</style>
<header class="page-header-ui page-header-ui-dark bg-gradient-primary-to-secondary" style="    background: #ff9536 !important;">
<div class="page-header-ui-content pt-10">
    <div class="container px-5 text-center">
        <div class="row gx-5 justify-content-center">
            <div class="col-lg-8">
                <h1 class="page-header-ui-title mb-3">{{$service->main_heading}}</h1>
                <p class="page-header-ui-text">{{$service->second_heading}}</p>
            </div>
        </div>
    </div>
</div>
<div class="svg-border-rounded text-white">
    <!-- Rounded SVG Border-->
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none" fill="currentColor" style="color: #feefd2 ;"><path d="M144.54,17.34H0V0H144.54ZM0,0S32.36,17.34,72.27,17.34,144.54,0,144.54,0"></path></svg>
</div>
</header>
<section class="bg-white py-10" style="background: #feefd2 !important">
        <div class="container px-5">
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-10">
                    @php
                        echo $service->description;
                    @endphp
                <div class="row">
                   
                @foreach ($groupedData as $key=>$grp)    
                <div class="col-lg-6 mb-5">
                    <div class="card pricing ">
                        <div class="card-body p-5">
                            <div class="text-center">
                                <div style="white-space: break-spaces;font-size: 20px;margin-bottom: 15px;">{{$key}}</div>
                            </div>
                            <ul class="fa-ul pricing-list">

                                @foreach ($grp as $key=>$pkg)
                                <li class="pricing-list-item">
                                    <input type="radio" name="plan" value="{{$pkg['package_id']}}" data-amount="{{$pkg['package_amount']}}" data-package_details_terms="{{$pkg['package_details_terms']}}" data-details="{{$pkg['package_details']}}" >
                                    <span class="text-dark">{{$pkg['package_details']}}</span>
                                </li>
                                @endforeach
                                <li>
                                    @if(isset(\Auth::user()->id))
                                    <a class="btn fw-500 ms-lg-4 btn-teal order-now" style="    margin-left: 0px !important;">
                                        Buy Now
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right ms-2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                                    </a>
                                    @else
                                    <a class="btn fw-500 ms-lg-4 btn-teal" href="{{url('create-account')}}" style="    margin-left: 0px !important;">
                                        Buy Now
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right ms-2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                                    </a>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
                </div>
            </div>
        </div>
        <div class="svg-border-rounded text-dark">
        <!-- Rounded SVG Border-->
        <hr class="m-0">
    </div>
</section>

<div class="modal fade" id="order-service" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Buy Plan <span id="amount-html">()</span></h5>
        
      </div>
      <form action="{{url('postorder')}}" method="POST" id="payment-form">
      @csrf
      <div class="modal-body">
        <input type="hidden" id="service_id" value="{{$service->id}}" name="service_id">
        <input type="hidden" id="plan_amount" value="" name="amount">
        <input type="hidden" id="plan_key" name="plan_key">
        <input type="hidden" id="stripe_token" value="" name="stripe_token">
        <input type="hidden" id="paypal_id" value="" name="paypal_id">

        <div class="row">
        <div class="col-lg-12 first-step">
            <b>Billing Details</b>  <br>
            <div class="row">
                <div class="col-lg-6">
                    <label>First Name: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control first_name" name="first_name" required value="{{@$order->first_name}}">
                </div>
                <div class="col-lg-6">
                    <label>Last Name: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control last_name" name="last_name" required value="{{@$order->last_name}}">
                </div>
                <div class="col-lg-6">
                    <label>Email: <span class="text-danger">*</span></label>
                    <input type="email" class="form-control email" name="email" required value="{{@$order->email}}">
                </div>
                <div class="col-lg-6">
                    <label>Address 1: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control address" name="address" required value="{{@$order->address}}">
                </div>
                <div class="col-lg-6">
                    <label>Address 2: </label>
                    <input type="text" class="form-control address2" name="address2" value="{{@$order->address2}}">
					<input type="text" class="form-control order_id" name="order_id" value="{{rand(10000,10000000000)}}">
                </div>
                <div class="col-lg-6">
                    <label>City: </label>
                    <input type="text" class="form-control city" name="city" value="{{@$order->city}}">
                </div>
                <div class="col-lg-6">
                    <label>ZIP Code: </label>
                    <input type="text" class="form-control zipcode" name="zipcode" value="{{@$order->zipcode}}">
                </div>
                <div class="col-lg-6">
                    <label>State: </label>
                    <input type="text" class="form-control state" name="state" required value="{{@$order->state}}">
                </div>
                <div class="col-lg-6">
                    <label>Country: </label>
                    <?php 
                        $countries = file_get_contents(url('public/uploads/countries.json'));
                        $countries = json_decode($countries);

                    ?>
                    <select name="country" class="form-control country">
                        @foreach ($countries as $count)
                            <option value="{{$count}}" @if (isset($order->country) && $order->country===$count) selected @endif >{{$count}}</option>
                        @endforeach
                    </select>
                </div>
                
            </div>
        </div>
        <div class="col-md-1 first-step" style="margin-top: 10px;">
         <input type="checkbox" name="iagree" class="iagree">
        </div>
        <div class="col-md-11 terms-text first-step" style="text-align: justify;margin-top: 10px;font-size: 12px;font-weight: 600;">
        </div>
        <div class="col-lg-12 second-step">
            <b>Summary</b>
            <div class="row">
                
                <div class="col-lg-6">
                    First Name: <span id="first-name-html"></span>
                </div>
                <div class="col-lg-6">
                    Last Name: <span id="last-name-html"></span>
                </div>
                <div class="col-lg-6">
                    Email: <span id="email-html"></span>
                </div>
                <div class="col-lg-6">
                    Address 1: <span id="address-html"></span>
                </div>
                <div class="col-lg-6">
                    Address 2: <span id="address2-html"></span>
                </div>
                <div class="col-lg-6">
                    City: <span id="city-html"></span>
                </div>
                <div class="col-lg-6">
                    ZipCode: <span id="zipcode-html"></span>
                </div>
                <div class="col-lg-6">
                    State: <span id="state-html"></span>
                </div>
                <div class="col-lg-6">
                    Country: <span id="country-html"></span>
                </div>
                <div class="col-lg-6">
                    Package Amount: <span id="amount-html-summary"></span>
                </div>
                <div  class="col-lg-12">
                    <br>
                    <b>Select Payment Gatway</b><br>
                    <input type="radio" name="paymentgateway" value="card" checked> Credit card
                    <br>
                    <input type="radio" name="paymentgateway" value="paypal" > Paypal
                    
                </div>
            </div>
        </div>

       

        <div class="col-md-12 payment-step-stripe" style="display:none">
            <label>Enter Card Details</label>
             <div id="card-element" style="border: 1px solid black;padding: 10px;">
                <!--Stripe.js injects the Payment Element-->
            </div> 
            @php
                $settings = App\Models\Settings::first();
            @endphp
            <p style="text-align: justify;margin-top: 10px;font-size: 10px;    font-weight: 600;">{{$settings->stripe_text}}</p>
           
        </div>
        <div class="col-md-12 payment-step-papall" style="display:none">
            
            <div id="paypal-button">
            </div>
        </div>

        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary close-order-ser btn-teal" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-teal first-step-button first-step" >Next</button>

        <button type="button" class="btn btn-primary btn-teal second-step first-step-back" >Back</button>

        <button type="button" class="btn btn-primary btn-teal second-step second-step-button" >Proceed to payment</button>

        <button type="button" class="btn btn-primary btn-teal third-step third-step-back" >Back</button>
        <button type="submit" class="btn btn-primary btn-teal buy-now-button payment-step-stripe" style="display:none">Pay Now</button>
      </div>
     </form>
    </div>
  </div>
</div>


@endsection 

@section('footer_section')

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://js.stripe.com/v3/"></script>



<script src="https://www.paypal.com/sdk/js?client-id=AbOQbgyzG0UMn4d5V18hWaebWqxWWaD9Nd5OCKyatgOvc-Uo0rpQcIM3jT9dk-npTeP2HMUKq5yCa5Mn&currency=EUR" data-namespace="xswpvc_paypal_sdk" ></script>

<script>

    $('.order-now').on('click', function(){
        if ($('input[name="plan"]:checked').val()==undefined) {
            alert("Please select the plan first.");
            return ;
        }
        var descpition = $('input[name="plan"]:checked').attr('data-package_details_terms');
        $('.terms-text').html(descpition);
        $('.buy-now-button').attr('disabled', true);
        $('.first-step-button').attr('disabled', true);
        $('#order-service').modal('show');
        $('#amount-html').html('('+$('input[name="plan"]:checked').attr('data-amount')+' EURO)');
        $('#plan_amount').val($('input[name="plan"]:checked').attr('data-amount'));
        $('#plan_key').val($('input[name="plan"]:checked').val());
        $('#paypal-button').html("");
		var order_id = $('.order_id').val();
        //Show First Step
        $('.first-step').show();
        $('.second-step').hide();
        $('.third-step').hide();
        $('.iagree').prop('checked', false);
        xswpvc_paypal_sdk.Buttons(
            {
         /** Specify the style of the button **/
          style: {
          layout: "vertical",  // horizontal | vertical
          size:   "medium",    // medium | large | responsive
          shape:  "rect",      // pill | rect
          color:  "gold"       // gold | blue | silver | white | black
          },
          funding: {
          allowed: [
              xswpvc_paypal_sdk.FUNDING.CARD,
              xswpvc_paypal_sdk.FUNDING.CREDIT
          ],
          disallowed: []
          },
            createOrder: function(data, actions) {
              // This function sets up the details of the transaction, including the amount and line item details.
              return actions.order.create({
                purchase_units: [{
                  amount: 
					{
						"value":$('input[name="plan"]:checked').attr('data-amount'),
						"currency_code":"EUR",
						"breakdown":{
							"item_total":{
								"currency_code":"EUR",
								"value":$('input[name="plan"]:checked').attr('data-amount')
							}
						}
					},
				  "items":[
					{
						"unit_amount":{
							"currency_code":"EUR",
							"value":$('input[name="plan"]:checked').attr('data-amount')
						},
						"quantity":"1",
						"name": "Order # "+order_id+" {{@Auth::user()->name}} has purchased the plan. Package details :" +$('input[name="plan"]:checked').attr('data-details')
					}]
						 
						 
                }]
              });
            },
            onApprove: function(data, actions) {
              // This function captures the funds from the transaction.
              return actions.order.capture().then(function(details) {
                var pay_with_wallet = 'no';
                $('#stripe_token').val('paypal');
                $('#paypal_id').val(details.id);
                submitForm();
              });
            },onError: function (err) {
                alert(err);
                
            }
          }
        ).render("#paypal-button");  

    });

    function submitForm () {
    $('#payment-form').submit();
   
    }

    $('.iagree').on('click', function(){
        if ($(this).is(":checked")) {
            $('.first-step-button').attr('disabled', false);
            $('.buy-now-button').attr('disabled', false);
        } else{
             $('.first-step-button').attr('disabled', true);
             $('.buy-now-button').attr('disabled', true);
        }
    });
    
    $('.first-step-back').on('click', function(){
        $('.first-step').show();
        $('.second-step').hide();
    }); 
    $('.third-step-back').on('click', function(){
        $('.first-step').hide();
        $('.second-step').show();
        $('.payment-step-stripe').hide();
        $('.payment-step-papall').hide();
        $('.third-step').hide();
    });

    $('.second-step-button').on('click', function(){
        $('.first-step').hide();
        $('.second-step').hide();
        $('.payment-step-stripe').hide();
        $('.payment-step-papall').hide();
        $('.third-step').show();
        if ($('input[name="paymentgateway"]:checked').val()==='card') {
            $('.payment-step-stripe').show();
        } else {
            $('.payment-step-papall').show();
        }
    }); 

    $('.first-step-button').on('click', function(){
        if ($('.first_name').val()==='' && $('.last_name').val()==='' && $('.email').val()==='' && $('.address').val()==='' ) {
            alert('Please fill the requird fields');
            return;
        }
        $('.first-step').hide();
        $('.second-step').show();
        $('#first-name-html').html($('.first_name').val());
        $('#last-name-html').html($('.last_name').val());
        $('#email-html').html($('.email').val());
        $('#address-html').html($('.address').val());
        $('#address2-html').html($('.address2').val());
        $('#city-html').html($('.city').val());
        $('#zipcode-html').html($('.zipcode').val());
        $('#state-html').html($('.state').val());
        $('#country-html').html($('.country').val());
        
        $('#amount-html-summary').html('('+$('input[name="plan"]:checked').attr('data-amount')+' EURO)');
    });

    $('.close-order-ser').on('click', function(){
        $('#order-service').modal('hide');
    });

var stripe = 
Stripe('{{env("STRIPE_PUBLISHABLE")}}');
    // Create an instance of Elements.
    var elements = stripe.elements();
    // Custom styling can be passed to options when creating an Element.
    // (Note that this demo uses a wider set of styles than the guide below.)
    var style = {
  base: {
    color: "#0e0d0d",
    lineHeight: '18px',
    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
    fontSmoothing: 'antialiased',
    fontSize: '16px',
    '::placeholder': {
      color: '#aab7c4'
    }
  },
  invalid: {
    color: '#fa755a',
    iconColor: '#fa755a'
  }
};
// Create an instance of the card Element.
var card = elements.create('card', {style: style});
// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');
// Handle real-time validation errors from the card Element.
card.addEventListener('change', function(event) {
  var displayError = document.getElementById('card-errors');
  if (event.error) {
    displayError.textContent = event.error.message;
  } else {
    displayError.textContent = '';
  }
});
var formpayemnt = document.getElementById('payment-form');
formpayemnt.addEventListener('submit', function(event) {
    var stipe_token = $('#stripe_token').val();
    if (stipe_token === '') {
        event.preventDefault();
    }
    $('.submit-button-stipe').prop('disabled', true);
    $('#loading-overlay').show();
    $('#stripe_token').val('');
    stripe.createToken(card).then(function(result) {
        $('.submit-button-stipe').prop('disabled', false);

        if (result.error) {
          // Inform the user if there was an error.
          alert(result.error.message);
        } else {
          // Send the token to your server.
          $('#stripe_token').val(result.token.id);
          $('#myForm').submit();
          return ;
        }
    });
}); 
var formpayemnt = document.getElementById('payment-form');
formpayemnt.addEventListener('submit', function(event) {
    var stipe_token = $('#stripe-token').val();
    if (stipe_token === '') {
        event.preventDefault();
    }
    $('.submit-button-stipe').prop('disabled', true);
    $('#loading-overlay').show();
    $('#stripe_token').val('');
    stripe.createToken(card).then(function(result) {
        $('.submit-button-stipe').prop('disabled', false);

        if (result.error) {
          // Inform the user if there was an error.
          alert(result.error.message);
        } else {
          // Send the token to your server.
          $('#stripe_token').val(result.token.id);
          $('#payment-form').submit();
          return ;
        }
    });
});

  
</script>
@endsection 