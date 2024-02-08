<?php

namespace App\Services\V1;

use Illuminate\Http\Request;

class CustomerQuery {
    protected $safeParms = [
        'name' => ['eq'],
        'type' => ['eq'],
        'email' => ['eq'],
        'address' => ['eq'],
        'city' => ['eq'],
        'state' => ['eq'],
        'postalCode' => ['eq', 'gt', 'lt'],
    ];

    protected $columnMap = [
        'postalCode' => 'postal_code'
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>='
    ];

    // Questo metodo accetta un oggetto di tipo Request che contiene i dati della richiesta HTTP.
    // Itera attraverso i parametri accettabili definiti in $safeParms.
    // Per ciascun parametro, verifica se è presente nella richiesta. Se non è presente, passa al parametro successivo.
    // Se il parametro è presente, ottiene il valore e cerca corrispondenze con gli operatori definiti.
    // Costruisce un array di query Eloquent basato sui parametri e sugli operatori trovati.
    // Restituisce l'array di query Eloquent.

    public function transform(Request $request) {
        $eloQuert = [];

        foreach ($this->safeParms as $parm => $operators) {
            $query = $request->query($parm);

            if(!isset($query)) {
                continue;
            }

            $column =$this->columnMap[$parm] ?? $parm;

            foreach($operators as $operator) {
                if(isset($query[$operator])) {
                    $eloQuery[] = [$column, $this->operatorMap[$operator], $query[$operator]];
                }
            }
        }
        return $eloQuery;
    }
}