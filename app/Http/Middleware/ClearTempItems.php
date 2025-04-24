<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ClearTempItems
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Jika URL bukan '/barcode', maka hapus 'temp_items' dari session
        if ($request->path() !== 'barcode' && $request->path() !== 'print_barcode') {
            Session::forget('temp_items');
        }


        if ($request->path() !== 'view_laporan' && $request->path() !== 'print_laporan') {
            Session::forget('barangMasukData');
        }
        return $next($request);
    }
}
