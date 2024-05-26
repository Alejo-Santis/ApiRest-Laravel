<?php

namespace App\Filters;

use Illuminate\Http\Request;

class ApiFilter
{
    protected $safeParams = []; // Parametros con los que vamos a filtrar los modelos
    protected $columMap = []; // Mapear columnas a como queremos que se filtren
    protected $operatorMap = []; // Crear el mapeo de los operadores

    public function transform(Request $request)
    {
        $eloQuery = [];

        foreach ($this->safeParams as $parm => $operators) {
            $query = $request->query($parm);
            if (!isset($query)) {
                continue;
            }
            $column = $this->columMap[$parm] ?? $parm;

            foreach ($operators as $operator) {
                if (isset($query[$operator])) {
                    $eloQuery[] = [$column,$this->operatorMap[$operator], $query[$operator]];
                }
            }

            return $eloQuery;
        }
    }
}
