<?php

namespace App\Http\Controllers\RCMS;

use App\Models\RCMS\Company;
use Illuminate\Http\Request;
use App\Models\RCMS\Database;
use App\Http\Requests\DatabaseUpdateRequest;
use App\Http\Requests\DatabaseCheckRequest;
use App\Helpers\DatabaseConnection;
use Illuminate\Support\Facades\Artisan;

class DatabaseController extends Controller
{
    public function list()
    {
        $companies = Company::all();
        $databases = Database::all();
        return view('rcms.database.list', compact([
            'companies', $companies,
            'databases', $databases,
        ]));
    }

    public function create()
    {
        $database = Database::create([
            'company_id' => auth()->user()->current_company->id,
            'database' => 'Yeni Veritabanı Bağlantısı',
        ]);
        return $database->id;
    }

    public function update(DatabaseUpdateRequest $request)
    {
        $database = Database::find($request->id);
        if ($database->update([
            'company_id' => $request->company_id,
            'ipv4' => $request->ipv4,
            'port' => $request->port,
            'username' => $request->username,
            'password' => $request->password,
            'database' => $request->database,
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
        $database = Database::find($request->id);
        $selected_company = Company::find($database->company_id);
        return response()->json([
            'companies' => $companies,
            'database' => $database,
            'selected_company' => $selected_company,
        ]);
    }

    public function check(DatabaseCheckRequest $request)
    {
        $parameters['ipv4'] = $request->ipv4;
        $parameters['port'] = $request->port;
        $parameters['username'] = $request->username;
        $parameters['password'] = $request->password;
        $parameters['database'] = $request->database;
        $check_connection = DatabaseConnection::checkConnection($parameters);
        return $check_connection;
    }

    public function migrate(DatabaseCheckRequest $request)
    {
        $check_connection = DatabaseConnection::setConnection($request);
        if ($check_connection === true) {
            $migrate_result = Artisan::call('migrate:fresh', array('--path' => 'database/migrations/client/', '--database' => 'panel_user'));
            if ($migrate_result == 0) {
                $messages = [
                    'status' => 'success',
                    'title' => 'Sıfırlandı & Güncellendi',
                    'message' => 'Yönlendiriliyorsunuz.',
                ];
            } else {
                $messages = [
                    'status' => 'warning',
                    'title' => 'Güncellenemedi',
                    'message' => 'Yönlendiriliyorsunuz.',
                ];
            }
        }else{
            $messages = [
                'status' => 'warning',
                'title' => 'Bağlantı kurulamadı',
                'message' => 'Yönlendiriliyorsunuz.',
            ];
        }
        return response()->json(['messages' => $messages]);
    }

    public function delete(Request $request)
    {
        $database = Database::find($request->id);
        if ($database) {
            if ($database->title === "Yeni Veritabanı Bağlantısı") {
                if ($database->forceDelete()) {
                    $messages = [
                        'status' => 'success',
                        'title' => 'Silindi',
                        'message' => 'Yönlendiriliyorsunuz.',
                    ];
                }
            } else if ($database->delete()) {
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
                'message' => 'Veritabanı Bağlantısı bulunamadı.',
            ];
        }
        return response()->json([
            'messages' => $messages,
        ]);
    }
}
