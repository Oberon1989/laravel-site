<?php

namespace App\Jobs;

use App\Constants\Tg\TgConstants;
use App\Events\CrashReport;
use App\Models\User;
use App\Services\WebsocketService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Создание новой задачи.
     *
     * @param  User  $user
     */
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $service = new WebsocketService();

        $msg = ['user_id'=>$this->user->id,
            'user_name'=>$this->user->name,
            'user_login'=>$this->user->login,
            'user_email'=>$this->user->email,
            'user_uuid'=>$this->user->uuid];

        $service->sendMessage('user-list',json_encode($msg));
    }
}
