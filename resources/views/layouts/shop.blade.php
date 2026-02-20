<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Shop') — {{ config('app.name') }}</title>
    <meta name="description" content="@yield('meta_description', 'Shop the latest products.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary:
                {{ $themeSettings['primary_color'] ?? '#1a6dc5' }}
            ;
            --primary-dark: #1558a8;
            --primary-light: #e8f0fc;
            --surface: #ffffff;
            --surface-2: #f5f7fa;
            --surface-3: #eef1f6;
            --border: #e2e8f0;
            --text: #1a202c;
            --text-muted: #64748b;
            --text-light: #94a3b8;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --radius: 8px;
            --radius-sm: 6px;
            --shadow: 0 1px 4px rgba(0, 0, 0, .08);
            --shadow-md: 0 4px 16px rgba(0, 0, 0, .1);
            --shadow-lg: 0 10px 40px rgba(0, 0, 0, .14);
            --transition: all .18s ease;
            --nav-height: 56px;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text);
            background: var(--surface-2);
            line-height: 1.5;
            font-size: 14px;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        img {
            max-width: 100%;
            display: block;
        }

        button,
        input,
        select,
        textarea {
            font-family: inherit;
        }

        ul {
            list-style: none;
        }

        /* ── Container ── */
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 16px;
        }

        /* ═══════════════════════════════════════════════
           TOP BAR
        ═══════════════════════════════════════════════ */
        .topbar {
            background: #fff;
            border-bottom: 1px solid var(--border);
            padding: 10px 0;
        }

        .topbar-inner {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        /* Logo */
        .topbar-brand {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--primary);
            flex-shrink: 0;
            min-width: 180px;
        }

        .topbar-brand i {
            font-size: 1.5rem;
        }

        .topbar-brand-sub {
            font-size: .6rem;
            font-weight: 400;
            color: var(--text-muted);
            display: block;
            line-height: 1;
        }

        /* Search */
        .topbar-search {
            flex: 1;
            display: flex;
            align-items: center;
            border: 2px solid var(--primary);
            border-radius: 24px;
            overflow: hidden;
            background: #fff;
        }

        .topbar-search input {
            flex: 1;
            border: none;
            outline: none;
            padding: 9px 18px;
            font-size: .9rem;
            color: var(--text);
            background: transparent;
        }

        /* ─── ANIMATIONS ─── */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulseBadge {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
            }

            70% {
                transform: scale(1);
                box-shadow: 0 0 0 6px rgba(239, 68, 68, 0);
            }

            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
            }
        }

        @keyframes kenBurns {
            0% {
                transform: scale(1);
            }

            100% {
                transform: scale(1.15);
            }
        }

        @keyframes flowGradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes floatIcon {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.5, 0, 0, 1);
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        .topbar-search input::placeholder {
            color: var(--text-light);
        }

        .topbar-search button {
            padding: 9px 20px;
            background: var(--primary);
            border: none;
            color: #fff;
            cursor: pointer;
            font-size: .95rem;
            transition: var(--transition);
        }

        .topbar-search button:hover {
            background: var(--primary-dark);
        }

        /* Right icons */
        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .topbar-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            background: transparent;
            border: none;
            text-decoration: none;
        }

        .topbar-icon:hover {
            background: var(--surface-3);
            color: var(--primary);
        }

        .topbar-icon-badge {
            position: absolute;
            top: 3px;
            right: 3px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: var(--primary);
            color: #fff;
            font-size: .6rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .topbar-divider {
            width: 1px;
            height: 24px;
            background: var(--border);
            margin: 0 4px;
        }

        .topbar-auth {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .topbar-auth a {
            font-size: .85rem;
            font-weight: 600;
            color: var(--text-muted);
            padding: 6px 10px;
            border-radius: var(--radius-sm);
            transition: var(--transition);
        }

        .topbar-auth a:hover {
            color: var(--primary);
        }

        .topbar-auth-sep {
            color: var(--border);
        }

        /* Cart widget */
        .cart-widget {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--primary);
            color: #fff;
            padding: 8px 14px;
            border-radius: var(--radius);
            cursor: pointer;
            text-decoration: none;
            transition: var(--transition);
            flex-shrink: 0;
        }

        .cart-widget:hover {
            background: var(--primary-dark);
        }

        .cart-widget-icon {
            font-size: 1.1rem;
        }

        .cart-widget-info {
            font-size: .8rem;
        }

        .cart-widget-total {
            font-weight: 700;
            font-size: .9rem;
        }

        /* Floating Cart */
        .floating-cart {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: var(--primary);
            color: #fff;
            padding: 12px 22px;
            border-radius: 50px;
            box-shadow: var(--shadow-lg);
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 1000;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            opacity: 0;
            transform: translateY(100px) scale(0.8);
            visibility: hidden;
            text-decoration: none;
            border: 2px solid rgba(255, 255, 255, 0.1);
        }

        .floating-cart.visible {
            opacity: 1;
            transform: translateY(0) scale(1);
            visibility: visible;
        }

        .floating-cart:hover {
            background: var(--primary-dark);
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
            color: #fff;
        }

        .floating-cart-icon {
            font-size: 1.3rem;
            position: relative;
            display: flex;
            align-items: center;
        }

        .floating-cart-badge {
            position: absolute;
            top: -8px;
            right: -10px;
            background: var(--danger);
            color: #fff;
            font-size: 0.7rem;
            font-weight: 700;
            min-width: 18px;
            height: 18px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 4px;
            border: 2px solid var(--primary);
        }

        .floating-cart-text {
            font-weight: 800;
            font-size: 1rem;
            letter-spacing: -0.2px;
        }

        /* ═══════════════════════════════════════════════
           SECONDARY NAV
        ═══════════════════════════════════════════════ */
        .sec-nav {
            background: var(--primary);
            height: var(--nav-height);
            position: sticky;
            top: 0;
            z-index: 900;
        }

        .sec-nav-inner {
            display: flex;
            align-items: stretch;
            height: 100%;
        }

        /* Categories dropdown trigger */
        .cat-dropdown-trigger {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(0, 0, 0, .15);
            padding: 0 20px;
            color: #fff;
            font-weight: 700;
            font-size: .9rem;
            cursor: pointer;
            flex-shrink: 0;
            transition: var(--transition);
            border: none;
            user-select: none;
        }

        .cat-dropdown-trigger:hover {
            background: rgba(0, 0, 0, .25);
        }

        .cat-dropdown-trigger .see-all {
            font-size: .75rem;
            font-weight: 400;
            opacity: .8;
        }

        /* Nav links */
        .sec-nav-links {
            display: flex;
            align-items: center;
            flex: 1;
        }

        .sec-nav-links a {
            display: flex;
            align-items: center;
            height: 100%;
            padding: 0 16px;
            color: rgba(255, 255, 255, .9);
            font-weight: 500;
            font-size: .88rem;
            transition: var(--transition);
            white-space: nowrap;
        }

        .sec-nav-links a:hover,
        .sec-nav-links a.active {
            background: rgba(0, 0, 0, .15);
            color: #fff;
        }

        /* ═══════════════════════════════════════════════
           CATEGORY SIDEBAR
        ═══════════════════════════════════════════════ */
        .cat-sidebar {
            position: absolute;
            top: var(--nav-height);
            left: 0;
            width: 240px;
            background: #fff;
            border: 1px solid var(--border);
            border-top: none;
            box-shadow: var(--shadow-lg);
            z-index: 800;
            display: none;
        }

        .cat-sidebar.open {
            display: block;
        }

        .cat-sidebar-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 18px;
            border-bottom: 1px solid #f1f5f9;
            font-size: .875rem;
            cursor: pointer;
            transition: var(--transition);
            color: var(--text);
        }

        .cat-sidebar-item:hover {
            background: var(--primary-light);
            color: var(--primary);
        }

        .cat-sidebar-item i {
            width: 16px;
            color: var(--text-muted);
            font-size: .85rem;
        }

        .cat-sidebar-item:hover i {
            color: var(--primary);
        }

        /* ═══════════════════════════════════════════════
           HOME LAYOUT: sidebar + main
        ═══════════════════════════════════════════════ */
        .home-layout {
            display: grid;
            grid-template-columns: 240px 1fr;
            gap: 0;
            align-items: start;
            position: relative;
        }

        .home-sidebar {
            background: #fff;
            border: 1px solid var(--border);
            border-top: none;
            height: 420px;
            overflow-y: auto;
            scrollbar-width: thin;
        }

        .home-sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .home-sidebar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .home-sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .home-sidebar-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 18px;
            border-bottom: 1px solid #f1f5f9;
            font-size: .875rem;
            cursor: pointer;
            transition: var(--transition);
            color: var(--text);
        }

        .home-sidebar-item:hover {
            background: var(--primary-light);
            color: var(--primary);
            padding-left: 22px;
        }

        .home-sidebar-item i {
            width: 16px;
            color: var(--text-muted);
            font-size: .8rem;
        }

        /* ═══════════════════════════════════════════════
           HERO BANNER
        ═══════════════════════════════════════════════ */
        .hero-area {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .hero-slider {
            position: relative;
            overflow: hidden;
            background: #1a2a4a;
            min-height: 380px;
            width: 100%;
            display: block;
        }

        /* All slides stacked; only active one visible */
        .hero-slide {
            position: absolute;
            inset: 0;
            opacity: 0;
            pointer-events: none;
            transition: opacity .6s ease;
            display: flex;
            align-items: center;
            width: 100%;
            height: 100%;
        }

        /* Spacer that keeps the container height */
        .hero-slider-spacer {
            display: block;
            width: 100%;
            height: 380px;
        }

        .hero-slide.active {
            opacity: 1;
            pointer-events: auto;
        }

        .hero-slide-img {
            position: absolute;
            inset: 0;
            z-index: 0;
        }

        .hero-slide-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hero-slide-overlay {
            position: absolute;
            inset: 0;
            z-index: 1;
            background: linear-gradient(135deg, rgba(10, 20, 50, .75) 0%, rgba(10, 20, 50, .3) 60%, transparent 100%);
        }

        .hero-slide-content {
            position: relative;
            z-index: 2;
            padding: 48px 56px;
            color: #fff;
        }

        .hero-slide-tag {
            font-size: .75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            opacity: .8;
            margin-bottom: 12px;
        }

        .hero-slide-title {
            font-size: 3.2rem;
            font-weight: 900;
            line-height: 1.05;
            text-shadow: 0 2px 20px rgba(0, 0, 0, .4);
            margin-bottom: 8px;
        }

        .hero-slide-sub {
            font-size: 1rem;
            opacity: .85;
            margin-bottom: 24px;
        }

        .hero-cta {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--primary);
            color: #fff;
            padding: 12px 28px;
            border-radius: var(--radius);
            font-weight: 700;
            font-size: .9rem;
            transition: var(--transition);
        }

        .hero-cta:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        /* Hero Animation Styles */
        .hero-bg {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            transform: scale(1);
            transition: transform 0.5s ease;
        }

        .hero-slide.active .hero-bg {
            animation: kenBurns 8s ease-out forwards;
        }

        .hero-slide-content>* {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.8s ease;
        }

        .hero-slide.active .hero-slide-content>* {
            opacity: 1;
            transform: translateY(0);
        }

        .hero-slide.active .hero-slide-tag {
            transition-delay: 0.1s;
        }

        .hero-slide.active .hero-slide-title {
            transition-delay: 0.3s;
        }

        .hero-slide.active .hero-slide-sub {
            transition-delay: 0.5s;
        }

        .hero-slide.active .hero-cta {
            transition-delay: 0.7s;
        }

        /* Slider nav dots */
        .hero-dots {
            position: absolute;
            bottom: 16px;
            right: 20px;
            display: flex;
            gap: 6px;
            z-index: 10;
        }

        .hero-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .5);
            cursor: pointer;
            transition: var(--transition);
            border: none;
        }

        .hero-dot.active {
            background: #fff;
            width: 20px;
            border-radius: 4px;
        }

        /* ═══════════════════════════════════════════════
           FEATURE STRIP
        ═══════════════════════════════════════════════ */
        .feature-strip {
            background: #fff;
            border: 1px solid var(--border);
            border-top: 3px solid var(--primary);
            padding: 0;
        }

        .feature-strip-inner {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 20px;
            border-right: 1px solid var(--border);
        }

        .feature-item:last-child {
            border-right: none;
        }

        .feature-icon {
            font-size: 1.5rem;
            color: var(--primary);
            flex-shrink: 0;
        }

        .feature-label {
            font-weight: 700;
            font-size: .85rem;
            margin-bottom: 2px;
        }

        .feature-sub {
            font-size: .75rem;
            color: var(--text-muted);
        }

        /* ═══════════════════════════════════════════════
           SECTION
        ═══════════════════════════════════════════════ */
        .section {
            padding: 40px 0;
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            border-bottom: 2px solid var(--primary);
            padding-bottom: 10px;
        }

        .section-title {
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title::before {
            content: '';
            display: block;
            width: 4px;
            height: 18px;
            background: var(--primary);
            border-radius: 2px;
        }

        .view-all {
            font-size: .8rem;
            font-weight: 600;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .view-all:hover {
            text-decoration: underline;
        }

        /* ═══════════════════════════════════════════════
           PRODUCT CARD
        ═══════════════════════════════════════════════ */
        .grid-5 {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 12px;
        }

        .grid-4 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }

        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .product-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            transition: var(--transition);
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
            border-color: var(--primary);
        }

        /* Shine effect container */
        .product-card-img::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(to right, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.3) 50%, rgba(255, 255, 255, 0) 100%);
            transform: skewX(-25deg);
            transition: none;
            pointer-events: none;
        }

        .product-card:hover .product-card-img::after {
            left: 150%;
            transition: all 0.7s;
        }

        .product-card-img {
            position: relative;
            overflow: hidden;
            background: var(--surface-3);
            aspect-ratio: 1/1;
        }

        .product-card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .35s ease;
        }

        .product-card:hover .product-card-img img {
            transform: scale(1.05);
        }

        .product-card-badge {
            position: absolute;
            top: 8px;
            left: 8px;
            font-size: .65rem;
            font-weight: 700;
            padding: 3px 7px;
            border-radius: 3px;
            background: var(--primary);
            color: #fff;
        }

        .product-card-badge.out {
            background: #6b7280;
        }

        .product-card-badge.new {
            background: #10b981;
        }

        .product-card-actions {
            position: absolute;
            top: 8px;
            right: -40px;
            display: flex;
            flex-direction: column;
            gap: 6px;
            transition: var(--transition);
        }

        .product-card:hover .product-card-actions {
            right: 8px;
        }

        .product-card-action {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #fff;
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            font-size: .8rem;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
        }

        .product-card-action:hover {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }

        .product-card-body {
            padding: 10px 12px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .product-card-category {
            font-size: .68rem;
            color: var(--primary);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .product-card-name {
            font-size: .85rem;
            font-weight: 600;
            color: var(--text);
            line-height: 1.4;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .product-card-price {
            font-size: 1rem;
            font-weight: 800;
            color: var(--primary);
            margin-top: auto;
            padding-top: 6px;
        }

        .product-card-footer {
            padding: 8px 12px;
            border-top: 1px solid var(--surface-3);
            display: flex;
            gap: 6px;
        }

        .btn-add-cart {
            flex: 1;
            padding: 7px 0;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            font-size: .78rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .btn-add-cart:hover {
            background: var(--primary-dark);
        }

        .btn-add-cart:disabled {
            background: #9ca3af;
            cursor: not-allowed;
        }

        /* ═══════════════════════════════════════════════
           CATEGORY CARDS
        ═══════════════════════════════════════════════ */
        .cat-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 20px 12px;
            text-align: center;
            transition: var(--transition);
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .cat-card:hover {
            border-color: var(--primary);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transform: translateY(-5px);
        }

        .cat-card:hover .cat-card-icon {
            background: var(--primary);
            color: #fff;
            animation: floatIcon 2s ease-in-out infinite;
        }

        .cat-card-icon {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: var(--primary);
        }

        .cat-card-name {
            font-size: .8rem;
            font-weight: 700;
            color: var(--text);
        }

        .cat-card-count {
            font-size: .7rem;
            color: var(--text-muted);
        }

        /* ═══════════════════════════════════════════════
           MISC / UTILS
        ═══════════════════════════════════════════════ */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .3px;
        }

        .badge-pending {
            background: #fff7ed;
            color: #c2410c;
        }

        .badge-confirmed {
            background: #eff6ff;
            color: #1d4ed8;
        }

        .badge-packed {
            background: #f5f3ff;
            color: #6d28d9;
        }

        .badge-out_for_delivery {
            background: #ecfdf5;
            color: #065f46;
        }

        .badge-delivered {
            background: #dcfce7;
            color: #15803d;
        }

        .badge-cancelled {
            background: #fef2f2;
            color: #b91c1c;
        }

        .badge-returned {
            background: #fef9c3;
            color: #854d0e;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 22px;
            border-radius: var(--radius);
            font-size: .9rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            border: none;
        }

        .btn-primary {
            background: var(--primary);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .btn-secondary {
            background: var(--surface-3);
            color: var(--text);
        }

        .btn-secondary:hover {
            background: var(--border);
        }

        .btn-full {
            width: 100%;
            justify-content: center;
        }

        .btn-outline-primary {
            border: 1.5px solid var(--primary);
            color: var(--primary);
            background: transparent;
        }

        .btn-outline-primary:hover {
            background: var(--primary);
            color: #fff;
        }

        .card {
            background: #fff;
            border-radius: var(--radius);
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            font-size: .82rem;
            margin-bottom: 5px;
        }

        .form-control {
            width: 100%;
            padding: 10px 13px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: .9rem;
            background: #fff;
            outline: none;
            transition: var(--transition);
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(26, 109, 197, .1);
        }

        .form-error {
            font-size: .75rem;
            color: var(--danger);
            margin-top: 3px;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 80px;
        }

        .alert {
            padding: 12px 16px;
            border-radius: var(--radius-sm);
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: .875rem;
            font-weight: 500;
        }

        .alert-success {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert-info {
            background: #eff6ff;
            color: #1e40af;
            border: 1px solid #bfdbfe;
        }

        .divider {
            height: 1px;
            background: var(--border);
            margin: 20px 0;
        }

        .text-center {
            text-align: center;
        }

        .text-muted {
            color: var(--text-muted);
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: .82rem;
            color: var(--text-muted);
            padding: 12px 0;
        }

        .breadcrumb a:hover {
            color: var(--primary);
        }

        .pagination {
            display: flex;
            gap: 4px;
            justify-content: center;
            margin-top: 32px;
            flex-wrap: wrap;
        }

        .pagination a,
        .pagination span {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: var(--radius-sm);
            font-size: .82rem;
            font-weight: 600;
            border: 1.5px solid var(--border);
            transition: var(--transition);
        }

        .pagination a:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .pagination .active-page {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }

        .page-wrapper {
            min-height: 60vh;
            padding: 24px 0;
        }

        /* ═══════════════════════════════════════════════
           FOOTER
        ═══════════════════════════════════════════════ */
        .footer {
            background: #0f1d35;
            color: #8899b4;
            padding: 40px 0 20px;
            margin-top: 40px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 36px;
            margin-bottom: 32px;
        }

        .footer-brand {
            font-size: 1.2rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 10px;
        }

        .footer-desc {
            font-size: .82rem;
            line-height: 1.7;
        }

        .footer-heading {
            font-size: .72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .8px;
            color: #fff;
            margin-bottom: 14px;
        }

        .footer-links {
            display: flex;
            flex-direction: column;
            gap: 9px;
        }

        .footer-links a {
            font-size: .82rem;
            transition: var(--transition);
        }

        .footer-links a:hover {
            color: #fff;
        }

        .footer-divider {
            border: none;
            border-top: 1px solid #1e3055;
            margin-bottom: 20px;
        }

        .footer-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: .75rem;
        }

        /* Toast */
        .toast-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .toast {
            background: #1a202c;
            color: #fff;
            padding: 12px 16px;
            border-radius: var(--radius);
            font-size: .875rem;
            font-weight: 500;
            box-shadow: var(--shadow-lg);
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideIn .3s ease;
            max-width: 320px;
        }

        .toast.success {
            border-left: 4px solid #10b981;
        }

        .toast.error {
            border-left: 4px solid var(--danger);
        }

        @keyframes slideIn {
            from {
                transform: translateX(120%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .grid-5 {
                grid-template-columns: repeat(4, 1fr);
            }

            .home-layout {
                grid-template-columns: 200px 1fr;
            }
        }

        @media (max-width: 768px) {

            .grid-5,
            .grid-4 {
                grid-template-columns: repeat(2, 1fr);
            }

            .grid-3 {
                grid-template-columns: repeat(2, 1fr);
            }

            .home-layout {
                grid-template-columns: 1fr;
            }

            .home-sidebar {
                display: none;
            }

            .feature-strip-inner {
                grid-template-columns: repeat(2, 1fr);
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }

            .topbar-search {
                display: none;
            }

            .sec-nav-links a {
                padding: 0 10px;
                font-size: .8rem;
            }
        }

        @media (max-width: 480px) {

            .grid-5,
            .grid-4,
            .grid-3 {
                grid-template-columns: repeat(2, 1fr);
                gap: 8px;
            }

            .feature-strip-inner {
                grid-template-columns: 1fr;
            }
        }
    </style>
    @stack('styles')
</head>

<body>

    {{-- ═══ TOP BAR ═══ --}}
    <div class="topbar">
        <div class="container">
            <div class="topbar-inner">
                {{-- Brand --}}
                <a href="{{ route('home') }}" class="topbar-brand">
                    <i class="fa fa-bag-shopping"></i>
                    <div>
                        <span
                            style="font-size:.55rem; color:var(--text-muted); display:block; font-weight:400;">Technology</span>
                        {{ config('app.name', 'ACTIVE ECOMMERCE') }}
                    </div>
                </a>

                {{-- Search --}}
                <form action="{{ route('home') }}" method="GET" class="topbar-search">
                    <input type="text" name="q" placeholder="I am shopping for..." value="{{ request('q') }}">
                    <button type="submit"><i class="fa fa-magnifying-glass"></i></button>
                </form>

                {{-- Icons --}}
                <div class="topbar-actions">
                    <a href="#" class="topbar-icon" title="Compare"><i class="fa fa-arrows-left-right"></i></a>
                    <a href="#" class="topbar-icon" title="Wishlist"><i class="fa fa-heart"></i></a>
                </div>
                <div class="topbar-divider"></div>

                {{-- Auth --}}
                @auth
                    <a href="{{ route('account.dashboard') }}" class="topbar-icon" title="{{ auth()->user()->name }}">
                        @if(auth()->user()->avatar)
                            <img src="{{ auth()->user()->avatar }}"
                                style="width:28px;height:28px;border-radius:50%;object-fit:cover;" alt="">
                        @else
                            <i class="fa fa-circle-user" style="font-size:1.2rem;"></i>
                        @endif
                    </a>
                @else
                    <div class="topbar-auth">
                        <a href="{{ route('login') }}">Login</a>
                        <span class="topbar-auth-sep">|</span>
                        <a href="{{ route('register') }}">Registration</a>
                    </div>
                @endauth

                {{-- Cart --}}
                <a href="{{ route('cart.index') }}" class="cart-widget">
                    <span class="cart-widget-icon"><i class="fa fa-cart-shopping"></i></span>
                    <div class="cart-widget-info">
                        <div class="cart-widget-total">৳{{ number_format($cartStats['total'] ?? 0, 2) }}</div>
                        <div style="font-size:.7rem; opacity:.8;">({{ $cartStats['item_count'] ?? 0 }} Items)</div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    {{-- ═══ SECONDARY NAV ═══ --}}
    <nav class="sec-nav">
        <div class="container" style="position:relative; height:100%;">
            <div class="sec-nav-inner">
                {{-- Categories trigger --}}
                <button class="cat-dropdown-trigger" id="catTrigger" onclick="toggleCatDropdown()">
                    <i class="fa fa-bars"></i>
                    <span>Categories</span>
                    <a href="{{ route('shop.index') }}" class="see-all">(See All)</a>
                    <i class="fa fa-chevron-down" style="margin-left:4px; font-size:.75rem;"></i>
                </button>

                {{-- Nav Links --}}
                <div class="sec-nav-links">
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                    <a href="{{ route('order.track') }}">Track Order</a>
                </div>
            </div>

            {{-- Category Dropdown --}}
            <div class="cat-sidebar" id="catDropdown">
                @if(isset($categories) && $categories->isNotEmpty())
                    @foreach($categories as $cat)
                        <a href="{{ route('shop.category', $cat->slug) }}" class="cat-sidebar-item">
                            <i class="fa fa-tag"></i>
                            {{ $cat->name }}
                        </a>
                    @endforeach
                @else
                    <div class="cat-sidebar-item" style="color:var(--text-muted);">No categories</div>
                @endif
            </div>
        </div>
    </nav>

    {{-- Flash Messages --}}
    @if(session('success') || session('error'))
        <div class="toast-container" id="toastContainer">
            @if(session('success'))
                <div class="toast success" id="flashToast"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="toast error" id="flashToast2"><i class="fa fa-exclamation-circle"></i> {{ session('error') }}</div>
            @endif
        </div>
    @endif

    <div class="page-wrapper" style="padding:0;">
        @yield('content')
    </div>

    {{-- ═══ FOOTER ═══ --}}
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <div class="footer-brand">{{ config('app.name') }}</div>
                    <p class="footer-desc">Your one-stop destination for quality products at great prices. Fast
                        delivery, easy returns, cash on delivery.</p>
                </div>
                <div>
                    <div class="footer-heading">Quick Links</div>
                    <div class="footer-links">
                        <a href="{{ route('home') }}">Home</a>
                        <a href="{{ route('cart.index') }}">My Cart</a>
                        <a href="{{ route('order.track') }}">Track Order</a>
                    </div>
                </div>
                <div>
                    <div class="footer-heading">Account</div>
                    <div class="footer-links">
                        @auth
                            <a href="{{ route('account.dashboard') }}">Dashboard</a>
                            <a href="{{ route('account.orders') }}">My Orders</a>
                            <a href="{{ route('account.profile') }}">Profile</a>
                        @else
                            <a href="{{ route('login') }}">Login</a>
                            <a href="{{ route('register') }}">Register</a>
                        @endauth
                    </div>
                </div>
                <div>
                    <div class="footer-heading">Support</div>
                    <div class="footer-links">
                        <a href="{{ route('order.track') }}">Track Order</a>
                        <a href="#">Contact Us</a>
                        <a href="#">FAQ</a>
                    </div>
                </div>
            </div>
            <hr class="footer-divider">
            <div class="footer-bottom">
                <span>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved ANXSYS.</span>
                <span>Cash on Delivery &bull; Secure Shopping</span>
            </div>
        </div>
    </footer>

    <script>
        // Category dropdown toggle
        function toggleCatDropdown() {
            const d = document.getElementById('catDropdown');
            d.classList.toggle('open');
        }
        document.addEventListener('click', function (e) {
            const trigger = document.getElementById('catTrigger');
            const dropdown = document.getElementById('catDropdown');
            if (!trigger.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.remove('open');
            }
        });

        // Auto-dismiss toasts
        ['flashToast', 'flashToast2'].forEach(id => {
            const t = document.getElementById(id);
            if (t) setTimeout(() => { t.style.opacity = '0'; t.style.transform = 'translateX(120%)'; t.style.transition = 'all .4s'; }, 4000);
        });

        // Cart AJAX helper
        window.addToCart = function (productId, qty = 1) {
            const btn = event?.target?.closest('button');
            if (btn) btn.disabled = true;

            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                },
                body: JSON.stringify({ product_id: productId, qty })
            })
                .then(r => r.json())
                .then(data => {
                    if (btn) btn.disabled = false;
                    if (data.success) {
                        window.showToast('Product added to cart!', 'success');
                        // Update header widget
                        const countEl = document.querySelector('.cart-widget-info div:last-child');
                        const totalEl = document.querySelector('.cart-widget-total');
                        if (countEl) countEl.innerText = `(${data.cart_count} Items)`;
                        if (totalEl) totalEl.innerText = `৳${data.cart_total}`;

                        // Update floating cart
                        const floatBadge = document.getElementById('floatingCartBadge');
                        const floatTotal = document.getElementById('floatingCartTotal');
                        if (floatBadge) floatBadge.innerText = data.cart_count;
                        if (floatTotal) floatTotal.innerText = `৳${data.cart_total}`;
                    } else {
                        window.showToast(data.message || 'Error adding to cart', 'error');
                    }
                })
                .catch(err => {
                    if (btn) btn.disabled = false;
                    window.showToast('Could not connect to server', 'error');
                });
        };

        window.showToast = function (msg, type = 'success') {
            const c = document.getElementById('toastContainer') || (() => { const d = document.createElement('div'); d.id = 'toastContainer'; d.className = 'toast-container'; document.body.appendChild(d); return d; })();
            const t = document.createElement('div'); t.className = 'toast ' + type;
            t.innerHTML = `<i class="fa fa-${type === 'success' ? 'check' : 'exclamation'}-circle"></i> ${msg}`;
            c.appendChild(t);
            setTimeout(() => { t.style.opacity = '0'; t.style.transform = 'translateX(120%)'; t.style.transition = 'all .4s'; setTimeout(() => t.remove(), 400); }, 3500);
        };

        // Floating Cart scroll logic
        window.addEventListener('scroll', function () {
            const floatingCart = document.getElementById('floatingCart');
            if (window.scrollY > 250) {
                floatingCart.classList.add('visible');
            } else {
                floatingCart.classList.remove('visible');
            }

            // Reveal elements on scroll
            document.querySelectorAll('.reveal').forEach(el => {
                const rect = el.getBoundingClientRect();
                if (rect.top < window.innerHeight - 100) {
                    el.classList.add('active');
                }
            });
        });

        // Trigger reveals on load
        setTimeout(() => {
            window.dispatchEvent(new Event('scroll'));
        }, 100);
    </script>
    <a href="{{ route('cart.index') }}" class="floating-cart" id="floatingCart">
        <div class="floating-cart-icon">
            <i class="fa fa-cart-shopping"></i>
            <span class="floating-cart-badge" id="floatingCartBadge">{{ $cartStats['item_count'] ?? 0 }}</span>
        </div>
        <div class="floating-cart-text" id="floatingCartTotal">৳{{ number_format($cartStats['total'] ?? 0, 2) }}</div>
    </a>

    @stack('scripts')
</body>

</html>