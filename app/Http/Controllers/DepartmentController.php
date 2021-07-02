<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Http\Requests\DepartmentUpdateRequest;

class DepartmentController extends Controller
{
    public function list()
    {
        $companies = Company::all();
        $departments = Department::all();
        return view('department.list', compact([
            'companies', $companies,
            'departments', $departments,
        ]));
    }

    public function create()
    {
        $department = Department::create([
            'company_id' => auth()->user()->company()->id,
            'title' => 'Yeni Departman',
        ]);
        return $department->id;
    }

    public function update(DepartmentUpdateRequest $request)
    {
        $department = Department::find($request->id);
        $department->update([
            'company_id' => $request->company_id,
            'title' => $request->title,
        ]);
        $messages = [
            'status' => 'success',
            'title' => 'Kaydedildi',
            'message' => 'Yönlendiriliyorsunuz ...',
        ];
        return response()->json(['messages' => $messages]);
    }

    public function detail(Request $request)
    {
        $companies = Company::all();
        $department = Department::find($request->id);
        $selected_company = Company::where('id', $department->company_id)->first();
        return response()->json([
            'companies' => $companies,
            'department' => $department,
            'selected_company' => $selected_company,
        ]);
    }

    public function delete(Request $request)
    {
        $department = Department::find($request->id);
        $department->delete();
        $messages = [
            'status' => 'success',
            'title' => 'Silindi',
            'message' => 'Yönlendiriliyorsunuz ...',
        ];
        return response()->json([
            'messages' => $messages,
        ]);
    }
}
