<?php

namespace App\Console\Commands;

use App\Agency;
use Illuminate\Console\Command;

class Manage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'manage';

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
        echo "#############\n";
        echo "# Bienvenue #\n";
        echo "#############\n";
        echo "\n";
        echo "\n";
        echo "Liste des agences :\n";
        foreach (Agency::all() as $agency) {
            echo $agency->code . "\n";
        }
        echo "\n";
        echo "Choisir une agence : 1\n";
        echo "Ajouter une agence : 2\n";
        echo "Quitter : 9\n";

        // connect to agency
        $action = null;
        while (!$action) {
            $action = readline("choix : ");
           if (!in_array($action, ['1', '2', '9'])) {
               $action = null;
           }
        }

        switch ($action) {
            case '1':
                // connect to agency
                $agency = null;
                while (!$agency) {
                    $agency_code = readline("Entrez votre code d'agence : ");
                    $agency = Agency::where('code', '=', $agency_code)->get()->first();
                }
                $this->call('view:agency', ['agency_id' => $agency->id]);
                break;

            case '2':
                $this->call('add:agency');
                break;
        }
    }
}
