<?php

namespace App\Console\Commands;

use App\WebSocketServer\WebSocketServer;
use Illuminate\Console\Command;

class StartWebSocket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'websocket:start {isSecured}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(WebSocketServer $webSocketServer)
    {
        $webSocketServer->start();
        return 0;
    }
}
