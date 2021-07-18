<?php

namespace App\Http\Controllers\RCMS;

use App\Enums\ServiceType;
use App\Models\RCMS\Company;
use App\Models\RCMS\Currency;
use Illuminate\Http\Request;
use App\Models\RCMS\Service;
use App\Http\Requests\ServiceUpdateRequest;

class ServiceController extends Controller
{
    public function list()
    {
        $companies = Company::all();
        $services = Service::all();
        $currencies = Currency::all();
        return view('rcms.service.list', compact([
            'companies', $companies,
            'services', $services,
            'currencies', $currencies,
        ]));
    }

    public function create()
    {
        $service = Service::create([
            'company_id' => auth()->user()->company->id,
            'title' => 'Yeni Servis',
            'first_payment_time' => date("Y-m-d"),
            'last_payment_time' => date("Y-m-d"),
        ]);
        return $service->id;
    }

    public function update(ServiceUpdateRequest $request)
    {
        $service = Service::find($request->id);
        if ($service->update([
            'company_id' => $request->company_id,
            'title' => $request->title,
            'price' => $request->price,
            'currency_id' => $request->currency_id,
            'first_payment_time' => $request->first_payment_time,
            'last_payment_time' => $request->last_payment_time,
            'status' => ServiceType::fromValue(ServiceType::parseDatabase($request->status)),
        ])) {
            $messages = [
                'status' => 'success',
                'title' => 'Kaydedildi',
                'message' => 'Yönlendiriliyorsunuz.',
            ];
        } else {
            $messages = [
                'status' => 'warning',
                'title' => 'Kaydedilemedi',
                'message' => 'Yönlendiriliyorsunuz.',
            ];
        }

        return response()->json(['messages' => $messages]);
    }

    public function detail(Request $request)
    {
        $companies = Company::all();
        $service = Service::find($request->id);
        $selected_company = Company::where('id', $service->company_id)->first();
        $next_payment_time = $service->next_payment_time()['tr'];
        $days_left = $service->days_left();
        $status_values = ServiceType::asSelectArray();
        $service_status = $service->status;
        return response()->json([
            'companies' => $companies,
            'service' => $service,
            'next_payment_time' => $next_payment_time,
            'days_left' => $days_left,
            'selected_company' => $selected_company,
            'status_values' => $status_values,
            'service_status' => $service_status,
        ]);
    }

    public function delete(Request $request)
    {
        $service = Service::find($request->id);
        if ($service) {
            if ($service->title === "Yeni Servis") {
                if ($service->forceDelete()) {
                    $messages = [
                        'status' => 'success',
                        'title' => 'Silindi',
                        'message' => 'Yönlendiriliyorsunuz.',
                    ];
                }
            } else if ($service->delete()) {
                $messages = [
                    'status' => 'success',
                    'title' => 'Silindi',
                    'message' => 'Yönlendiriliyorsunuz.',
                ];
            } else {
                $messages = [
                    'status' => 'warning',
                    'title' => 'Silinemedi',
                    'message' => 'Yönlendiriliyorsunuz.',
                ];
            }
        } else {
            $messages = [
                'status' => 'warning',
                'title' => 'Silinemedi',
                'message' => 'Servis bulunamadı.',
            ];
        }
        return response()->json([
            'messages' => $messages,
        ]);
    }
}
