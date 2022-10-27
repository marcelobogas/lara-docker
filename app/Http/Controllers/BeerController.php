<?php

namespace App\Http\Controllers;

use App\Exports\BeerExport;
use App\Http\Requests\BeerRequest;
use App\Jobs\ExportJob;
use App\Jobs\SendExportEmailJob;
use App\Jobs\StoreExportDataJob;
use App\Mail\ExportEmail;
use App\Models\Export;
use App\Services\PunkapiServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class BeerController extends Controller
{
    public function index(BeerRequest $request, PunkapiServices $service)
    {
        //.. retorno sem validação de request
        //return response()->json($service->getBeers(...$request->all()));

        //.. retorno com validação de parâmetros
        return response()->json($service->getBeers(...$request->validated()));
    }

    public function export(BeerRequest $request, PunkapiServices $service)
    {
        $filename = "list-beers-" . now()->format('Y-m-d H:i:s') . ".xlsx";

        ExportJob::withChain([
            new SendExportEmailJob($filename),
            new StoreExportDataJob(auth()->user(), $filename)
        ])->dispatch($request->validated(), $filename);

        return 'relatório criado...';
    }
}
