<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackAttachment;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class DeleteUserNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(User $userDeleted)
    {
        return ['slack'];
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @param User $userDeleted User was deleted
     *
     * @return SlackMessage
     */
    public function toSlack(User $userDeleted)
    {
        $url = 'http://localhost:8081';
        $currentUser = auth()->user();
        return (new SlackMessage())
            ->to(config('notification.slack.alert_channel'))
            ->content(sprintf('%s was deleted the % user', $currentUser->name, $userDeleted->name))
            ->attachment(function (SlackAttachment $attachment) use ($currentUser, $userDeleted, $url) {
                $attachment->color('#fcda00');
                $attachment->title('Detail', $url);
                $attachment->fields([
                    'current_user' => $currentUser->name,
                    'deleted_user' => $userDeleted->name,
                ]);
                $attachment->footer('SMILE bot :interrobang: ');
            });
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
