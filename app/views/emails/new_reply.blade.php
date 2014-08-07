<body>
	<h1>Your topic: {{ $topic->name }} has a new reply.</h1>

	<p>
		The user 
		<a href="{{ route('profil', ['username' => $user->username, 'id' => $user->id]) }}">{{ $user->username }}</a> 
		has replyed to your topic
		<a href="{{ route('forum_topic', ['slug' => $topic->slug, 'id' => $topic->id]) }}">{{ $topic->name }}</a>.
	</p>
</body>