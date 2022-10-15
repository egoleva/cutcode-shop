<?php
/**
 * Created by PhpStorm.
 * User: egoleva
 * Date: 15.10.22
 * Time: 11:59
 */

namespace App\Logging\Telegram;
use Monolog\Logger;


class TelegramLoggerFactory
{
    /**
     * Create a custom Monolog instance.
     *
     * @param  array  $config
     * @return \Monolog\Logger
     */
    public function __invoke(array $config)
    {
        $logger = new Logger('telegram');
        $logger->pushHandler(new TelegramLoggerHandler($config));

        return $logger;
    }
}