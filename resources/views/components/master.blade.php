<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iHelpBD | Appointment Management - {{ $title ?? '' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"
        referrerpolicy="no-referrer" />

    <style>
        /* === FONT IMPORT === */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;900&display=swap');

        /* === GLOBAL VARIABLES === */
        /* Light mode variables */
        html[data-bs-theme="light"] {
            --accent-color: #00a7a7;
            --accent-alt: #ff0078;
            --sidebar-bg: rgba(213, 212, 213, 0.85);
            --sidebar-border: rgba(0, 0, 0, 0.1);
            --glass-bg: rgba(255, 255, 255, 0.35);
            --glass-border: rgba(0, 0, 0, 0.1);
            --text-color: #111;
            --text-secondary: #555;
        }

        /* Override body background for light mode */
        html[data-bs-theme="light"] body {
            background: #f5f5f5;
        }

        html[data-bs-theme="light"] .sidebar-brand {
            text-shadow: none;
            color: cadetblue;
        }

        :root {
            --transition-speed: 0.4s;
            --accent-color: #00f5ff;
            --accent-alt: #ff0078;
            --sidebar-bg: rgba(15, 20, 30, 0.75);
            --sidebar-border: rgba(255, 255, 255, 0.05);
            --glass-bg: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
            --text-color: #e4e4e4;
            --text-secondary: #bfc8d8;
            --sidebar-width: 240px;
        }

        /* Light Mode Variables */
        html[data-bs-theme="light"] .glassy-card {
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.3);
            border-radius: 10px;
        }

        /* Light Mode Variables */
        html[data-bs-theme="light"] .sidebar .nav-link {
            background: rgba(255, 255, 255, 0.65);
            box-shadow:
                0 2px 5px rgba(0, 0, 0, 0.05),
                inset 0 1px 1px rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(0, 0, 0, 0.04);
            backdrop-filter: blur(6px);
        }

        html[data-bs-theme="light"] .offcanvas {
            background: #fff !important;
            box-shadow:
                0 2px 5px rgba(0, 0, 0, 0.05),
                inset 0 1px 1px rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(0, 0, 0, 0.04);
            backdrop-filter: blur(6px);
        }

        html[data-bs-theme="light"] .offcanvas .cancel-btn {
            color: #000;
        }

        html[data-bs-theme="light"] .offcanvas .btn-close-white {
            color: #000 !important;
        }

        /* html[data-bs-theme="light"] .offcanvas{
            background: rgba(255, 255, 255, 0.65) !important;
        color: #000 ;
        } */
        html[data-bs-theme="light"] .offcanvas label {
            /* background: rgba(255, 255, 255, 0.65) !important; */
            color: #000 !important;
        }

        html[data-bs-theme="light"] .offcanvas .offcanvas-header {
            /* background: rgba(255, 255, 255, 0.65) !important; */
            color: #000 !important;
        }

        /* html[data-bs-theme="light"] .offcanvas input,select,option{
          color: #000 !important;
        }

 */
        option {
            color: #000 !important;
        }

        /* === GLOBAL === */
        body {
            background: var(--bg-dark);
            color: var(--text-color);
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            position: relative;
        }

        /* Subtle glowing animated background orbs */
        body::before,
        body::after {
            content: "";
            position: fixed;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.25;
            z-index: 0;
        }

        body::before {
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, var(--accent-alt), transparent 70%);
            top: -150px;
            left: -200px;
            animation: glowShift 10s ease-in-out infinite alternate;
        }

        body::after {
            width: 700px;
            height: 700px;
            background: radial-gradient(circle, var(--accent-color), transparent 70%);
            bottom: -200px;
            right: -200px;
            animation: glowShift2 12s ease-in-out infinite alternate;
        }

        @keyframes glowShift {
            from {
                transform: translate(0, 0);
            }

            to {
                transform: translate(50px, 70px);
            }
        }

        @keyframes glowShift2 {
            from {
                transform: translate(0, 0);
            }

            to {
                transform: translate(-50px, -70px);
            }
        }

        /* === SIDEBAR === */
        /* === GLASSY DARK SIDEBAR === */

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border-right: 1px solid var(--sidebar-border);
            /* box-shadow: 6px 0 25px rgba(0, 0, 0, 0.6); */
            padding: 1rem 0.6rem;
            z-index: 1050;
            color: var(--text-color);
            transition: background var(--transition-speed), color var(--transition-speed), border var(--transition-speed);
        }

        /* Brand */
        .sidebar-brand {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--accent-color);
            text-align: center;
            text-shadow: 0 0 12px var(--accent-color);
            margin-bottom: 1.2rem;
        }

        /* Nav Links */
        .sidebar .nav-link {
            color: var(--text-secondary);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 0.3rem 0.6rem;
            transition: all 0.25s ease;
            font-weight: 500;
            background: rgba(255, 255, 255, 0.03);
            box-shadow:
                inset 1px 1px 2px rgba(255, 255, 255, 0.15),
                inset -1px -1px 2px rgba(0, 0, 0, 0.1);
            border: 1px solid transparent;
        }

        /* Icon styling */
        .sidebar .nav-link i {
            color: var(--accent-color);
            width: 22px;
            text-align: center;
            font-size: 1.1rem;
            transition: transform 0.25s ease, color 0.25s ease;
        }

        /* Hover effect – subtle glow and movement */
        .sidebar .nav-link:hover {
            background: linear-gradient(145deg, rgba(0, 245, 255, 0.15), rgba(0, 200, 255, 0.05));
            color: var(--accent-color);
            transform: translateX(5px);
            border: 1px solid rgba(0, 245, 255, 0.3);
            box-shadow:
                0 4px 12px rgba(0, 245, 255, 0.15),
                inset 0 1px 2px rgba(255, 255, 255, 0.2);
        }

        .sidebar .nav-link:hover i {
            transform: scale(1.15);
        }

        /* Active state – glowing accent highlight */
        .sidebar .nav-link.active {
            background: linear-gradient(135deg, rgba(0, 245, 255, 0.18), rgba(0, 200, 255, 0.1));
            color: var(--text-color);
            border-left: 4px solid var(--accent-color);
            font-weight: 700;
            box-shadow:
                0 0 15px rgba(0, 245, 255, 0.35),
                inset 0 1px 2px rgba(255, 255, 255, 0.15);
        }

        /* Dropdown caret */
        .sidebar .dropdown-toggle::after {
            content: '\f107';
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            margin-left: auto;
            transition: transform 0.3s ease;
            color: var(--accent-color);
            opacity: 0.7;
        }

        .sidebar .dropdown.open .dropdown-toggle::after {
            transform: rotate(-180deg);
        }

        /* Submenu */
        .sidebar .submenu {
            display: none;
            margin-left: 2rem;
            padding-left: 0.8rem;
            border-left: 2px solid var(--accent-color);
            margin-top: 0.4rem;
        }

        .dropdown.open .submenu {
            display: block;
        }

        .sidebar .submenu li a {
            display: block;
            color: var(--text-secondary);
            padding: 0.4rem 0;
            font-size: 0.9rem;
            text-decoration: none;
            transition: 0.25s ease;
        }

        .sidebar .submenu li a:hover {
            color: var(--accent-color);
            transform: translateX(4px);
            text-decoration: underline;
        }

        /* Profile button */
        #profileBtn {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border-top: 1px solid var(--glass-border);
            padding: 1rem;
            text-align: center;
            transition: background var(--transition-speed), border var(--transition-speed);
        }

        #profileBtn .btn {
            background: linear-gradient(90deg, var(--accent-alt), var(--accent-color));
            color: var(--text-color);
            font-weight: 700;
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.4);
            transition: all 0.3s ease;
        }

        #profileBtn .btn:hover {
            transform: scale(1.05);
            box-shadow: 0 0 35px var(--accent-alt);
        }


        /* === PROFILE BUTTON === */
        #profileBtn {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border-top: 1px solid var(--glass-border);
            padding: 1rem;
            text-align: center;
        }

        #profileBtn .btn {
            background: linear-gradient(90deg, var(--accent-alt), var(--accent-color));
            color: #fff;
            font-weight: 700;
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.4);
            transition: all 0.3s ease;
        }

        #profileBtn .btn:hover {
            transform: scale(1.05);
            box-shadow: 0 0 35px rgba(255, 0, 255, 0.6);
        }

        /* === MAIN CONTENT === */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            position: relative;
            z-index: 2;
        }

        /* === HEADER === */
        .main-header {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px);
            border: 1px solid var(--glass-border);
            border-radius: 15px;
            padding: 1rem 1.5rem;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.3);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* === GLASS CARDS === */
        .glass-card {
            background: rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.4);
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            border-color: var(--accent-color);
            box-shadow: 0 0 25px rgba(0, 255, 255, 0.3);
            transform: translateY(-3px);
        }

        /* === BUTTONS === */
        .btn-accent {
            background: linear-gradient(90deg, var(--accent-alt), var(--accent-color));
            color: #fff;
            font-weight: 700;
            border: none;
            border-radius: 8px;
            box-shadow: 0 0 12px rgba(0, 255, 255, 0.3);
        }

        .btn-accent:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 25px rgba(255, 0, 255, 0.5);
        }

        /* === TABLE === */
        /* html[data-bs-theme="dark"] table.dataTable {
       background: #fff !important;
    color: #e4e4e4 !important;
}

html[data-bs-theme="dark"] table.dataTable thead th {
      background: #fff !important;
    color: var(--accent-color) !important;
}

html[data-bs-theme="light"] table.dataTable tbody tr {
    background: #fff !important;
    color: var(--text-secondary) !important;
} */


        .table {
            color: var(--text-secondary);
            border-collapse: separate;
            border-spacing: 0 0.5rem;
        }



        .table thead th {
            border: none;
            color: var(--accent-color);
            text-transform: uppercase;
            font-size: 0.75rem;
        }

        html[data-bs-theme="light"] .table tbody tr {
            background: rgba(255, 255, 255, 0.65);

        }

        .table tbody tr {
            background: rgba(255, 255, 255, 0.03);
            transition: all 0.3s;
        }

        /* .table tbody tr:hover {
            background: rgba(0, 255, 255, 0.05);
            transform: scale(1.01);
        } */

        /* === BADGES === */
        .badge-upcoming {
            background: rgba(0, 255, 255, 0.15);
            color: var(--accent-color);
        }

        .badge-completed {
            background: rgba(255, 255, 255, 0.1);
            color: #ccc;
        }

        .badge-cancelled {
            background: rgba(255, 0, 120, 0.15);
            color: #ff4d8b;
        }

        /* === ICON BUTTONS === */
        .icon-btn {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid var(--glass-border);
            color: var(--text-color);
            transition: 0.3s;
        }

        .icon-btn:hover {
            background: rgba(0, 255, 255, 0.1);
            color: var(--accent-color);
            box-shadow: 0 0 12px rgba(0, 255, 255, 0.3);
        }

        /* === AVATAR === */
        .avatar {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.1);
            color: var(--accent-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        /* === MOBILE SIDEBAR === */
        @media (max-width: 991.98px) {
            .main-content {
                margin-left: 0;
            }

            .sidebar {
                left: -100%;
                transition: left var(--transition-speed) ease;
                box-shadow: none;
            }

            .sidebar.show-sidebar {
                left: 0;
                box-shadow: 2px 0 25px rgba(0, 0, 0, 0.4);
            }

            .sidebar-backdrop {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.6);
                backdrop-filter: blur(8px);
                z-index: 1040;
                opacity: 0;
                visibility: hidden;
                transition: opacity var(--transition-speed), visibility var(--transition-speed);
            }

            .sidebar.show-sidebar+.sidebar-backdrop {
                opacity: 1;
                visibility: visible;
            }
        }
    </style>

</head>

<body>
    <!-- Generic App Offcanvas -->
    <div class="offcanvas offcanvas-end text-light" tabindex="-1" id="appOffcanvas" aria-labelledby="appOffcanvasLabel"
        style="background: rgba(15, 18, 22, 0.95); backdrop-filter: blur(15px); border-left: 2px solid var(--accent-color); width: 480px;">
        <div class="offcanvas-header border-bottom border-secondary-subtle">
            <h5 class="offcanvas-title text-accent fw-bold" id="appOffcanvasLabel">Panel</h5>
            <button type="button" class="btn-close btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body" id="appOffcanvasBody">
            <div class="text-center text-secondary">Loading...</div>
        </div>
    </div>



    {{-- Sidebar --}}
    <x-partials.sidebar />

    {{-- Overlay --}}

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <div class="main-content">
        {{-- Header --}}
        <x-partials.header />

        {{-- Page Content --}}
        {{ $slot }}
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        // Global jQuery setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        // Simple notify using Bootstrap alerts
        function notify(type, message) {
            const types = {
                success: 'success',
                error: 'danger',
                info: 'info',
                warning: 'warning'
            };
            const cls = types[type] || 'info';
            const wrapId = 'notify-container';
            let $wrap = $('#' + wrapId);
            if (!$wrap.length) {
                $wrap = $('<div/>', {
                    id: wrapId,
                    style: 'position:fixed; top: 12px; right: 12px; z-index: 2000; width: 320px;'
                }).appendTo('body');
            }
            const $alert = $(
                `\n                <div class="alert alert-${cls} alert-dismissible fade show shadow-sm" role="alert" style="background: rgba(0,0,0,0.35);">\n                  <div>${message}</div>\n                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>\n                </div>`
            );
            $wrap.append($alert);
            setTimeout(() => {
                $alert.alert('close');
            }, 3000);
        }

        // Offcanvas helpers
        let appOffcanvasInstance = null;

        function getAppOffcanvas() {
            if (!appOffcanvasInstance) {
                const el = document.getElementById('appOffcanvas');
                appOffcanvasInstance = bootstrap.Offcanvas.getOrCreateInstance(el);
            }
            return appOffcanvasInstance;
        }

        function openOffcanvas(url, title) {
            $('#appOffcanvasLabel').text(title || 'Panel');
            $('#appOffcanvasBody').html('<div class="text-center text-secondary">Loading...</div>');
            getAppOffcanvas().show();
            $.get(url)
                .done(function(html) {
                    $('#appOffcanvasBody').html(html);
                })
                .fail(function(xhr) {
                    $('#appOffcanvasBody').html('<div class="text-danger">Failed to load content.</div>');
                });
        }

        function closeOffcanvas() {
            getAppOffcanvas().hide();
        }

        // Ajax form binder
        function bindAjaxForm($form, onSuccess) {
            $form.on('submit', function(e) {
                e.preventDefault();
                const $f = $(this);
                $f.find('[data-error-for]').text('');
                const method = ($f.find('input[name="_method"]').val() || $f.attr('method') || 'POST')
                    .toUpperCase();
                const action = $f.attr('action');
                const data = $f.serialize();
                $.ajax({
                        url: action,
                        type: method,
                        data: data
                    })
                    .done(function(res) {
                        if (res && res.success) notify('success', res.message || 'Success');
                        if (typeof onSuccess === 'function') onSuccess(res);
                    })
                    .fail(function(xhr) {
                        ajaxErrorHandler(xhr, $f);
                    });
            });
        }

        function ajaxErrorHandler(xhr, $form) {
            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                const errs = xhr.responseJSON.errors;
                Object.keys(errs).forEach(function(key) {
                    const msg = errs[key][0];
                    $form.find(`[data-error-for="${key}"]`).text(msg);
                });
                notify('error', 'Please fix the errors and try again.');
            } else {
                notify('error', 'Something went wrong.');
            }
        }

        function confirmAjaxDelete(url, onSuccess) {
            if (!confirm('Delete this item?')) return;
            $.ajax({
                    url: url,
                    type: 'DELETE'
                })
                .done(function(res) {
                    if (res && res.success) notify('success', res.message || 'Deleted');
                    if (typeof onSuccess === 'function') onSuccess(res);
                })
                .fail(function(xhr) {
                    notify('error', 'Delete failed.');
                });
        }

        document.addEventListener('DOMContentLoaded', () => {
            const themeToggle = document.getElementById('themeToggle');
            const htmlEl = document.documentElement;

            let currentTheme = localStorage.getItem('theme') || 'dark';
            htmlEl.setAttribute('data-bs-theme', currentTheme);
            updateToggleIcon(currentTheme);

            themeToggle.addEventListener('click', () => {
                currentTheme = htmlEl.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
                htmlEl.setAttribute('data-bs-theme', currentTheme);
                localStorage.setItem('theme', currentTheme);
                updateToggleIcon(currentTheme);
            });

            function updateToggleIcon(theme) {
                themeToggle.innerHTML = theme === 'dark' ?
                    '<i class="bi bi-moon-fill"></i>' :
                    '<i class="bi bi-sun-fill"></i>';
            }
        });
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const toggleButton = document.getElementById('sidebarToggle');
            const backdrop = document.getElementById('sidebar-backdrop');
            const body = document.body;

            function toggleSidebar() {
                const isSidebarOpen = sidebar.classList.toggle('show-sidebar');
                body.style.overflowY = isSidebarOpen ? 'hidden' : 'auto';
            }

            toggleButton.addEventListener('click', toggleSidebar);
            backdrop.addEventListener('click', toggleSidebar);

            // Dropdown toggle logic
            sidebar.querySelectorAll('.dropdown-toggle').forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const parent = link.closest('.dropdown');
                    const submenu = parent.querySelector('.submenu');

                    if (!submenu) return;

                    // Toggle submenu visibility
                    if (submenu.style.display === 'block') {
                        submenu.style.display = 'none';
                        parent.classList.remove('open');
                    } else {
                        submenu.style.display = 'block';
                        parent.classList.add('open');
                    }
                });
            });

            // Close sidebar on nav-link clicks (non-dropdown)
            sidebar.querySelectorAll('.nav-link:not(.dropdown-toggle)').forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 992) toggleSidebar();
                });
            });

            // Reset sidebar on resize
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 992) {
                    sidebar.classList.remove('show-sidebar');
                    body.style.overflowY = 'auto';
                }
            });
        });
    </script>
    <script>
        // Override notify to use Toastr
        if (window.toastr) {
            toastr.options = {
                positionClass: 'toast-bottom-left',
                timeOut: 3000
            };
            window.notify = function(type, message) {
                if (typeof toastr[type] === 'function') {
                    toastr[type](message);
                } else {
                    toastr.info(message);
                }
            }
        }
    </script>
</body>

</html>
