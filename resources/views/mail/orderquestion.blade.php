<html>
	<head></head>
	<body>
	  <h1>Question .</h1>
	  <b>{{$question}}</b>
	  	<br>
	 	<a href="{{url('dashboard/orders/'.$order->id)}}">Click Here to reply</a>
	  <br>
	  
	  <h1>Customer Details</h1> 
	   <b>Name </b> {{$user->name}}
	   <br>
	   <b>Email</b> {{$user->email}}
	   <br>
	   <b>Date Time</b> {{date('d M, Y H:i', strtotime($order->created_at))}}
	   <br>
	   <b>Package Details</b> {{$order->package_details}}
	   <br>
	  
	   <b>Number of question</b> {{$order->number_of_question}}
	   <br>
	   <b>Package name</b> {{$order->package_name}} <br>
	   <b>Payment ID</b> {{$order->stripe_id}}
   	   <h1>Total : EUR{{$order->package_amount}}</h1>

	</body>
</html>