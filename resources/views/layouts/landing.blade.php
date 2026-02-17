<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    @yield("header")
</head>

<body class="bg-slate-50 text-slate-900 antialiased">
    @include("components.topbar")
    <main class="noise">

        @yield("content")
        @include("components.footer")

    </main>
    @yield("scripts")
</body>

</html>
