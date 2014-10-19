<body>
    <h1>Invitation sur le tracker {{{ Config::get('other.title') }}} !</h1>

    <p>Vous avez reçus une invitation pour le tracker privé {{{ Config::get('other.title') }}}.</p>

    <h2><a href="{{ route('signup', array('key' => md5($email))) }}">Inscrivez-vous maintenant</a></h2>
</body>
