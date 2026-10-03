<?php

namespace App\Http\Controllers;

use App\Models\Banom;
use App\Models\Member;
use Illuminate\Http\Request;

class PublicMemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::where('status', 'aktif')
            ->where('tampil_publik', true)
            ->with('banom');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('jabatan', 'like', "%{$search}%");
            });
        }

        if ($request->filled('banom_id')) {
            $query->where('banom_id', $request->banom_id);
        }

        if ($request->filled('jabatan')) {
            $query->where('jabatan', 'like', "%{$request->jabatan}%");
        }

        $members = $query->paginate(12)->withQueryString();
        $banoms = Banom::where('status', 'active')->get();

        return view('public.anggota.index', compact('members', 'banoms'));
    }

    public function show(Member $member)
    {
        if ($member->status !== 'aktif' || !$member->tampil_publik) {
            abort(404, 'Data anggota tidak ditemukan atau tidak dipublikasikan.');
        }

        return view('public.anggota.show', compact('member'));
    }

    public function verify($nis)
    {
        $member = Member::where('nis', $nis)->where('status', 'aktif')->with('banom')->firstOrFail();
        return view('public.anggota.verify', compact('member'));
    }
}
