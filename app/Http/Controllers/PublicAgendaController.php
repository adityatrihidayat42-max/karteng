<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;

class PublicAgendaController extends Controller
{
    public function index(Request $request)
    {
        $upcoming = Agenda::where('status', 'upcoming')
            ->where('start_at', '>=', now())
            ->orderBy('start_at', 'asc')
            ->paginate(6, ['*'], 'upcoming_page');

        $past = Agenda::where(function ($q) {
                $q->where('status', 'completed')
                  ->orWhere('start_at', '<', now());
            })
            ->orderBy('start_at', 'desc')
            ->paginate(6, ['*'], 'past_page');

        return view('public.agenda.index', compact('upcoming', 'past'));
    }

    public function show(Agenda $agenda)
    {
        $related = Agenda::where('id', '!=', $agenda->id)
            ->orderBy('start_at', 'desc')
            ->take(3)
            ->get();

        return view('public.agenda.show', compact('agenda', 'related'));
    }
}
