<!DOCTYPE html><html lang="en"> 
 <head> 
 <meta charset="utf-8"> 
 <meta http-equiv="X-UA-Compatible" content="IE=edge">  
 <meta name="viewport" content="width=device-width, initial-scale=1">  
 <meta name="description" content="">   
 <meta name="author" content="">    
 <title>@yield('title')</title>  
 <meta name="msapplication-TileColor" content="#9f00a7">   
 <meta name="theme-color" content="#ffffff">    
 <meta name="csrf-token" content="{{ csrf_token() }}" >

 <link href="{{url('public/asserts/css/vendors.min.css')}} " rel="stylesheet" /> 
 <link href="{{url('public/asserts/css/style.css')}}" rel="stylesheet" />   
 <link href="{{url('public/asserts/css/custom_css.css')}}" rel="stylesheet" />   
 <script charset="utf-8" src="//maps.google.com/maps/api/js?sensor=true"> 
 
 </script>
 <style>
	.icon-color-custom{
		width: 24px;
		height: 24px;
		font-size: 12px;
		line-height: 24px;
	}
	.pagination>li>a, .pagination>li>span{
		    padding: 1px 14px;
	}

.table-full  {
  margin: auto;
  border-collapse: collapse;
  overflow-x: auto;
  display: block;
  width: fit-content;
  max-width: 100%;
 
}

td, th {
  
  padding: .5rem;
}

th {
  text-align: left;

  text-transform: uppercase;
  padding-top: 1rem;
  padding-bottom: 1rem;
  
  border-top: none;
}

.table-full >tbody >tr>td {
  white-space: nowrap;
 
}



.navbar-fixed-top{
		display:none;
}
main .main-container .main-content>section{
	margin-top:11px;
}
@media only screen and (max-width: 992px) and (min-width: 200px)  {
	.navbar-fixed-top{
		display:block;
	}
	.main-content{
		padding-top:37px !important;
		height: 37px;
	}
	.navbar{
		    min-height: 38px !important;
	}
	.toggle-mobile{
		padding:0px !important;
	}
	.hide-mobile{
		display:none;
	}
}
.brand-logo, .btn, .table-full thead tr>th, .uppercase{
	    text-transform: none !important;
}		

 </style>
 </head>
 