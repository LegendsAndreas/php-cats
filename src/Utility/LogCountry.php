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
    public function getIpCountry(string $ip): void
    {
        if (Cache::read("logged_ip_{$ip}", 'ip_logging')) {
            Log::write('info', "IP address already logged", ['scope' => 'countries']);
            return;
        }

        $databasePath = ROOT . '/resources/GeoLite2-Country.mmdb';

        $reader = new Reader($databasePath);

        try {
            $record = $reader->country($ip);
        } catch (AddressNotFoundException $e) {
            Log::write('error', "IP address not found", ['scope' => 'countries']);

            return;
        } catch (InvalidDatabaseException $e) {
            Log::write('error', "Invalid GeoLite2 database: {$e->getMessage()}", ['scope' => 'countries']);

            return;
        }

        $countryName = $record->country->name ?? 'Could not determine country';

        Log::write('info', $countryName, ['scope' => 'countries']);
        Cache::write("logged_ip_{$ip}", true, 'ip_logging');
    }
}
