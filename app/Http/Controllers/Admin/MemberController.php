<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banom;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::with('banom');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('nomor_hp', 'like', "%{$search}%");
            });
        }

        if ($request->filled('banom_id')) {
            $query->where('banom_id', $request->banom_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $members = $query->latest()->paginate(15)->withQueryString();
        $banoms = Banom::all();

        return view('admin.members.index', compact('members', 'banoms'));
    }

    public function create()
    {
        $banoms = Banom::all();
        return view('admin.members.create', compact('banoms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'nullable|string|size:16|unique:members,nik',
            'nis' => 'nullable|string|max:50|unique:members,nis',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:L,P',
            'nomor_hp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'desa_kelurahan' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kabupaten_kota' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'banom_id' => 'nullable|exists:banoms,id',
            'jabatan' => 'nullable|string|max:100',
            'status' => 'required|in:aktif,tidak_aktif,menunggu_verifikasi',
            'tanggal_bergabung' => 'nullable|date',
            'tampil_publik' => 'boolean',
            'catatan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('members', 'public');
        }

        if ($validated['status'] === 'aktif' && empty($validated['nis'])) {
            $validated['nis'] = Member::generateNis();
        }

        $validated['tampil_publik'] = $request->has('tampil_publik');

        Member::create($validated);

        return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function show(Member $member)
    {
        $member->load('banom');
        return view('admin.members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        $banoms = Banom::all();
        return view('admin.members.edit', compact('member', 'banoms'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'nullable|string|size:16|unique:members,nik,' . $member->id,
            'nis' => 'nullable|string|max:50|unique:members,nis,' . $member->id,
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:L,P',
            'nomor_hp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'desa_kelurahan' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kabupaten_kota' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'banom_id' => 'nullable|exists:banoms,id',
            'jabatan' => 'nullable|string|max:100',
            'status' => 'required|in:aktif,tidak_aktif,menunggu_verifikasi',
            'tanggal_bergabung' => 'nullable|date',
            'catatan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($member->foto && Storage::disk('public')->exists($member->foto)) {
                Storage::disk('public')->delete($member->foto);
            }
            $validated['foto'] = $request->file('foto')->store('members', 'public');
        }

        if ($validated['status'] === 'aktif' && empty($member->nis) && empty($validated['nis'])) {
            $validated['nis'] = Member::generateNis();
        }

        $validated['tampil_publik'] = $request->has('tampil_publik');

        $member->update($validated);

        return redirect()->route('admin.members.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(Member $member)
    {
        if ($member->foto && Storage::disk('public')->exists($member->foto)) {
            Storage::disk('public')->delete($member->foto);
        }

        $member->delete();

        return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil dihapus.');
    }

    public function approve(Member $member)
    {
        $member->status = 'aktif';
        if (empty($member->nis)) {
            $member->nis = Member::generateNis();
        }
        $member->tanggal_bergabung = $member->tanggal_bergabung ?? now();
        $member->save();

        return back()->with('success', "Pendaftaran {$member->nama_lengkap} disetujui. NIS: {$member->nis}");
    }

    public function reject(Member $member)
    {
        $member->status = 'tidak_aktif';
        $member->save();

        return back()->with('success', "Pendaftaran {$member->nama_lengkap} ditolak.");
    }
}
