<?php

namespace App\Console\Commands;

use App\Components\IntegrationA;
use Illuminate\Console\Command;

class HttpClienCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'request:http';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get data from Http Client Response';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $integration = new IntegrationA();
        $res = $integration->sendMoke();

        dd($res->getStatusCode());
        //return Command::SUCCESS;
    }
}
