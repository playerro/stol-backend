<?php
// app/Observers/ReceiptObserver.php

namespace App\Observers;

use App\Enums\ReceiptStatus;
use App\Models\Clients\TgUser;
use App\Models\Receipt;
use App\Services\NotificationAppService;
use App\Services\RankService;
use App\Services\ReceiptService;
use App\Services\ReviewService;
use App\Services\TgUserService;
use DomainException;
use Illuminate\Support\Facades\DB;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;

class ReceiptObserver
{
    public function updated(Receipt $receipt): void
    {
        $original = $receipt->getOriginal('status');
        $current  = $receipt->status->value;

        if ($original !== ReceiptStatus::APPROVED->value
            && $current === ReceiptStatus::APPROVED->value
        ) {
            try {
                /** @var ReceiptService $service */
                $service = app(ReceiptService::class);
                $awarded = $service->applyPointsOnApproval($receipt);

                /** @var RankService $rankService */
                $rankService = app(RankService::class);
                $rankService->updateUserRank($receipt->tgUser);

                app(ReviewService::class)
                    ->recalculateRestaurantRating($receipt->restaurant);

                $chatId = $receipt->tgUser->telegram_id;
                $place  = $receipt->restaurant?->name ?? 'неизвестного заведения';

                $message  = "<b>УСПЕХ</b>: ✅ Поздравляем! Вам было начислено "
                    . "{$awarded} балл" . ($awarded > 1 ? 'ов' : '')
                    . " за отсканированный чек из заведения \"{$place}\"!";


                app(NotificationAppService::class)->notifyCheckApproved(
                    $receipt->tgUser,
                    $awarded
                );

                /** @var Nutgram $bot */
                $bot = app(Nutgram::class);
                $bot->sendMessage(text: $message, chat_id:  $chatId, parse_mode: ParseMode::HTML);
            } catch (DomainException $e) {
            } catch (\Throwable $e) {
                report($e);
            }
        } elseif ($original !== ReceiptStatus::REJECTED->value
            && $current === ReceiptStatus::REJECTED->value
        ) {
            try {
                app(NotificationAppService::class)->notifyCheckDeclined(
                    $receipt->tgUser,
                    '❌ Ой-ой! Ваш последний чек был отклонен. Попробуйте еще раз или используйте другой чек.'
                );

                $chatId  = $receipt->tgUser->telegram_id;
                $message = "<b>ОШИБКА</b>: ❌ Ой-ой! Ваш последний чек был отклонен. "
                    . "Попробуйте еще раз или используйте другой чек.";

                /** @var Nutgram $bot */
                $bot = app(Nutgram::class);
                $bot->sendMessage(text: $message, chat_id:  $chatId, parse_mode: ParseMode::HTML);
            } catch (\Throwable $e) {
                report($e);
            }
        }
    }
}
