<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserEditRequest;
use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function logout_action()
    {
        auth()->logout();
        request()->session()->flush();
        request()->session()->regenerate();
        return redirect()->intended('/')->with('message_type', 'success')->with('message', 'Çıkış yapıldı.');
    }

    public function edit_form($id)
    {
        $user = User::where('id', $id)->first();
        $companies = Company::all();
        $departments = Department::where('company_id', $user->company_id)->get();
        return view('user.edit', compact([
            'user', $user,
            'companies', $companies,
            'departments', $departments
        ]));
    }

    public function edit_action(UserEditRequest $request, $id)
    {
        $user = User::find($id);
        $password = $user->password;
        if ($request->password) {
            $password = Hash::make($request->password);
        }
        $user->update([
            'company_id' => $request->company_id,
            'department_id' => $request->department_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $password,
        ]);
        $messages = [
            'status' => 'success',
            'title' => 'Kaydedildi',
            'message' => 'Yönlendiriliyorsunuz ...',
        ];
        return response()->json([
            'messages' => $messages,
        ]);
    }
}
