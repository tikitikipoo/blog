<?php
/**
 * DBI class for DietCake
 *
 * @license MIT License
 * @author Tatsuya Tsuruoka <http://github.com/ttsuruoka>
 * @link https://github.com/dietcake/dietcake-showcase
 */

use \cypher\Config;

class DB extends SimpleDBI
{
    public static function getConnectSettings($destination = 'default')
    {
        $settings = Config::read('database_' . $destination);

        if ($settings) {
            $dsn = $settings['dsn'];
            $username = $settings['user'];
            $password = $settings['password'];
            $driver_options = array(PDO::ATTR_TIMEOUT => $settings['timeout']);
        } else {
            throw new InvalidArgumentException("Unknown database: {$destination}");
        }

        return array($dsn, $username, $password, $driver_options);
    }

    protected function onQueryEnd($sql, array $params = array())
    {
        $this->log($sql, $params);
    }

    protected function log($sql, array $params = array())
    {
        static $num_query = 1;

        preg_match('/host=([0-9A-Za-z_-]+)/', $this->dsn, $matches);
        $host = isset($matches[1]) ? $matches[1] : '-';

//        Log::debug(sprintf("sql\t%f\t%d:(%s) %s; (%s)", $this->getLastExecTime(), $num_query++, $host, $sql, implode(', ', $params)), 'sql');
    }
}
