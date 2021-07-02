<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyCreateRequest;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    public function list()
    {
        $companies = Company::all();
        return view('company.list', compact([
            'companies', $companies,
        ]));
    }

    public function create()
    {
        $company = Company::create([
            'title' => 'Yeni Marka',
            'company_title' => 'Yeni Şirket Ünvanı',
        ]);
        return $company->id;
    }

    public function edit_action(CompanyCreateRequest $request)
    {
        $company = Company::find($request->id);
        $company->update([
            'title' => $request->title,
            'company_title' => $request->company_title,
        ]);
        $messages = [
            'status' => 'success',
            'title' => 'Kaydedildi',
            'message' => 'Yönlendiriliyorsunuz ...',
        ];
        return response()->json(['messages' => $messages]);
    }

    public function getDepartmentsOfCompany(Request $request)
    {
        $company = Company::find($request->company_id);
        $departments = Department::where('company_id', $company->id)->get();
        return response()->json([
            'departments' => $departments,
        ]);
    }

    public function getCompanyDetail(Request $request)
    {
        $company = Company::find($request->company_id);
        $departments = Department::where('company_id', $company->id)->get();
        return response()->json([
            'company' => $company,
            'departments' => $departments,
        ]);
    }

    public function deleteCompany(Request $request)
    {
        $company = Company::find($request->company_id);
        $departments = Department::where('company_id', $company->id)->get();
        foreach ($departments as $department)
            $department->delete();
        $users = User::where('company_id', $company->id)->get();
        foreach ($users as $user)
            $user->delete();
        $company->delete();
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
