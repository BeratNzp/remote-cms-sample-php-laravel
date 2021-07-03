<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout_action');
    }

    public function login_form()
    {
        return view('user.login');
    }

    public function login_action(UserLoginRequest $request)
    {
        if (auth()->attempt(['email' => $request->email, 'password' => $request->password], $request->has('remember_me'))) {
            $request->session()->regenerate();
            /*
            $messages = [
                'status' => 'success',
                'title' => 'Başarılı',
                'message' => 'Yönlendiriliyorsunuz ...',
            ];
            */
        } /* else {
            $messages = [
                'status' => 'error',
                'title' => 'Hata',
                'message' => 'Kullanıcı adı veya parola hatalı !',
            ];

        } */
        //return response()->json(['messages' => $messages]);
        return redirect()->route('homepage');
    }

    public function register_form()
    {
        return view('user.register');
    }

    public function register_action()
    {
        $this->validate(request(), [
            'first_name' => 'required|min:2|max:32',
            'last_name' => 'required|min:2|max:32',
            'email' => 'required|min:8|max:128|unique:user',
            'password' => 'required|confirmed|min:6|max:32',
        ]);
        User::create([
            'first_name' => request('first_name'),
            'last_name' => request('last_name'),
            'email' => request('email'),
            'password' => Hash::make(request('password')),
            'token' => Str::random(64),
            'active_user' => 0
        ]);
        /*
         * $data = ([
            'user' => $user,
        ]);
        Mail::to($user->email)->send(new UserRegisterEmail($data));
        */
        return redirect()
            ->route('homepage')
            ->with('message_type', 'success')
            ->with('message', 'Hesabınız oluşturuldu. Ancak giriş yapabilmek için size gönderdiğimiz emaildeki linke tıklayarak hesabınızı aktifleştirmeniz gerekmektedir.');
    }

    public function activate($token)
    {
        $user = User::where('token', $token)->first();
        if (!is_null($user)) {
            $user->token = null;
            $user->active_user = 1;
            $user->save();
            auth()->login($user);
            return redirect()
                ->route('homepage')
                ->with('message_type', 'success')
                ->with('message', 'Hesabınız aktifleştirildi.');
        } else {
            return redirect()
                ->route('homepage')
                ->with('message_type', 'danger')
                ->with('message', 'Kod kullanılmış yada hatalı. Destek için iletişime geçebilirsiniz.');
        }
    }
}
