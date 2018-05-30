<?php

namespace App\Console\Commands;

use App\Agency;
use Illuminate\Console\Command;

class AddAgency extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:agency';

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
     * @return mixed
     */
    public function handle()
    {
        echo "\n";
        echo "\n";
        echo "######################\n";
        echo "# Ajouter une agence #\n";
        echo "######################\n";
        echo "\n";
        echo "\n";
        $code = readline("Code de l'agence : ");
        $address = readline("Addresse de l'agence : ");

        Agency::create([
            'code' => $code,
            'address' => $address
        ]);

        $this->call('manage');
    }
}
