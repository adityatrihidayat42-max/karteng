@extends('layouts.admin')

@section('page-title', 'Edit Agenda Kegiatan')

@section('content')
<div class="max-w-3xl mx-auto space-y-5">
    <a href="{{ route('admin.agendas.index') }}" class="text-xs font-semibold text-gray-500 hover:text-emerald-700">
        &larr; Kembali ke Daftar Agenda
    </a>

    <div class="bg-white rounded-2xl p-6 sm:p-8 border border-gray-100 shadow-sm">
        <form action="{{ route('admin.agendas.update', $agenda->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Judul Agenda <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $agenda->title) }}" required
                       class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:bg-white focus:border-emerald-600 outline-none">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Waktu Mulai <span class="text-red-500">*</span></label>
                    <input type="datetime-local" name="start_at" value="{{ old('start_at', $agenda->start_at ? $agenda->start_at->format('Y-m-d\TH:i') : '') }}" required
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Waktu Selesai</label>
                    <input type="datetime-local" name="end_at" value="{{ old('end_at', $agenda->end_at ? $agenda->end_at->format('Y-m-d\TH:i') : '') }}"
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 mb-1">Lokasi</label>
                    <input type="text" name="location" value="{{ old('location', $agenda->location) }}"
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Penyelenggara</label>
                    <input type="text" name="organizer" value="{{ old('organizer', $agenda->organizer) }}"
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Status Kegiatan</label>
                    <select name="status" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">
                        <option value="upcoming" {{ $agenda->status === 'upcoming' ? 'selected' : '' }}>Mendatang (Upcoming)</option>
                        <option value="ongoing" {{ $agenda->status === 'ongoing' ? 'selected' : '' }}>Sedang Berlangsung</option>
                        <option value="completed" {{ $agenda->status === 'completed' ? 'selected' : '' }}>Selesai (Completed)</option>
                        <option value="cancelled" {{ $agenda->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Ganti Poster / Foto</label>
                    <input type="file" name="image" accept="image/*" class="text-xs text-gray-500 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:bg-emerald-50 file:text-emerald-700">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Deskripsi & Rincian Agenda</label>
                <textarea name="description" rows="4" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none">{{ old('description', $agenda->description) }}</textarea>
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('admin.agendas.index') }}" class="px-4 py-2 text-xs font-bold text-gray-500">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-bold shadow">
                    Perbarui Agenda
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
