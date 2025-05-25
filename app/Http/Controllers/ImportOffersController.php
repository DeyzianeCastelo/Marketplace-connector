<?php

namespace App\Http\Controllers;

use App\Application\Jobs\ImportOffersJob;
use Illuminate\Support\Facades\Log;

class ImportOffersController extends Controller
{
    public function import()
    {
        Log::info('Solicitação de importação recebida.');

        dispatch(new ImportOffersJob());

        return response()->json(['message' => 'Importação agendada com sucesso.'], 202);
    }
}
