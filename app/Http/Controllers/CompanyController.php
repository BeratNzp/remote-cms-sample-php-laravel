<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyUpdateRequest;
use App\Models\Department;
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

    public function update(CompanyUpdateRequest $request)
    {
        $company = Company::find($request->id);
        if ($company->update([
            'title' => $request->title,
            'company_title' => $request->company_title,
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

    public function detail(Request $request)
    {
        $company = Company::find($request->company_id);
        $departments = Department::where('company_id', $company->id)->get();
        return response()->json([
            'company' => $company,
            'departments' => $departments,
        ]);
    }

    public function delete(Request $request)
    {
        $company = Company::find($request->id);
        $departments = Department::where('company_id', $company->id)->get();
        foreach ($departments as $department)
            $department->delete();
        if($company->delete()){
            $messages = [
                'status' => 'success',
                'title' => 'Silindi',
                'message' => 'Yönlendiriliyorsunuz.',
            ];
        }else{
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

    public function departments(Request $request)
    {
        $company = Company::find($request->id);
        $departments = Department::where('company_id', $company->id)->get();
        return response()->json([
            'departments' => $departments,
        ]);
    }
}
