<html>
	<head></head>
	<body>
	  <h1>Order has been confirmed .</h1>
	  <b>Below are the orders details</b>
	  
	 
	  <br>
	  
	  <h1>Customer Details:</h1> 
	   <b>Name: </b> {{$user->name}}
	   <br>
	   <b>Email:</b> {{$user->email}}
	   <br>
	   <b>Date Time:</b> {{date('d M, Y H:i', strtotime($order->created_at))}}
	   <br>
	   <b>Package Details</b> {{$order->package_details}}
	   <br>
		<h1>Billing Details:</h1> 
		   <b>First Name: </b> {{$order->first_name}}<br>
		   <b>Last Name: </b> {{$order->last_name}}<br>
		   <b>Email: </b> {{$order->email}}<br>
		   <b>Address1: </b> {{$order->address}}<br>
		   <b>Address2: </b> {{$order->address2}}<br>
		   <b>State: </b> {{$order->state}}<br>
		   <b>Zip Code: </b> {{$order->zipcode}}<br>
		   <b>City: </b> {{$order->city}}<br>
		   <b>Country: </b> {{$order->country}}<br>

	   <b>Number of question:</b> {{$order->number_of_question}}
	   <br>
	   <b>Package name:</b> {{$order->package_name}} <br>
	   <b>Payment ID:</b>@if ($order->stripe_id!='') {{$order->stripe_id}} @else {{$order->paypal_id}} @endif
   	   <h1>Total : EUR{{$order->package_amount}}</h1>

	</body>
</html>