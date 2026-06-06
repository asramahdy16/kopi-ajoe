<?php

namespace App\Services;

use App\Models\Notification;

class NotificationService
{
    /**
     * Send a notification to a specific user.
     */
    public function send(int $userId, string $type, string $title, string $message, array $data = []): Notification
    {
        return Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
            'created_at' => now(),
        ]);
    }

    /**
     * Send a notification to all managers.
     */
    public function notifyManagers(string $type, string $title, string $message, array $data = []): void
    {
        $managers = \App\Models\User::where('role', 'manager')->where('is_active', true)->get();
        
        foreach ($managers as $manager) {
            $this->send($manager->id, $type, $title, $message, $data);
        }
    }
}
