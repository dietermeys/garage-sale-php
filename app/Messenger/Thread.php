<?php

namespace App\Messenger;

use App\User;
use Cmgmyr\Messenger\Models\Thread as MessengerThread;

class Thread extends MessengerThread
{

    /**
     * Get the original recipient from a thread
     *
     * @return User
     */
    public function originalRecipient()
    {
        $thread = $this;
        $creator = $thread->creator();

        // Filter out the original recipient
        $recipients = $thread->participants->filter(function ($participant, $key) use ($creator) {
            // If the userId doesn't equal the id of the sender
            // we can be sure this participant is the recipient
            return $participant->user->id !== $creator->id;
        });

        // Convert Participant to User
        $recipients = $recipients->map(function($participant) {
            return $participant->user;
        });

        // return $recipients;
        return $recipients->first();
    }
}
