<?php

namespace App\Helpers;

use Config;
use DB;
use Illuminate\Support\Facades\Artisan;
use PDO;

class DatabaseConnection
{
    public static function setConnection($parameters)
    {
        $current_database = auth()->user()->current_database;
        if ($parameters === false) {
            $ipv4 = $current_database->ipv4;
            $port = $current_database->port;
            $username = $current_database->username;
            $password = $current_database->password;
            $database = $current_database->database;
        } else {
            $ipv4 = $parameters->ipv4;
            $port = $parameters->port;
            $username = $parameters->username;
            $password = $parameters->password;
            $database = $parameters->database;
        }
        config(['database.connections.panel_user' =>
            [
                'driver' => 'mysql',
                'url' => env('DATABASE_URL'),
                'host' => $ipv4,
                'port' => $port,
                'username' => $username,
                'password' => $password,
                'database' => $database,
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
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }


    public static function checkConnection($parameters)
    {
        config(['database.connections.panel_user' =>
            [
                'driver' => 'mysql',
                'url' => env('DATABASE_URL'),
                'host' => $parameters['ipv4'],
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
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
