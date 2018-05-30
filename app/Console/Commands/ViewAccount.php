<?php

namespace App\Console\Commands;

use App\Agency;
use App\BankAccount;
use Illuminate\Console\Command;

class ViewAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'view:account {account_id}';

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
        $account = BankAccount::find($this->argument('account_id'));


        echo "\n";
        echo "\n";
        echo "################\n";
        echo "# Fiche Compte #\n";
        echo "################\n";
        echo "Code Agence : ". $account->agency->code ."\n";
        echo "Type : ". $account->accountable_type ."\n";
        echo "Créé le : ". $account->created_at ."\n";
        echo "Solde : ". $account->solde ."\n";

        if ($account->accountable_type == "simple") {
            echo "Découvert autorisé : ". $account->accountable->decouvert ."\n";
        }

        if ($account->accountable_type == "saving") {
            echo "Taux d'intérêt : ". $account->accountable->tx_interet ."\n";
        }

        echo "\n";
        echo "\n";
        echo "Retour à l'agence : 1\n";
        echo "Supprimer compte : 2\n";

        // connect to agency
        $action = null;
        while (!$action) {
            $action = readline("choix : ");
            if (!in_array($action, ['1', '2'])) {
                $action = null;
            }
        }

        switch ($action) {
            case '1':
                $this->call('view:agency', ['agency_id' => $account->agency->id]);
                break;

            case '2':
                $account->delete();

                $this->call('view:agency', ['agency_id' => $account->agency->id]);
                break;
        }

    }
}
