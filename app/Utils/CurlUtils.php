<?php

namespace App\Utils;

use Exception;


class CurlUtils
{
    public static function post($url, $data, $headers = [])
    {
        return self::exec('POST', $url, $data, $headers);
    }

    public static function get($url, $headers = [])
    {
        return self::exec('GET', $url, null, $headers);
    }

    public static function exec($method, $url, $data, $headers = [])
    {

        try {

            $curl = curl_init();

            $opts = [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => $method,
                CURLOPT_HTTPHEADER => $headers ?: [
                    'Accept: application/json',
                    'Content-Type: application/json',
                ],
            ];

            if ($data) {
                $opts[CURLOPT_POSTFIELDS] = json_encode($data);
            }

            curl_setopt_array($curl, $opts);

            $response = curl_exec($curl);

            if ($error = curl_error($curl)) {
                log_message('error', 'CURL Error #' . curl_errno($curl) . ': ' . $error);
            }

            curl_close($curl);

            return $response;
        } catch (Exception $e) {
            return ['message' => $e->getMessage()];
        }
    }
}
