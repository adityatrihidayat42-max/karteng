<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Banom;
use App\Models\Gallery;
use App\Models\Member;
use App\Models\OrganizationProfile;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $profile = OrganizationProfile::first() ?? OrganizationProfile::getInstance();

        $stats = [
            'total_members' => Member::where('status', 'aktif')->count(),
            'total_banoms' => Banom::where('status', 'active')->count(),
            'total_agendas' => Agenda::count(),
            'total_posts' => Post::where('status', 'published')->count(),
        ];

        $latestPosts = Post::with('category', 'author')
            ->where('status', 'published')
            ->latest('published_at')
            ->take(3)
            ->get();

        $upcomingAgendas = Agenda::where('status', 'upcoming')
            ->where('start_at', '>=', now())
            ->orderBy('start_at', 'asc')
            ->take(3)
            ->get();

        if ($upcomingAgendas->isEmpty()) {
            $upcomingAgendas = Agenda::orderBy('start_at', 'desc')->take(3)->get();
        }

        $banoms = Banom::where('status', 'active')
            ->orderBy('sort_order', 'asc')
            ->get();

        $galleries = Gallery::with('images')
            ->where('status', 'published')
            ->latest()
            ->take(6)
            ->get();

        $structureMembers = Member::where('status', 'aktif')
            ->whereNotNull('jabatan')
            ->where('jabatan', '!=', '')
            ->take(8)
            ->get();

        return view('public.home', compact(
            'profile',
            'stats',
            'latestPosts',
            'upcomingAgendas',
            'banoms',
            'galleries',
            'structureMembers'
        ));
    }
}
