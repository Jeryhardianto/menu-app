<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;


class TestPushNotification extends Notification
{
    use Queueable;
    protected $user_id;
    protected $msg;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user_id,$msg)
    {
        $this->user_id = $user_id;
        $this->msg = $msg;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','broadcast'];
    }

    

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'comment'=>$this->msg,
            'user_id'=>$this->user_id
        ];
    }
    public function toBroadcast($notifiable)
    {

        return new BroadcastMessage([
            'comment'=>$this->msg,
            'user_id'=>$this->user_id
        ]);
    }
    public function broadcastOn(){
        return ['my-channel'];
    }
}