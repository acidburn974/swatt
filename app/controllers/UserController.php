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
     *
     */
    public function signup()
    {
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
                $group = Group::where('slug', '=', 'validating')->first();
                $user->username = $input['username'];
                $user->email = $input['email'];
                $user->password = Hash::make($input['password']);
                $user->passkey = md5(uniqid() . time() . microtime());
                $user->uploaded = 2147483648; // 2GB
                $user->downloaded = 1073741824; // 1GB
                $group->users()->save($user);

                Mail::send('emails.welcome', array('user' => $user), function($message) use ($user) {
                    $message->from(Config::get('other.email'), Config::get('other.title'));
                    $message->to($user->email, '')->subject('Welcome to ' . Config::get('other.title'));
                });

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
     */
    public function logout()
    {
        Auth::logout();
        return Redirect::to('/');
    }

    /**
     * Affiche la liste des membres
     *
     */
    public function members()
    {
        $users = User::orderBy('created_at', 'DESC')->paginate(20);

        return View::make('user.members', ['users' => $users]);
    }

    /**
     * Affiche le profil de l'utilisateur
     *
     */
    public function profil($username, $id)
    {
        $user = User::find($id);
        return View::make('user.profil', ['user' => $user]);
    }

    /**
     * Change la photo de l'utilisateur
     *
     */
    public function changePhoto($slug, $id)
    {
        $user = Auth::user();
        if(Input::hasFile('image'))
        {
            $image = Input::file('image');
            if(in_array($image->getClientOriginalExtension(), array('jpg', 'jpeg', 'bmp', 'png', 'tiff')) && preg_match('#image/*#', $image->getMimeType()))
            {
                $image->move(getcwd() . '/files/img/', $user->username . '.' . $image->getClientOriginalExtension());
                $user->image = $user->username . '.' . $image->getClientOriginalExtension();
                $user->save();
                return Redirect::route('profil', ['username' => $user->username, 'id' => $user->id])->with('message', 'Photo succesfully saved');
            }
            else
            {
                Redirect::route('profil', ['username' => $user->username, 'id' => $user->id])->with('message', 'Your image is invalid');
            }
        }
        else
        {
            Redirect::route('profil', ['username' => $user->username, 'id' => $user->id])->with('message', 'You must upload an image');
        }
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
    /**
     * Change les infos de l'utilisateur
     *
     * @access public
     * @param $username Nom d'utilisateur
     * @param $id Id de l'utilisateur
     */
    public function changeAbout($username, $id)
    {
        $user = Auth::user();
        if(Request::isMethod('post'))
        {
            $user->about = Input::get('about');
            $user->save();
            Session::put('message', 'Your informations are successfully saved');
        }

        return Redirect::route('profil', ['username' => $user->username, 'id' => $user->id]);
    }

    /**
     * Permet à l'utilisateur de modifier son mot de passe
     *
     *
     */
    public function lostPassword($token = null)
    {
        if(Request::isMethod('post'))
        {
            $user = User::where('email', '=', Input::get('email'))->first();
        }

        return View::make('user.lost_password');
    }

    /**
     * Modifie le titre de l'utilisateur si il est admin
     *
     * @access public 
     * @return Redirect
     */
    public function changeTitle($username, $id)
    {
        $user = User::find($id);
        if($user->id == Auth::user()->id)
        {
            $user->title = Input::get('title');
            $user->save();
        }

        return Redirect::route('profil', ['username' => $user->username, 'id' => $user->id]);
    }
} ?>
