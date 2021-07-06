<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function list()
    {
        $users = User::all();
        return view('user.list', compact([
            'users', $users,
        ]));
    }

    public function create()
    {
        // Available alpha caracters
        $random_characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        // generate a pin based on 2 * 7 digits + a random character
        $random_pin = mt_rand(1000000, 9999999)
            . mt_rand(1000000, 9999999)
            . $random_characters[rand(0, strlen($random_characters) - 1)];

        // shuffle the result
        $random_string = str_shuffle($random_pin);
        $user = User::create([
            'company_id' => auth()->user()->company()->id,
            'department_id' => auth()->user()->department()->id,
            'first_name' => 'İsim',
            'last_name' => 'Soyisim',
            'email' => 'randomEmailForNewUsersOfRCMS@' . $random_string,
            'password' => '',
        ]);
        return $user->id;
    }

    public function update(UserUpdateRequest $request)
    {
        $user = User::find($request->id);
        $password = $user->password;
        if ($request->password) {
            $password = Hash::make($request->password);
        }
        if ($user->update([
            'company_id' => $request->company_id,
            'department_id' => $request->department_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $password,
        ])) {
            $messages = [
                'status' => 'success',
                'title' => 'Kaydedildi',
                'message' => 'Yönlendiriliyorsunuz.',
            ];
        } else {
            $messages = [
                'status' => 'danger',
                'title' => 'Kaydedilemedi',
                'message' => 'Yönlendiriliyorsunuz.',
            ];
        }

        return response()->json([
            'messages' => $messages,
        ]);
    }

    public function detail(Request $request)
    {
        $user = User::find($request->id);
        $selected_company = Company::where('id', $user->company_id)->first();
        $departments_of_category = Department::where('company_id', $user->company_id)->get();
        $selected_department = Department::where('id', $user->department_id)->first();
        $companies = Company::all();
        return response()->json([
            'user' => $user,
            'selected_company' => $selected_company,
            'departments_of_category' => $departments_of_category,
            'selected_department' => $selected_department,
            'companies' => $companies,
        ]);
    }

    public function delete(Request $request)
    {
        $user = User::find($request->id);
        if ($user->delete()) {
            $messages = [
                'status' => 'success',
                'title' => 'Silindi',
                'message' => 'Yönlendiriliyorsunuz.',
            ];
        } else {
            $messages = [
                'status' => 'danger',
                'title' => 'Silinemedi',
                'message' => 'Yönlendiriliyorsunuz.',
            ];
        }

        return response()->json([
            'messages' => $messages,
        ]);
    }

    /////////
    public function logout_action()
    {
        auth()->logout();
        request()->session()->flush();
        request()->session()->regenerate();
        return redirect()->intended('/')->with('message_type', 'success')->with('message', 'Çıkış yapıldı.');
    }

}
