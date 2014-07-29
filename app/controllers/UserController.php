<?php

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
                $group = Group::where('slug', '=', 'members')->first();
                $user->username = $input['username'];
                $user->email = $input['email'];
                $user->password = Hash::make($input['password']);
                $user->passkey = md5(uniqid() . time() . microtime());
                $user->uploaded = 2147483648; // 2GB
                $user->downloaded = 1073741824; // 1GB
                $group->users()->save($user);
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
} ?>
