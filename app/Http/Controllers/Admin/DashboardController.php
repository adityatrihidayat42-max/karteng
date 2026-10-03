<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Banom;
use App\Models\Donation;
use App\Models\Member;
use App\Models\Post;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_members' => Member::count(),
            'aktif_members' => Member::where('status', 'aktif')->count(),
            'menunggu_members' => Member::where('status', 'menunggu_verifikasi')->count(),
            'total_banoms' => Banom::count(),
            'total_posts' => Post::count(),
            'upcoming_agendas' => Agenda::where('status', 'upcoming')->where('start_at', '>=', now())->count(),
            'pending_donations' => Donation::where('status', 'pending')->count(),
            'total_donations_month' => Donation::where('status', 'confirmed')->thisMonth()->sum('amount'),
            'total_donations_all' => Donation::where('status', 'confirmed')->sum('amount'),
        ];

        $recentMembers = Member::with('banom')->latest()->take(5)->get();
        $recentDonations = Donation::latest()->take(5)->get();

        $banomStats = Banom::withCount('members')->get()->map(function ($b) {
            return [
                'name' => $b->singkatan ?? $b->nama,
                'count' => $b->members_count,
            ];
        });

        return view('admin.dashboard', compact('stats', 'recentMembers', 'recentDonations', 'banomStats'));
    }
}
