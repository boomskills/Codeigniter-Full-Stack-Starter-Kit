<?php
/*
 * Created on Sun Jul 11 2021
 *
 * Copyright (c) 2021 Holoog Technologies, CC
 */

namespace App\Utils;

use Exception;

/**
 * Class SystemHealth.
 */
class SystemHealth
{
    private static $extensions = [
        'gd',
        'curl',
        'zip',
        'intl',
        'openssl',
        'mbstring',
        'xml',
        'bcmath',
    ];

    private static $php_version = 7.4;

    /**
     * Check loaded extensions / PHP version / DB Connections.
     *
     * @param bool $check_database
     *
     * @return array Result set of checks
     */
    public static function check($check_database = true): array
    {
        $system_health = true;

        if (phpversion() < self::$php_version) {
            $system_health = false;
        }

        if (!self::simpleDbCheck() && $check_database) {
            \log_message('error', 'db fails');
            $system_health = false;
        }

        return [
            'system_health' => $system_health,
            'extensions' => self::extensions(),
            'php_version' => [
                'minimum_php_version' => (string) self::$php_version,
                'current_php_version' => phpversion(),
                'current_php_cli_version' => (string) self::checkPhpCli(),
                'is_okay' => version_compare(phpversion(), self::$php_version, '>='),
            ],
            'env_writable' => self::checkEnvWritable(),
            'simple_db_check' => (bool) self::simpleDbCheck(),
            'cache_enabled' => self::checkConfigCache(),
            'exec' => (bool) self::checkExecWorks(),
            'open_basedir' => (bool) self::checkOpenBaseDir(),
            'mail_mailer' => (string) self::checkMailMailer(),
        ];
    }

    public static function checkMailMailer()
    {
        return config('mail.default');
    }

    public static function checkOpenBaseDir()
    {
        if (strlen(0 == ini_get('open_basedir'))) {
            return true;
        }

        return false;
    }

    public static function checkExecWorks()
    {
        if (function_exists('exec')) {
            return true;
        }

        return false;
    }

    public static function checkConfigCache()
    {
        if (env('APP_URL')) {
            return false;
        }

        return true;
    }

    public static function dbCheck($request = null): array
    {
        $db = \Config\Database::connect();
        $result = ['success' => false];

        try {
            $result[] = [$db->getDatabase() => true];
            $result['success'] = true;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
        }

        return $result;
    }

    private static function simpleDbCheck(): bool
    {
        $result = true;

        try {
            $db = \Config\Database::connect()->getDatabase();
            $result = true;
        } catch (Exception $e) {
            $result = false;
        }

        return $result;
    }

    private static function checkPhpCli()
    {
        try {
            exec('php -v', $foo, $exitCode);

            if (0 === $exitCode) {
                return empty($foo[0]) ? 'Found php cli, but no version information' : $foo[0];
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    private static function extensions(): array
    {
        $loaded_extensions = [];

        foreach (self::$extensions as $extension) {
            $loaded_extensions[] = [$extension => extension_loaded($extension)];
        }

        return $loaded_extensions;
    }

    private static function checkDbConnection()
    {
        return \Config\Database::connect()->getDatabase();
    }

    private static function checkEnvWritable()
    {
        return is_writable(ROOTPATH . '/.env');
    }
}
