<?php

namespace App\Helpers;

use Config;
use DB;
use PDO;

class DatabaseConnection
{
    public static function setConnection()
    {
        $database = auth()->user()->current_database;
        config(['database.connections.panel_user' =>
            [
                'driver' => 'mysql',
                'url' => env('DATABASE_URL'),
                'host' => $database->ip,
                'port' => $database->port,
                'database' => $database->database,
                'username' => $database->username,
                'password' => $database->password,
                'unix_socket' => env('DB_SOCKET', ''),
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'prefix_indexes' => true,
                'strict' => true,
                'engine' => null,
                'options' => extension_loaded('pdo_mysql') ? array_filter([PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),]) : [],
            ]]);
        return DB::connection('panel_user');
    }


    public static function checkConnection($parameters)
    {
        config(['database.connections.panel_user' =>
            [
                'driver' => 'mysql',
                'url' => env('DATABASE_URL'),
                'host' => $parameters['ip'],
                'port' => $parameters['port'],
                'database' => $parameters['database'],
                'username' => $parameters['username'],
                'password' => $parameters['password'],
                'unix_socket' => env('DB_SOCKET', ''),
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'prefix_indexes' => true,
                'strict' => true,
                'engine' => null,
                'options' => extension_loaded('pdo_mysql') ? array_filter([PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),]) : [],
            ]]);
        try {
            DB::connection('panel_user')->getPdo();
            echo "Başarılı";
            /*
            if(DB::connection('panel_user')->getDatabaseName()){
                echo DB::connection('panel_user')->getDatabaseName() . "isimli tabloya başarıyla bağlanıldı";
            }else{
                die("Veritabanı bulunamadı. Lütfen ayarlarınızı kontrol edin.");
            }
            */
        } catch (\Exception $e) {
            die("Bağlantı kurulamadı. Lütfen ayarlarınızı kontrol edin.");
        }
    }
}
