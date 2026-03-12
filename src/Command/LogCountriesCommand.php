<?php

declare(strict_types=1);

namespace App\Command;

use Cake\Cache\Cache;
use Cake\Console\Arguments;
use Cake\Console\BaseCommand;
use Cake\Console\ConsoleIo;
use Cake\I18n\DateTime;
use Cake\Log\Log;
use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;
use MaxMind\Db\Reader\InvalidDatabaseException;

class LogCountriesCommand extends BaseCommand
{
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $path = ROOT . DS . 'logs' . DS . 'visitors.log';

        // Read the entire file at once
        $logs = file_get_contents($path);

        $lines      = array_filter(explode("\n", trim($logs)));
        $logEntries = array_map(function ($line) {
            return json_decode($line, true); // true for associative array
        }, $lines);

        if (empty($logEntries)) {
            return;
        }

        $ips = [];
        foreach ($logEntries as $entry) {
            if ($entry['level'] !== 'info') {
                continue; // Skip this entry, not all entries
            }

            $ips[$entry['request']['remote_ip']] = [
                'timestamp' => $entry['ts'],
            ];
        }

        $ips = $this->translateTimestamps($ips);

        $databasePath = ROOT . DS . 'resources' . DS . 'GeoLite2-Country.mmdb';

        $reader = new Reader($databasePath);

        foreach ($ips as $ipAddress => $value) {
            try {
                $record = $reader->country($ipAddress);
            } catch (AddressNotFoundException $e) {
                Log::write('error', "IP address not found: {$ipAddress}", ['scope' => 'countries']);

                continue; // Skip this IP, process the rest
            } catch (InvalidDatabaseException $e) {
                Log::write('error', "Invalid GeoLite2 database: {$e->getMessage()}", ['scope' => 'countries']);

                return; // Database issue affects all, so return is appropriate here
            }

            $countryName = $record->country->name ?? 'Could not determine country';
            Log::write('info', $value['timestamp']->format('Y-m-d H:i:s') . ' ' . $countryName, ['scope' => 'countries']);
        }

        file_put_contents($path, '');
    }

    private function translateTimestamps($ips): array
    {
        foreach ($ips as &$ip) {
            $ip['timestamp'] = new DateTime($ip['timestamp']);
        }
        unset($ip);

        return $ips;
    }
}
