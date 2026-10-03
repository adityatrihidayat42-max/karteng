<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\OrganizationProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublicDonationController extends Controller
{
    public function index()
    {
        $profile = OrganizationProfile::first() ?? OrganizationProfile::getInstance();
        $recentDonations = Donation::where('status', 'confirmed')
            ->latest('confirmed_at')
            ->take(10)
            ->get();

        $totalConfirmed = Donation::where('status', 'confirmed')->sum('amount');
        $donorsCount = Donation::where('status', 'confirmed')->count();

        return view('public.donasi.index', compact('profile', 'recentDonations', 'totalConfirmed', 'donorsCount'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'donor_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'amount' => 'required|numeric|gt:0',
            'donation_type' => 'required|in:infaq,sedekah,donasi_kegiatan,donasi_umum,lainnya',
            'payment_method' => 'nullable|string|max:50',
            'bank_name' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:500',
        ], [
            'amount.required' => 'Silakan masukkan nominal infaq/donasi seikhlasnya.',
            'amount.numeric' => 'Nominal harus berupa angka.',
            'amount.gt' => 'Nominal infaq/donasi harus lebih dari 0.',
        ]);

        $validated['transaction_code'] = Donation::generateTransactionCode();
        $validated['status'] = 'pending';

        $donation = Donation::create($validated);

        return redirect()->route('donasi.show', $donation->transaction_code)
            ->with('success', 'Pengajuan donasi berhasil dibuat. Silakan lakukan pembayaran dan unggah bukti transfer.');
    }

    public function show($transaction_code)
    {
        $donation = Donation::where('transaction_code', $transaction_code)->firstOrFail();
        $profile = OrganizationProfile::first() ?? OrganizationProfile::getInstance();

        return view('public.donasi.show', compact('donation', 'profile'));
    }

    public function uploadProof(Request $request, $transaction_code)
    {
        $donation = Donation::where('transaction_code', $transaction_code)->firstOrFail();

        $request->validate([
            'proof_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:3072',
            'transfer_date' => 'required|date',
            'bank_name' => 'nullable|string|max:100',
        ]);

        if ($request->hasFile('proof_image')) {
            if ($donation->proof_image && Storage::disk('public')->exists($donation->proof_image)) {
                Storage::disk('public')->delete($donation->proof_image);
            }
            $path = $request->file('proof_image')->store('donations', 'public');
            $donation->proof_image = $path;
        }

        $donation->transfer_date = $request->transfer_date;
        if ($request->filled('bank_name')) {
            $donation->bank_name = $request->bank_name;
        }
        $donation->save();

        return back()->with('success', 'Bukti transfer berhasil diunggah! Pengurus akan segera memverifikasi donasi Anda.');
    }
}
