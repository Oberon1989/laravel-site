<?php
namespace App\WebSocketServer;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\Http\HttpServer;
use Exception;

class WebSocketServer implements MessageComponentInterface
{
    private static ?WebSocketServer $instance = null;
    private string $host;
    private int $port;
    private bool $isSecured;

    private array $clients = [];

    private function __construct(string $host, int $port, bool $isSecured)
    {
        $this->host = $host;
        $this->port = $port;
        $this->isSecured = $isSecured;
        dump('create web socket server');
    }

    public static function getInstance(string $host = '127.0.0.1', int $port = 8080, bool $isSecured = false): WebSocketServer
    {
        if (self::$instance === null) {
            self::$instance = new WebSocketServer($host, $port, $isSecured);
        }
        return self::$instance;
    }

    public function start()
    {
        echo "Сервер запущен на " . ($this->isSecured ? 'wss' : 'ws') . "://{$this->host}:{$this->port}\n";

        if ($this->isSecured) {
            $server = IoServer::factory(
                new HttpServer(
                    new WsServer($this)
                ),
                $this->port,
                $this->host,
                $this->createSSLContext()
            );
        } else {
            $server = IoServer::factory(
                new HttpServer(
                    new WsServer($this)
                ),
                $this->port,
                $this->host
            );
        }

        $server->run();
    }

    private function createSSLContext()
    {
        $sslContext = stream_context_create([
            'ssl' => [
                'local_cert' => '/etc/letsencrypt/live/yourdomain/fullchain.pem',
                'local_pk' => '/etc/letsencrypt/live/yourdomain/privkey.pem',
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => false,
            ]
        ]);

        return $sslContext;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $url = $conn->httpRequest->getUri();

        parse_str($url->getQuery(), $queryParams);
        $channel = $queryParams['channel'] ?? 'default';
        $message = $queryParams['message'] ?? null;
        if(!$message){
           $this->clients[] = new Client($channel, $conn);
        }
        else{
            $this->sendMessageFromChanel($channel, $message);
        }



    }

    public function sendMessageFromChanel(string $channel, string $message)
    {
        dump(count($this->clients));
        foreach ($this->clients as $client) {
                dump($client->getChannel());
            if ($client->getChannel() === $channel) {
                $client->send($message);
            }
        }
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        echo "Получено сообщение от клиента {$from->resourceId}: $msg\n";

        foreach ($this->clients as $client) {

                $client->send("Ответ: $msg");
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        unset($this->clients[$conn->resourceId]);
        echo "Клиент {$conn->resourceId} отключился\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Ошибка: {$e->getMessage()}\n";
        $conn->close();
    }
}
