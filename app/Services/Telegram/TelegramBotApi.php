<?php
/**
 * Created by PhpStorm.
 * User: egoleva
 * Date: 15.10.22
 * Time: 11:56
 */

namespace App\Services\Telegram;

use Illuminate\Support\Facades\Http;


final class TelegramBotApi
{
    public const HOST = 'https://api.telegram.org/bot';

    public static function sendMessage(string $token, int $chatId, string $text): void
    {
        Http::get(self::HOST . $token . '/sendMessage', [
            'chat_id' => $chatId,
            'text' => $text
        ]);
    }
}