@extends('layouts.admin')

@push('title')
  <title>NihonSkuy - Pertanyaan Interview User</title>
@endpush

@php
  // load semua pertanyaan yang tersimpan
  $listOfQuestions = config("form.listOfInterviewQuestions")
@endphp

@section('content')

  <div class="mb-5">
    <nav class="mb-4 text-sm" aria-label="Breadcrumb">
      <ol class="flex items-center gap-2 text-slate-500">
        <li>
          <a href="#" class="hover:text-slate-700">Dashboard</a>
        </li>
        <li class="flex items-center gap-2">
          <span class="text-slate-400">/</span>
          <a href="{{ route('admin.users') }}" class="hover:text-slate-700">Users</a>
        </li>
        <li class="flex items-center gap-2">
          <span class="text-slate-400">/</span>
          <a href="{{ route('admin.users.detail', $user->id) }}" class="hover:text-slate-700">Detail User</a>
        </li>
        <li class="flex items-center gap-2">
          <span class="text-slate-400">/</span>
          <span class="font-medium text-slate-700">Pertanyaan Interview</span>
        </li>
      </ol>
    </nav>

    <div>
      <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
        Pertanyaan Interview
      </h1>
      <p class="mt-2 text-sm text-slate-500">
        Pertanyaan seputar latar belakang kerja dan motivasi kandidat pergi ke Jepang
      </p>
    </div>
  </div>

  <x-form-wizard :candidateId="$user->id" />

  <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">

    <form method="POST" action="{{ route('admin.users.interview-answer.store', $user->id) }}" class="space-y-6 p-4 sm:p-6">
      @csrf


      @foreach ($listOfQuestions as $question)
      <section class="rounded-2xl border border-slate-200 bg-slate-50/70 p-4 sm:p-5">
        <div class="space-y-4">
          <div>
            <label class="text-sm font-medium text-slate-700" for="field">{{ $question["title"] }}</label>
            <textarea id="{{ $question['id'] }}" name="{{ $question['id'] }}" rows="5"
              class="mt-2 block w-full rounded-xl border bg-white px-3 py-2.5 text-sm text-slate-900 shadow-sm placeholder:text-slate-400 focus:outline-none focus:ring-2 min-h-35 resize-y border-slate-300 focus:border-slate-400 focus:ring-slate-100">{{ old($question['id'], $interviewAnswer[0]?->{$question['id']} ?? '') }}</textarea>
            @error($question['id'])
              <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
          </div>
        </div>
      </section>
      @endforeach

      <div class="flex flex-col gap-3 border-t border-slate-200 pt-4 sm:flex-row sm:items-center sm:justify-between">

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
          <button type="submit"
            class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800 cursor-pointer">
            Simpan
          </button>
        </div>
      </div>
    </form>
  </section>
@endsection

@section('scripts')
  <script type="module">
    @if(session()->has('success-msg'))
      Swal.fire({
        icon: 'success',           // Show your icon
        title: 'Berhasil Disimpan', // Show the header
      });
    @endif
  </script>
@endsection
