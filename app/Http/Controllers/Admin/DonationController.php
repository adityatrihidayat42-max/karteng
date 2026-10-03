<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    public function index(Request $request)
    {
        $query = Donation::with('confirmedBy');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('donation_type')) {
            $query->where('donation_type', $request->donation_type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('donor_name', 'like', "%{$search}%")
                  ->orWhere('transaction_code', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $donations = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total_pending' => Donation::where('status', 'pending')->count(),
            'total_confirmed' => Donation::where('status', 'confirmed')->count(),
            'total_amount' => Donation::where('status', 'confirmed')->sum('amount'),
            'amount_this_month' => Donation::where('status', 'confirmed')->thisMonth()->sum('amount'),
        ];

        return view('admin.donations.index', compact('donations', 'stats'));
    }

    public function show(Donation $donation)
    {
        $donation->load('confirmedBy');
        return view('admin.donations.show', compact('donation'));
    }

    public function confirm(Donation $donation)
    {
        $donation->status = 'confirmed';
        $donation->confirmed_at = now();
        $donation->confirmed_by = Auth::id();
        $donation->save();

        return back()->with('success', "Donasi #{$donation->transaction_code} dari {$donation->donor_name} berhasil dikonfirmasi.");
    }

    public function reject(Donation $donation)
    {
        $donation->status = 'rejected';
        $donation->confirmed_at = now();
        $donation->confirmed_by = Auth::id();
        $donation->save();

        return back()->with('success', "Donasi #{$donation->transaction_code} ditolak.");
    }
}
