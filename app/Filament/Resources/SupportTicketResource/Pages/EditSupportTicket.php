<?php

namespace App\Filament\Resources\SupportTicketResource\Pages;

use App\Enums\SupportTicketStatus;
use App\Filament\Resources\SupportTicketResource;
use App\Models\Support\SupportTicket;
use App\Services\NotificationBotService;
use App\Services\SupportService;
use Filament\Resources\Pages\EditRecord;

class EditSupportTicket extends EditRecord
{
    protected static string $resource = SupportTicketResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (!empty($data['answer'])) {
            /** @var SupportService $support */
            $support = app(SupportService::class);
            /** @var NotificationBotService $notify */
            $notify  = app(NotificationBotService::class);
            /** @var SupportTicket $this->record */
            $support->addAdminReply($this->record, $data['answer']);
            $notify->supportNotifyUserAnswer($this->record, $data['answer']);


            $data['answer'] = null;
        }

        if (!empty($data['status']) && is_string($data['status'])) {
            $data['status'] = SupportTicketStatus::from($data['status'])->value;
        }

        return $data;
    }
}
