        <header class="main-header mb-4 d-flex justify-content-between align-items-center sticky-top">

            <div class="d-flex align-items-center">
                <button class="btn btn-outline-secondary me-3 d-lg-none" id="sidebarToggle">
                    <i class="fas fa-bars text-accent"></i>
                </button>
                <h1 class="h3 my-0 fw-light">Welcome, <span
                        class="fw-bold text-accent">{{ auth()->user()->name ?? (session('name') ?? 'User') }}</span></h1>
            </div>

            <div class="d-flex align-items-center">
                <div class="px-3">
                    <button id="themeToggle" class="btn btn-accent w-100">
                        <i class="bi bi-moon-fill"></i>
                    </button>
                </div>
                <!-- Replaced Button (Offcanvas Trigger) -->
                {{-- <button class="btn btn-accent d-none d-md-block"
                    data-bs-target="#addAppointmentOffcanvas">
                    <i class="fas fa-calendar-plus"></i>
                </button> --}}
                <a href="{{ route('appoinment.index', ['segment' => request()->route('segment')]) }}"
                    class="btn btn-accent d-none d-md-block">
                    <i class="fas fa-calendar-plus"></i>
                </a>


                {{-- <img src="placeholder.jpg" class="rounded-circle" alt="User"
                    style="width: 45px; height: 45px; border: 3px solid var(--accent-color);"> --}}
            </div>
        </header>
