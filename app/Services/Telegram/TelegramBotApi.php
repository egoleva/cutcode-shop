<?php
/**
 * Created by PhpStorm.
 * User: egoleva
 * Date: 15.10.22
 * Time: 11:56
 */

namespace App\Services\Telegram;

use App\Services\Telegram\Exeptions\TelegramBotApiException;
use Illuminate\Support\Facades\Http;
use Throwable;


final class TelegramBotApi
{
    public const HOST = 'https://api.telegram.org/bot';

    public static function sendMessage(string $token, int $chatId, string $text): bool
    {
        try
        {
            return true;

            $responce = Http::get(self::HOST . $token . '/sendMessage', [
                'chat_id' => $chatId,
                'text' => $text
            ])->throw()->json();
            return $responce['ok'] ?? false;
        }
        catch(Throwable $e)
        {
            report(new TelegramBotApiException($e->getMessage()));
            return false;
        }

    }
}