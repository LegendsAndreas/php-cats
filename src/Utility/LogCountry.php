<?php
namespace App\Utility;

// phpcs:ignoreFile

use Cake\Cache\Cache;
use Cake\Log\Log;

class LogCountry
{
    public function getCountryFromIp(string $ip): void
    {
        $accessKey = 'c25b359c3d9751572d92c1055e5c9a82';

        $apiUrl = "http://api.ipstack.com/$ip?access_key=$accessKey";

        $response = file_get_contents($apiUrl);
        $data     = json_decode($response, true);

        if (!Cache::read("logged_ip_{$ip}", 'ip_logging')) {
            Log::write('info', $data['country_name'] ?? 'Could not determine country', ['scope' => 'countries']);
            Cache::write("logged_ip_{$ip}", true, 'ip_logging');
        }
    }
}
