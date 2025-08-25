<?php
/** @var SergiX44\Nutgram\Nutgram $bot */

use App\Telegram\Conversations\SupportConversation;
use App\Telegram\Handlers\Support\SupportBackHandler;
use App\Telegram\Handlers\Support\SupportCancelHandler;
use App\Telegram\Handlers\Support\SupportCategoryHandler;
use App\Telegram\Handlers\Support\SupportReplyTextHandler;
use App\Telegram\Handlers\Support\SupportSendHandler;
use App\Telegram\Handlers\Support\SupportStartHandler;
use App\Telegram\Handlers\Support\SupportTextHandler;
use App\Telegram\Handlers\Support\SupportTopicHandler;
use App\Telegram\Handlers\SupportCallbacks;
use SergiX44\Nutgram\Nutgram;
use App\Telegram\Handlers\StartHandler;
use App\Telegram\Handlers\MessageHandler;
/*
|--------------------------------------------------------------------------
| Nutgram Handlers
|--------------------------------------------------------------------------
|
| Here is where you can register telegram handlers for Nutgram. These
| handlers are loaded by the NutgramServiceProvider. Enjoy!
|
*/

$bot->onCommand('start', StartHandler::class)->description('The start command!');
//$bot->onMessage(MessageHandler::class);


$bot->onCommand('support', SupportStartHandler::class);
$bot->onCallbackQueryData('support.start', SupportStartHandler::class);

// кнопки
$bot->onCallbackQueryData('support.cat.*',   SupportCategoryHandler::class);
$bot->onCallbackQueryData('support.topic.*', SupportTopicHandler::class);
$bot->onCallbackQueryData('support.back.*',  SupportBackHandler::class);
$bot->onCallbackQueryData('support.send',    SupportSendHandler::class);
$bot->onCallbackQueryData('support.cancel',  SupportCancelHandler::class);

$bot->onMessage(SupportTextHandler::class);

$callbacks = app(SupportCallbacks::class);
$bot->onCallbackQueryData('support.resolved.*', [SupportCallbacks::class, 'resolved']);
$bot->onCallbackQueryData('support.reply.*',    [SupportCallbacks::class, 'replyStart']);
$bot->onMessage(SupportReplyTextHandler::class);
