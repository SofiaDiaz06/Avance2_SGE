<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Exports\ProductsTemplateExport;
use App\Exports\SalesExport;
use App\Http\Requests\ImportProductsRequest;
use App\Imports\ProductsImport;
use App\Services\InventoryService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function exportProducts(Request $request)
    {
        return Excel::download(new ProductsExport($request->input('search')), 'productos_'.now()->format('Ymd_His').'.xlsx');
    }

    public function exportSales(Request $request)
    {
        $data = $request->validate([
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date', 'after_or_equal:from'],
        ]);

        return Excel::download(new SalesExport($data['from'] ?? null, $data['to'] ?? null), 'ventas_'.now()->format('Ymd_His').'.xlsx');
    }

    public function template()
    {
        return Excel::download(new ProductsTemplateExport, 'plantilla_productos.xlsx');
    }

    public function importForm()
    {
        return view('products.import');
    }

    public function import(ImportProductsRequest $request, InventoryService $inventory)
    {
        $import = new ProductsImport($inventory);
        Excel::import($import, $request->file('file'));

        $failures = collect($import->failures())->map(fn ($f) => [
            'fila' => $f->row(),
            'columna' => $f->attribute(),
            'errores' => $f->errors(),
        ])->values()->all();

        return redirect()->route('products.import')->with([
            'success' => "Importación terminada: {$import->created} productos creados y {$import->updated} actualizados.",
            'failures' => $failures,
        ]);
    }
}