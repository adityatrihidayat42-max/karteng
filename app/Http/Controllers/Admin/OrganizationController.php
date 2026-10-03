<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrganizationController extends Controller
{
    public function edit()
    {
        $profile = OrganizationProfile::first() ?? OrganizationProfile::getInstance();
        return view('admin.organization.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $profile = OrganizationProfile::first() ?? OrganizationProfile::getInstance();

        $validated = $request->validate([
            'nama_organisasi' => 'required|string|max:255',
            'nama_singkat' => 'nullable|string|max:50',
            'tingkat' => 'nullable|string|max:50',
            'wilayah' => 'nullable|string|max:100',
            'tagline' => 'nullable|string|max:255',
            'sejarah' => 'nullable|string',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'tentang' => 'nullable|string',
            'alamat' => 'nullable|string',
            'kelurahan' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kabupaten' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'kode_pos' => 'nullable|string|max:10',
            'telepon' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
            'whatsapp' => 'nullable|string|max:30',
            'periode' => 'nullable|string|max:50',
            'rekening_bank' => 'nullable|string|max:100',
            'nama_rekening' => 'nullable|string|max:100',
            'nomor_rekening' => 'nullable|string|max:50',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'qris_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        if ($request->hasFile('logo')) {
            if ($profile->logo && Storage::disk('public')->exists($profile->logo)) {
                Storage::disk('public')->delete($profile->logo);
            }
            $validated['logo'] = $request->file('logo')->store('organization', 'public');
        }

        if ($request->hasFile('qris_image')) {
            if ($profile->qris_image && Storage::disk('public')->exists($profile->qris_image)) {
                Storage::disk('public')->delete($profile->qris_image);
            }
            $validated['qris_image'] = $request->file('qris_image')->store('organization', 'public');
        }

        $profile->update($validated);

        return back()->with('success', 'Profil organisasi berhasil diperbarui.');
    }
}
