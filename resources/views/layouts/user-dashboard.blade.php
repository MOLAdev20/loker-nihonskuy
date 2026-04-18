<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'User Dashboard')</title>
  @vite('resources/css/app.css')
  @stack('styles')
</head>

<body class="min-h-screen bg-[#f7f7f5] text-slate-900">
  @include('user.partials.dashboard-sidebar')
  @include('user.partials.dashboard-topbar')

  <main class="lg:pl-76 min-h-screen px-4 pb-6 pt-20 sm:px-6 lg:pr-8">
    <div class="mx-auto w-full max-w-7xl">
      <section class="rounded-2xl border border-slate-200 bg-white px-4 py-5 shadow-sm sm:px-6">
        <h1 class="text-lg font-semibold tracking-tight text-slate-900 sm:text-xl">
          @yield('content_header', 'Dashboard User')
        </h1>
        <p class="mt-1 text-sm text-slate-500">
          @yield('content_subheader', 'Kelola aktivitas akun dari satu tempat.')
        </p>
      </section>

      <section class="mt-6">
        @yield('content')
      </section>
    </div>
  </main>

  @include('user.partials.dashboard-modal')

  @vite('resources/js/user-dashboard.js')
  @stack('scripts')
</body>

</html>
