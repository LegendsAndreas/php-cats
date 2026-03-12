<?php
namespace App\Utility;

use Cake\I18n\DateTime;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;
use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;
use MaxMind\Db\Reader\InvalidDatabaseException;

class LogCountry
{
    public function getIpCountry(): void
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

        $countriesCount = [];
        foreach ($ips as $ipAddress => $value) {
            try {
                $record = $reader->country($ipAddress);
            } catch (AddressNotFoundException $e) {
                Log::write('error', "IP address not found: {$ipAddress}", ['scope' => 'countries']);

                continue;
            } catch (InvalidDatabaseException $e) {
                Log::write('error', "Invalid GeoLite2 database: {$e->getMessage()}", ['scope' => 'countries']);

                continue;
            }

            $countryName = $record->country->name ?? 'Could not determine country';
            if (!isset($countriesCount[$countryName])) {
                $countriesCount[$countryName] = 0;
            }
            $countriesCount[$countryName]++;

            Log::write('info', $value['timestamp']->format('Y-m-d H:i:s') . ' ' . $countryName, ['scope' => 'countries']);
        }

        $this->addVisitorsToDatabase($countriesCount);

//        file_put_contents($path, '');
    }

    private function translateTimestamps($ips): array
    {
        foreach ($ips as &$ip) {
            $ip['timestamp'] = new DateTime($ip['timestamp']);
        }
        unset($ip);

        return $ips;
    }

    private function addVisitorsToDatabase(array $countriesCount)
    {
        $visitors = TableRegistry::getTableLocator()->get('Visitors');
        foreach ($countriesCount as $country => $count) {
            $dbVisitor = $visitors->find()->where(['country' => $country])->first();
            if (!$dbVisitor) {
                $newVisitor = $visitors->newEntity([
                    'country' => $country,
                    'count' => $count,
                ]);
                if (!$visitors->save($newVisitor)) {
                    Log::write('error', "Failed to save visitor data for country: {$country}", ['scope' => 'countries']);
                }
                continue;
            }

            $dbVisitor->count += $count;
            if (!$visitors->save($dbVisitor)) {
                Log::write('error', "Failed to update visitor data for country: {$country}", ['scope' => 'countries']);
            }
        }
    }
}
