<?php
namespace App\Utility;

// phpcs:ignoreFile

use Cake\Cache\Cache;
use Cake\Log\Log;
use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;
use MaxMind\Db\Reader\InvalidDatabaseException;

class LogCountry
{
    /*    public function getCountryFromIp(string $ip): void
        {
            $accessKey = 'key-boy';

            $apiUrl = "http://api.ipstack.com/$ip?access_key=$accessKey";

            $response = file_get_contents($apiUrl);
            $data     = json_decode($response, true);

            if ($data['success'] === false) {
                if ($data['error']['type'] === 'usage_limit_reached') {
                    Log::write('error', 'IPStack API usage limit reached', ['scope' => 'countries']);
                } else {
                    Log::write('error', 'Undetermined IPStack API error: ' . $data['error']['type'], ['scope' => 'countries']);
                }

                return;
            }

            if (!Cache::read("logged_ip_{$ip}", 'ip_logging')) {
                Log::write('info', $data['country_name'] ?? 'Could not determine country', ['scope' => 'countries']);
                Cache::write("logged_ip_{$ip}", true, 'ip_logging');
            }
        }*/

    public function getIpCountry(string $ip): void
    {
        if (Cache::read("logged_ip_{$ip}", 'ip_logging')) {
            Log::write('info', "IP address already logged: {$ip}", ['scope' => 'countries']);
            return;
        }

        $databasePath = ROOT . '/resources/GeoLite2-Country.mmdb';

        $reader = new Reader($databasePath);

        try {
            $record = $reader->country($ip);
        } catch (AddressNotFoundException $e) {
            Log::write('error', "IP address not found: {$ip}", ['scope' => 'countries']);

            return;
        } catch (InvalidDatabaseException $e) {
            Log::write('error', "Invalid GeoLite2 database: {$e->getMessage()}", ['scope' => 'countries']);

            return;
        }

        $countryName = $record->country->name ?? 'Could not determine country';

        Log::write('info', $countryName . " ($ip)", ['scope' => 'countries']);
        Cache::write("logged_ip_{$ip}", true, 'ip_logging');
    }
}
