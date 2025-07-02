<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promo;
use App\Models\Order;
use Carbon\Carbon;

class PromoController extends Controller
{
    // Tampilkan halaman input kode promo
    public function show()
    {
        return view('promos.apply');
    }

    // Validasi & terapkan kode promo
    public function apply(Request $request)
    {
        $request->validate(['code' => 'required']);
        $promo = Promo::where('code', $request->code)->where('expiry_date', '>=', Carbon::today())->first();

        if (!$promo) {
            return back()->with('error', 'Promo code is invalid or expired.');
        }

        session(['promo' => $promo]);

        return back()->with('success', 'Promo applied successfully!');
    }
}
