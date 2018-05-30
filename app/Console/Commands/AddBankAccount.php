<?php

namespace App\Console\Commands;

use App\Agency;
use App\BankAccount;
use App\PayingBankAccount;
use App\SavingBankAccount;
use App\SimpleBankAccount;
use Illuminate\Console\Command;

class AddBankAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:account {agency_id}';

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
        // get agency
        $agency = Agency::find($this->argument('agency_id'));

        // choose account type
        $account_type = null;
        while (!$account_type ) {
            $account_type  = readline("Type de compte (1) : Simple / (2) Epargne / (3) Payant : ");
            switch ($account_type) {
                case '1':
                    $this->createBankAccount($agency->id, 'simple');
                    break;

                case '2':
                    $this->createBankAccount($agency->id, 'saving');
                    break;

                case '3':
                    $this->createBankAccount($agency->id, 'paying');
                    break;

                default:
                    $account_type = null;
                    break;
            }
        }
    }

    private function createBankAccount($agency_id, $type) {
        $solde = readline("Solde : ");

        $account = BankAccount::create([
            'solde' => $solde,
            'agency_id' => $agency_id,
            'accountable_id' => 0,
            'accountable_type' => 'undefined'
        ]);

        switch ($type) {
            case 'simple':
                $decouvert = readline("Découvert autorisé : ");
                $simpleAccount = SimpleBankAccount::create([
                    'account_code' => $account->code,
                    'decouvert' => $decouvert
                ]);

                $account->accountable_type = $type;
                $account->accountable_id = $simpleAccount->id;
                $account->save();
                break;

            case 'saving':
                $tx_interet = readline("Taux d'intérêt : ");
                $simpleAccount = SavingBankAccount::create([
                    'account_code' => $account->code,
                    'tx_interet' => $tx_interet
                ]);

                $account->accountable_type = $type;
                $account->accountable_id = $simpleAccount->id;
                $account->save();
                break;

            case 'paying':
                $simpleAccount = PayingBankAccount::create([
                    'account_code' => $account->code,
                ]);

                $account->accountable_type = $type;
                $account->accountable_id = $simpleAccount->id;
                $account->save();
                break;
        }

        $this->call('view:agency', ['agency_id' => $agency_id]);

    }
}
