<body>
	<h1>Welcome to {{{ Config::get('other.title') }}} {{ $user->username }} !</h1>

	<p>You can activate your account now !</p>

	<h2><a href="{{ route('user_activate', ['username' => $user->username, 'id' => $user->id, 'token' => md5($user->username),]) }}">Activate my account</a></h2>
</body>