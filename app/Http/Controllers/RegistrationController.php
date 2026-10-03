<?php

namespace App\Http\Controllers;

use App\Models\Banom;
use App\Models\Member;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function create()
    {
        $banoms = Banom::where('status', 'active')->orderBy('sort_order')->get();
        return view('public.daftar-anggota', compact('banoms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'nullable|string|size:16|unique:members,nik',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:L,P',
            'nomor_hp' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'alamat' => 'required|string',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'desa_kelurahan' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kabupaten_kota' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'banom_id' => 'nullable|exists:banoms,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'persetujuan' => 'required|accepted',
        ], [
            'persetujuan.required' => 'Anda harus menyetujui pernyataan keanggotaan.',
            'persetujuan.accepted' => 'Anda harus menyetujui pernyataan keanggotaan.',
            'nik.unique' => 'NIK ini sudah terdaftar sebagai anggota.',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('members', 'public');
        }

        $validated['status'] = 'menunggu_verifikasi';
        $validated['tampil_publik'] = false;
        unset($validated['persetujuan']);

        Member::create($validated);

        return redirect()->route('daftar-anggota')->with('success', 'Pendaftaran Anda berhasil dikirim! Silakan tunggu verifikasi dari pengurus ranting.');
    }
}
