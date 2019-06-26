<?php

namespace App\Console\Commands;

use App\Models\Exchange;
use Illuminate\Console\Command;

class CancelExpiredExchanges extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchanger:exchanges.cancel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancels expired exchanges';

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
     * @return mixed
     */
    public function handle()
    {
        $exchanges = Exchange::expired()
            ->get();

        foreach ($exchanges as $exchange) {
            $exchange->cancel();
        }

        return true;
    }
}
