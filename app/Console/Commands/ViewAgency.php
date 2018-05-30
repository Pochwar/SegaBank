<?php

namespace App\Console\Commands;

use App\Agency;
use App\BankAccount;
use Illuminate\Console\Command;

class ViewAgency extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'view:agency {agency_id}';

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
        $agency = Agency::find($this->argument('agency_id'));

        echo "\n";
        echo "\n";
        echo "################\n";
        echo "# Fiche Agence #\n";
        echo "################\n";
        echo "Code Agence : ". $agency->code ."\n";
        echo "Adresse : ". $agency->address ."\n";
        echo "Créée le : ". $agency->created_at ."\n";

        echo "\n";
        echo "Comptes :\n";
        foreach ($agency->bankAccounts as $account) {
            echo "- Code : " . $account->code . " (" . $account->accountable_type . ")\n";
        }

        echo "\n";
        echo "\n";
        echo "Choisir un compte : 1\n";
        echo "Ajouter un compte : 2\n";
        echo "Retour : 8\n";
        echo "Quitter : 9\n";

        // connect to agency
        $action = null;
        while (!$action) {
            $action = readline("choix : ");
            if (!in_array($action, ['1', '2', '8', '9'])) {
                $action = null;
            }
        }

        switch ($action) {
            case '1':
                // connect to agency
                $account = null;
                while (!$account) {
                    $account_code = readline("Entrez le code du compte : ");
                    $account = BankAccount::where('code', '=', $account_code)->get()->first();
                }
                $this->call('view:account', ['account_id' => $account->code]);
                break;

            case '2':
                $this->call('add:account',  ['agency_id' => $agency->id]);
                break;

            case '8':
                $this->call('manage');
                break;
        }
    }
}
