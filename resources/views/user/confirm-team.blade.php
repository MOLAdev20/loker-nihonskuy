@extends('layouts.user-dashboard')

@section('title', 'Konfirmasi Tim Kami - Nihonskuy')

@section('content_header', 'Konfirmasi Ke Tim Kami')

@section('content_subheader', 'Jika data sudah diisi, silahkan konfirmasi ke tim kami dengan menekam tombol whatsapp yang tertera')

@section('content')
  @if (session('status'))
    <div
      class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
      {{ session('status') }}
    </div>
  @endif

  <x-form-wizard :steps="$wizardSteps" />

  <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6 text-center">
    <h1>Klik tombol berikut untuk diarahkan ke Tim Kami untuk melakukan konfirmasi</h1>
    <div class="mt-3">
      <a href="{{ $waLink }}" target="_blank" class="inline-block p-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200">
        <div class="flex items-center justify-center gap-2">
          <x-icons.verifiedCircle class="w-5 h-5 shrink-0" />
          <span class="font-medium">Konfirmasi Ke Tim Kami</span>
        </div>
      </a>
    </div>
  </div>
@endsection
