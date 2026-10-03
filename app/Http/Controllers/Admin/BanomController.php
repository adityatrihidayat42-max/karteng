<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BanomController extends Controller
{
    public function index()
    {
        $banoms = Banom::withCount('members')->orderBy('sort_order')->paginate(10);
        return view('admin.banoms.index', compact('banoms'));
    }

    public function create()
    {
        return view('admin.banoms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'singkatan' => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string',
            'ketua' => 'nullable|string|max:255',
            'kontak' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $validated['slug'] = Str::slug($validated['nama']);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('banoms', 'public');
        }

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('banoms', 'public');
        }

        Banom::create($validated);

        return redirect()->route('admin.banoms.index')->with('success', 'Banom berhasil ditambahkan.');
    }

    public function edit(Banom $banom)
    {
        return view('admin.banoms.edit', compact('banom'));
    }

    public function update(Request $request, Banom $banom)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'singkatan' => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string',
            'ketua' => 'nullable|string|max:255',
            'kontak' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        if ($request->hasFile('logo')) {
            if ($banom->logo && Storage::disk('public')->exists($banom->logo)) {
                Storage::disk('public')->delete($banom->logo);
            }
            $validated['logo'] = $request->file('logo')->store('banoms', 'public');
        }

        if ($request->hasFile('foto')) {
            if ($banom->foto && Storage::disk('public')->exists($banom->foto)) {
                Storage::disk('public')->delete($banom->foto);
            }
            $validated['foto'] = $request->file('foto')->store('banoms', 'public');
        }

        $banom->update($validated);

        return redirect()->route('admin.banoms.index')->with('success', 'Data Banom berhasil diperbarui.');
    }

    public function destroy(Banom $banom)
    {
        if ($banom->logo && Storage::disk('public')->exists($banom->logo)) {
            Storage::disk('public')->delete($banom->logo);
        }
        if ($banom->foto && Storage::disk('public')->exists($banom->foto)) {
            Storage::disk('public')->delete($banom->foto);
        }

        $banom->delete();

        return redirect()->route('admin.banoms.index')->with('success', 'Banom berhasil dihapus.');
    }
}
