<?php

namespace App\Console\Commands;

use App\Services\BookItemSaver;
use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class SaveBookItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:save_books';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start rabbitmq listener to save parsed data';

    protected $bookItemSaver;

    /**
     * Create a new command instance.
     *
     * @param BookItemSaver $bookItemSaver
     * @return void
     */
    public function __construct(BookItemSaver $bookItemSaver)
    {
        parent::__construct();
        $this->bookItemSaver = $bookItemSaver;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \ErrorException
     */
    public function handle()
    {
        $connection = new AMQPStreamConnection('rabbitmq', 5672, 'admin', 'admin');
        $channel = $connection->channel();

        $channel->queue_declare('save_book', false, true, false, false);

        echo " [*] Waiting for messages. To exit press CTRL+C\n";

        $callback = function ($msg) {
            echo ' [x] Received ', $msg->body, "\n";
            $this->bookItemSaver->processData($msg->body);
            echo " [x] Done\n";
            $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
        };

        $channel->basic_qos(null, 1, null);
        $channel->basic_consume('save_book', '', false, false, false, false, $callback);

        while (count($channel->callbacks)) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
        echo " Exit\n";
    }
}
