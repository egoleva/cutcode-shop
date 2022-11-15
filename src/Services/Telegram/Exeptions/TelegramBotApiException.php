<?php
namespace Services\Telegram\Exeptions;


use http\Env\Request;

class TelegramBotApiException extends \Exception
{

    public function render(Request $request)
    {
        return response()->json([]);
    }
}