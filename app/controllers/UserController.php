<?php

class UserController extends BaseController {

    /**
     * Enregistre l'utilisateur
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
                $user->username = $input['username'];
                $user->email = $input['email'];
                $user->password = Hash::make($input['password']);
                $user->passkey = md5(uniqid() . time() . microtime());
                $user->role = 'user';
                $user->ip = $_SERVER['REMOTE_ADDR']; // Adresse ip
                $user->uploaded = 2147483648; // 2GB
                $user->downloaded = 1073741824; // 1GB
                $user->save();
                Session::put('message', 'You are now registered and can login without email confirmation');
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
            if (Auth::attempt(array('username' => $input['username'],
            'password' => $input['password'])))
            {
                return Redirect::to('/');
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

    }

    /**
     * Affiche le profil de l'utilisateur
     *
     */
    public function profil()
    {

    }
} ?>
