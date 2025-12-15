<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel</title>
    @include('admin.layouts.styles')
</head>
<body class="bg-light">
<div class="d-flex" id="wrapper">
    @include('admin.layouts.sidebar')
    
    <div id="page-content-wrapper" class="w-100">
        @include('admin.layouts.navbar')
        <main class="p-4">
            @yield('content')
        </main>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarToggle = document.getElementById('sidebarToggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function (event) {
                event.preventDefault();
                document.getElementById('wrapper').classList.toggle('toggled');
            });
        }
    });
</script>
</body>
</html>
