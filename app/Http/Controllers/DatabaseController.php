<?php

namespace App\Http\Controllers;

use App\Models\Client\Category;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\Database;
use App\Http\Requests\DatabaseUpdateRequest;
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
            'ip' => $request->ip,
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
        /*
        DatabaseConnection::setConnection();
        Category::create([
            'title' => 'func test',
        ]);
        */
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

    public function check(Request $request)
    {
        $parameters['ip'] = $request->ip;
        $parameters['port'] = $request->port;
        $parameters['username'] = $request->username;
        $parameters['password'] = $request->password;
        $parameters['database'] = $request->database;
        $check_connection = DatabaseConnection::checkConnection($parameters);
        return $check_connection;
    }

    public function migrate(Request $request)
    {
        DatabaseConnection::setConnection();
        if (Artisan::call('migrate:fresh', array('--path' => 'database/migrations/client/', '--database' => 'panel_user'))) {
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
