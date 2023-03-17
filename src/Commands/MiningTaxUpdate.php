<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Commands;

use Illuminate\Console\Command;
class MiningTaxUpdate extends Command
{
    protected $signature = 'tax:update {--F|force} {--N|now}  {year?} {month?}';

    protected $description = 'This updates the tax of the current month';

    public function handle()
    {
        $year = date('Y', strtotime('-1 month'));
        $month = date('n', strtotime('-1 month'));

        if (($this->argument('month')) && ($this->argument('year'))) {
            $year = $this->argument('year');
            $month = $this->argument('month');
        }

        if($this->option('now')){
            UpdateMiningTax::dispatchNow($this->option('force'), $year, $month);
        } else {
            UpdateMiningTax::dispatch($this->option('force'), $year, $month);
        }


    }
}