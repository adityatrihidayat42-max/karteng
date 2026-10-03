<?php

namespace App\Http\Controllers;

use App\Models\Banom;
use Illuminate\Http\Request;

class PublicBanomController extends Controller
{
    public function index()
    {
        $banoms = Banom::where('status', 'active')
            ->withCount(['members' => function ($q) {
                $q->where('status', 'aktif');
            }])
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('public.banom.index', compact('banoms'));
    }

    public function show(Banom $banom)
    {
        $members = $banom->members()
            ->where('status', 'aktif')
            ->where('tampil_publik', true)
            ->paginate(12);

        return view('public.banom.show', compact('banom', 'members'));
    }
}
