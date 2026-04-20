<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @stack('title')
  @vite('resources/css/app.css')
  @stack('styles')
</head>

<body class="h-full bg-slate-50 text-slate-900">
  @include('admin.partials.sidebar')
  @include('admin.partials.topbar')

  <!-- Main -->
  <main class="pt-16 lg:pl-64">
    <!-- Content wrapper -->
    <div class="mx-auto min-h-[calc(100vh-4rem)] max-w-screen-2xl px-4 py-6">
      @yield('content')
    </div>
  </main>

  <!-- Main script, for folding sidebar -->
  @vite('resources/js/admin.js')
  @yield('scripts')
</body>

</html>
