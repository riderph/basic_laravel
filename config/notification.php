<?php

return [
    'slack' => [
        // Slack webhook
        'alert_webhook_url' => env('SLACK_ALERT_WEBHOOK_URL'),
        // Channel receive notification
        'alert_channel' => env('SLACK_ALERT_CHANNEL', ''),
    ],
];
