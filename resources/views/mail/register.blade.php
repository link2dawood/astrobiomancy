<html lang="{{ app()->getLocale() }}">
	<head>
	</head>
	<body>
		<h2>{{ __('site.mail_hi', ['name' => $name]) }}</h2>
		<p>{{ __('site.mail_register_body') }}</p>
		<p><a href="{{$verfiylink}}">{{ __('site.btn_continue') }}</a></p>
	</body>
</html>
