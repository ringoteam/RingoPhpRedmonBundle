<?php



namespace Itkg\Bundle\PhpRedmonBundle\Redis\Predis;

/**
 * Client
 */
class Client extends \Predis\Client implements \Itkg\Bundle\PhpRedmonBundle\Redis\RedisInterface
{
    /**
     * Calls session_write_close() to fix bug a bug in PHP < 5.3.3
     * where object destruction occurs in the wrong order.
     *
     * @see http://pecl.php.net/bugs/bug.php?id=16745
     */
    public function __destruct()
    {
        if (version_compare(PHP_VERSION, '5.3.3', '<')) {
            session_write_close();
        }
    }
}