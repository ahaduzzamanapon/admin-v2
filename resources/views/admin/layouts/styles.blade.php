<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<style>
    @php
        $themeSettings = \App\Models\ThemeSetting::pluck('value', 'key')->toArray();
    @endphp

    :root {
        --primary-color: {{ $themeSettings['primary_color'] ?? '#4f46e5' }};
        --danger-color: {{ $themeSettings['danger_color'] ?? '#dc3545' }};
        --body-text-color: {{ $themeSettings['body_text_color'] ?? '#212529' }};
        --body-bg-color: {{ $themeSettings['body_bg_color'] ?? '#f8f9fa' }};
        --sidebar-bg: {{ $themeSettings['sidebar_bg'] ?? '#111827' }};
        --sidebar-text-color: {{ $themeSettings['sidebar_text_color'] ?? '#9ca3af' }};
        --active-menu-bg: {{ $themeSettings['active_menu_bg'] ?? 'rgba(255,255,255,0.1)' }};
        --hover-menu-bg: {{ $themeSettings['hover_menu_bg'] ?? 'rgba(255,255,255,0.1)' }};
        --active-menu-text-color: {{ $themeSettings['active_menu_text_color'] ?? '#ffffff' }};
        --card-bg: {{ $themeSettings['card_bg'] ?? '#ffffff' }};
        --table-header-bg: {{ $themeSettings['table_header_bg'] ?? '#f8f9fa' }};
        --table-header-text-color: {{ $themeSettings['table_header_text_color'] ?? '#212529' }};
        --table-font-size: {{ $themeSettings['table_font_size'] ?? '16' }}px;
        --navbar-bg: {{ $themeSettings['navbar_bg'] ?? '#ffffff' }};
        --navbar-text-color: {{ $themeSettings['navbar_text_color'] ?? '#212529' }};
    }

    body {
        font-family: 'Inter', sans-serif;
        color: var(--body-text-color);
        background-color: var(--body-bg-color);
        overflow-x: hidden;
    }
    
    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-danger {
        background-color: var(--danger-color);
        border-color: var(--danger-color);
    }

    .card {
        background-color: var(--card-bg);
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: transform 0.2s ease-in-out;
    }

    .card:hover {
        transform: translateY(-2px);
    }

    .table thead th {
        background-color: var(--table-header-bg);
        color: var(--table-header-text-color);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        border-bottom: 2px solid rgba(0,0,0,0.05);
    }

    .table th, .table td {
        font-size: var(--table-font-size);
        vertical-align: middle;
        padding: 0.5rem 0.5rem;
    }

    #wrapper {
        display: flex;
        width: 100%;
        align-items: stretch;
    }
    .sidebar {
        min-width: 260px;
        max-width: 260px;
        min-height: 100vh;
        background-color: var(--sidebar-bg);
        color: var(--sidebar-text-color);
        transition: all 0.3s ease-in-out;
        box-shadow: 4px 0 24px rgba(0,0,0,0.05);
        z-index: 1000;
    }
    
    @media (max-width: 768px) {
        .sidebar {
            margin-left: -260px;
        }
        #wrapper.toggled .sidebar {
            margin-left: 0;
        }
    }

    @media (min-width: 769px) {
        #wrapper.toggled .sidebar {
            margin-left: -260px;
        }
    }

    .sidebar .nav-link {
        color: var(--sidebar-text-color);
        padding: 0.5rem 0.75rem;
        margin: 0.125rem 0.5rem;
        border-radius: 0.375rem;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        font-weight: 500;
        font-size: 0.9rem;
    }
    
    .sidebar .nav-link i {
        margin-right: 0.75rem;
        font-size: 1.1rem;
        opacity: 0.8;
    }

    .sidebar .nav-link:hover {
        color: var(--active-menu-text-color);
        background-color: var(--hover-menu-bg);
        transform: translateX(4px);
    }
    
    .sidebar .nav-link.active {
        color: var(--active-menu-text-color);
        background-color: var(--active-menu-bg);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    
    .navbar {
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        backdrop-filter: blur(8px);
    }
    
    .dropdown-menu {
        border: none;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        border-radius: 0.5rem;
    }
    
    .dropdown-item {
        padding: 0.5rem 1rem;
        font-weight: 500;
    }
    
    .dropdown-item:active {
        background-color: var(--primary-color);
    }

    .dropdown-icon {
        transition: transform 0.2s ease-in-out;
    }

    /* Fixed Layout & Scrolling */
    html, body {
        height: 100%;
        overflow: hidden;
    }

    #wrapper {
        height: 100%;
        overflow: hidden;
    }

    #page-content-wrapper {
        height: 100%;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    main {
        flex: 1;
        overflow: hidden;
        padding: 1rem;
        display: flex;
        flex-direction: column;
    }

    .container-fluid {
        height: 100%;
        display: flex;
        flex-direction: column;
        padding-bottom: 1rem;
    }

    /* Make the main card take available space */
    .container-fluid > .card {
        flex: 1;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        margin-bottom: 0 !important; /* Override mb-4 */
    }

    .container-fluid > .card > .card-body {
        flex: 1;
        overflow-y: auto;
        padding: 0; /* Remove padding to let table hit edges */
    }
    
    /* For Dashboard rows, allow them to scroll if needed, or fit */
    .container-fluid > .row {
        overflow-y: auto;
        flex: 1;
    }

    /* Sticky Table Headers */
    .table-responsive {
        height: 100%;
        overflow-y: auto;
    }

    .table thead th {
        position: sticky;
        top: -1px;
        z-index: 10;
        background-color: var(--table-header-bg);
        box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.1);
        font-size: 16px;
        font-weight: bolder;
    }
    
    /* Adjust table padding since we removed card-body padding */
    .table th, .table td {
        padding: 0.75rem 1rem;
    }
</style>
