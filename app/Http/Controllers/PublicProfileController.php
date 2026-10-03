<?php

namespace App\Http\Controllers;

use App\Models\Banom;
use App\Models\Member;
use App\Models\OrganizationProfile;
use Illuminate\Http\Request;

class PublicProfileController extends Controller
{
    public function index()
    {
        $profile = OrganizationProfile::first() ?? OrganizationProfile::getInstance();

        $pengurusRanting = Member::where('status', 'aktif')
            ->whereNotNull('jabatan')
            ->where('jabatan', '!=', '')
            ->whereNull('banom_id')
            ->get();

        $banoms = Banom::where('status', 'active')->get();

        return view('public.profil', compact('profile', 'pengurusRanting', 'banoms'));
    }
}
