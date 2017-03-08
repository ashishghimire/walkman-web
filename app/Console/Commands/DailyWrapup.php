<?php

namespace App\Console\Commands;

use App\Services\GiftService;
use Illuminate\Console\Command;

class DailyWrapup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:wrapup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @var GiftService
     */
    protected $gift;

    /**
     * Create a new command instance.
     *
     * @param GiftService $gift
     */
    public function __construct(GiftService $gift)
    {
        parent::__construct();
        $this->gift = $gift;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->gift->distribute()) {
            echo "success";
        } else {
            echo "failure";
        }
    }
}
