<?php

/**
 * Gestion des utilisateurs
 *
 *
 *
 */
class UserController extends BaseController {

    /**
     * Enregistre l'utilisateur
     *
     * @access public
     * @return Redirect /login
     */
    public function signup()
    {
        if(Config::get('other.invite-only') == true)
        {
            return Redirect::to('/')->with('message', 'You must be invited to register');
        }

        if(Request::isMethod('post'))
        {
            $input = Input::all();
            $user = new User();
            $v = Validator::make($input, $user->rules);
            if($v->fails())
            {
                $errors = $v->messages();
                Session::put('message', 'Wrong data provided');
            }
            else
            {
                $group = Group::where('slug', '=', 'members')->first();
                $user->username = $input['username'];
                $user->email = $input['email'];
                $user->password = Hash::make($input['password']);
                $user->passkey = md5(uniqid() . time() . microtime());
                $user->uploaded = 2147483648; // 2GB
                $user->downloaded = 1073741824; // 1GB
                $group->users()->save($user);

/*                Mail::send('emails.welcome', array('user' => $user), function($message) use ($user) {
                    $message->from(Config::get('other.email'), Config::get('other.title'));
                    $message->to($user->email, '')->subject('Welcome to ' . Config::get('other.title'));
                });*/

                Session::put('message', 'An e-mail was sent to this address now you can activate your account');
                return Redirect::route('login');
            }
        }
        return View::make('user.signup');
    }

    /**
     * Connecte l'utilisateur
     *
     * @access public
     * @return user.login
     */
    public function login()
    {
        if(Request::isMethod('post'))
        {
            $input = Input::all();
            if (Auth::attempt(array('username' => $input['username'], 'password' => $input['password'])))
            {
                return Redirect::intended('/');
            }
            else
            {
                Session::put('message', 'Username or password invalid');
            }
        }
        return View::make('user.login');
    }

    /**
     * Déconnecte l'utilisateur
     *
     * @access public
     * @return Redirect /
     */
    public function logout()
    {
        Auth::logout();
        return Redirect::to('/');
    }

    /**
     * Affiche la liste des membres
     *
     * @access public
     * @return view users.members
     */
    public function members()
    {
        $users = User::orderBy('created_at', 'DESC')->paginate(20);

        return View::make('user.members', ['users' => $users]);
    }

    /**
     * Affiche le profil de l'utilisateur
     *
     * @access public
     * @return view user.profile
     */
    public function profil($username, $id)
    {
        $user = User::find($id);
        return View::make('user.profil', ['user' => $user]);
    }

    /**
     * Permet à l'utilisateur d'éditer son profil
     *
     * @access public
     * @return void
     *
     */
    public function editProfil($username, $id)
    {
        $user = Auth::user();
        // Requetes post only
        if(Request::isMethod('post'))
        {
            if(Input::hasFile('image'))
            {
                // Modification de l'image de l'utilisateur
                $image = Input::file('image');
                // Check file
                if(in_array($image->getClientOriginalExtension(), array('jpg', 'jpeg', 'bmp', 'png', 'tiff')) && preg_match('#image/*#', $image->getMimeType()))
                {
                    // Move file
                    $image->move(getcwd() . '/files/img/', $user->username . '.' . $image->getClientOriginalExtension());
                    $user->image = $user->username . '.' . $image->getClientOriginalExtension();
                }
            }
            // Define data
            $user->title = Input::get('title');
            $user->about = Input::get('about');
            // Save the user
            $user->save();

            return Redirect::route('profil', ['username' => $user->username, 'id' => $user->id]);
        }

        return View::make('user.edit_profil', array('user' => $user));
    }

    /**
     * Active le compte utilisateur (validating -> members)
     *
     * @access public
     * @param $username Nom d'utilisateur
     * @param $id Id de l'utilisateur
     * @param $token Token pour l'activation unique du compte utilisateur
     *
     */
    public function activate($username, $id, $token)
    {
        $user = User::find($id);
        $group = Group::where('slug', '=', 'members')->first();

        if(md5($user->username) == $token)
        {
            $user->group_id = $group->id;
            $user->save();
            return Redirect::to('/login')->with('message', 'Now you can login');
        }
        else
        {
            return Redirect::to('/')->with('message', 'This link is unavailable');
        }
    }
} ?>
