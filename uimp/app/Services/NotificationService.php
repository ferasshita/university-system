<?php

namespace App\Services;

use App\Models\NotificationHistory;
use App\Models\NotificationTemplate;
use App\Models\User;

class NotificationService
{
    public function sendFromTemplate(
        User $user,
        string $templateSlug,
        array $placeholders = [],
        ?string $channel = null
    ): NotificationHistory {
        $template = NotificationTemplate::query()
            ->where('slug', $templateSlug)
            ->where('is_active', true)
            ->firstOrFail();

        $channel = $channel ?? $template->channel;
        $locale = app()->getLocale();

        $subject = $this->renderTemplate(
            $template->subject[$locale] ?? $template->subject['en'] ?? '',
            $placeholders
        );
        $body = $this->renderTemplate(
            $template->body[$locale] ?? $template->body['en'] ?? '',
            $placeholders
        );

        return NotificationHistory::create([
            'user_id' => $user->id,
            'template_id' => $template->id,
            'channel' => $channel,
            'subject' => $subject,
            'body' => $body,
            'sent_at' => now(),
            'status' => 'sent',
        ]);
    }

    private function renderTemplate(string $template, array $placeholders): string
    {
        foreach ($placeholders as $key => $value) {
            $template = str_replace('{{'.$key.'}}', (string) $value, $template);
        }

        return $template;
    }
}
