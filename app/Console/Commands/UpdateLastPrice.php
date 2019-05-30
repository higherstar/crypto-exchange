<?php

namespace App\Console\Commands;

use App\API\YallaBit\Bitstamp;
use Carbon\Carbon;
use Illuminate\Console\Command;
use function Psy\debug;
use Log;

class UpdateLastPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bitstamp:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates last price on bitstamp exchange';

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
        // End the repeat of this schedule 5 seconds before the next minute.. i.e. end @ XX:XX:55
        $end_of_schedule = Carbon::now()->addMinute(1)->subSeconds(Carbon::now()->second+5);
        $bitstamp = app(Bitstamp::class);
        while(true){
//            Log::debug('ending schedule @ ' . $end_of_schedule);

            $bitstamp->updateAllPairs();
            $wait_until = Carbon::now()->addSeconds(Bitstamp::SECONDS_TO_CACHE_FOR);
            if($bitstamp->is_tickers_from_cache)
            {
//                Log::Debug('Bitstamp class was grabbed from cache');
                $this->comment('Bitstamp class was grabbed from cache');
            }
            else{
//                Log::Debug("Bitstamp class was fetched");
                $this->comment("Bitstamp class was fetched");
            }

            // hold the execution of code until the wait time is done.
            while(! (Carbon::now() >= $end_of_schedule) && !(Carbon::now() > $wait_until))
                sleep(1);

            if(Carbon::now() >= $end_of_schedule)
            {
//                Log::debug('ending update schedule');
                break;
            }

        }
    }
}
