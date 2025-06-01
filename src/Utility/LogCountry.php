<?php
// phpcs:ignoreFile

namespace App\Utility;

class LogCountry
{
    public string $countryName;

    public function getCountryFromIp($ipAddress)
    {
        $accessKey = 'c25b359c3d9751572d92c1055e5c9a82';

        $apiUrl = "http://api.ipstack.com/$ipAddress?access_key=$accessKey";

        $response = file_get_contents($apiUrl);
        $data     = json_decode($response, true);

        return $data['country_name'] ?? null;
    }

    public function countryTest()
    {
        echo 'test';
    }
}
