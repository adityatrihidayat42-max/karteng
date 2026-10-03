<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\OrganizationProfile;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class KtaController extends Controller
{
    /**
     * Halaman Utama Cetak KTA Berbasis NIS (Khusus Admin/Pengurus)
     */
    public function index(Request $request)
    {
        $profile = OrganizationProfile::first() ?? OrganizationProfile::getInstance();
        $searchNis = trim($request->query('nis', ''));
        $selectedMember = null;
        $qrCode = null;
        $verifyUrl = null;
        $error = null;

        if (!empty($searchNis)) {
            $selectedMember = Member::where('nis', $searchNis)->with('banom')->first();
            if (!$selectedMember) {
                $error = "Nomor Induk Santri (NIS) '{$searchNis}' tidak ditemukan dalam pangkalan data.";
            } elseif ($selectedMember->status !== 'aktif') {
                $error = "Anggota dengan NIS '{$searchNis}' berstatus {$selectedMember->status_label}. KTA hanya dapat dicetak untuk anggota berstatus Aktif.";
                $selectedMember = null;
            } else {
                $verifyUrl = route('anggota.verify', $selectedMember->nis ?? $selectedMember->id);
                try {
                    $qrCode = base64_encode(QrCode::format('svg')->size(120)->generate($verifyUrl));
                } catch (\Exception $e) {
                    $qrCode = null;
                }
            }
        }

        // Daftar anggota aktif yang siap cetak KTA
        $query = Member::where('status', 'aktif')->whereNotNull('nis')->with('banom');
        if ($request->filled('q')) {
            $q = $request->query('q');
            $query->where(function ($sub) use ($q) {
                $sub->where('nama_lengkap', 'like', "%{$q}%")
                    ->orWhere('nis', 'like', "%{$q}%");
            });
        }
        $members = $query->latest()->paginate(10)->withQueryString();

        return view('admin.kta.index', compact(
            'profile',
            'searchNis',
            'selectedMember',
            'qrCode',
            'verifyUrl',
            'error',
            'members'
        ));
    }

    /**
     * Preview KTA berdasarkan model Member (diarahkan ke showByNis agar selalu menggunakan NIS)
     */
    public function show(Member $member)
    {
        if (empty($member->nis)) {
            return redirect()->route('admin.kta.index')
                ->with('error', "Anggota '{$member->nama_lengkap}' belum memiliki Nomor Induk Santri (NIS). Pembuatan KTA hanya dapat dilakukan menggunakan NIS.");
        }

        return redirect()->route('admin.kta.show-by-nis', $member->nis);
    }

    /**
     * Preview KTA langsung menggunakan NIS
     */
    public function showByNis($nis)
    {
        $member = Member::where('nis', $nis)->firstOrFail();

        if ($member->status !== 'aktif') {
            return redirect()->route('admin.kta.index')
                ->with('error', "Anggota dengan NIS '{$nis}' berstatus {$member->status_label}. KTA hanya dapat dicetak untuk anggota yang berstatus Aktif.");
        }

        $member->load('banom');
        $profile = OrganizationProfile::first() ?? OrganizationProfile::getInstance();

        $verifyUrl = route('anggota.verify', $member->nis);
        
        try {
            $qrCode = base64_encode(QrCode::format('svg')->size(120)->generate($verifyUrl));
        } catch (\Exception $e) {
            $qrCode = null;
        }

        return view('admin.kta.show', compact('member', 'profile', 'qrCode', 'verifyUrl'));
    }

    /**
     * Download PDF KTA berdasarkan model Member (diarahkan ke downloadByNis agar selalu menggunakan NIS)
     */
    public function download(Member $member)
    {
        if (empty($member->nis)) {
            return redirect()->route('admin.kta.index')
                ->with('error', "Anggota '{$member->nama_lengkap}' belum memiliki Nomor Induk Santri (NIS).");
        }

        return redirect()->route('admin.kta.download-by-nis', $member->nis);
    }

    /**
     * Download PDF KTA langsung menggunakan NIS
     */
    public function downloadByNis($nis)
    {
        $member = Member::where('nis', $nis)->firstOrFail();

        if ($member->status !== 'aktif') {
            abort(403, 'KTA hanya dapat dicetak untuk anggota berstatus aktif.');
        }

        $member->load('banom');
        $profile = OrganizationProfile::first() ?? OrganizationProfile::getInstance();

        $verifyUrl = route('anggota.verify', $member->nis);
        
        try {
            $qrCode = base64_encode(QrCode::format('svg')->size(100)->generate($verifyUrl));
        } catch (\Exception $e) {
            $qrCode = null;
        }

        // Standard ID card CR80 size: 85.6mm x 54mm (approx 243pt x 153pt)
        $pdf = Pdf::loadView('admin.kta.pdf', compact('member', 'profile', 'qrCode', 'verifyUrl'))
            ->setPaper([0, 0, 250, 160], 'landscape');

        $filename = 'KTA_' . str_replace('/', '-', $member->nis) . '.pdf';

        return $pdf->download($filename);
    }
}
