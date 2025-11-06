    <style>
        .profile-card {
            display: none;
            position: fixed;
            bottom: 60px;
            left: 1%;
            /* transform: translate(-50%, -50%); */
            background: rgba(255, 255, 255, 0.15);
            /* Transparent glass look */
            backdrop-filter: blur(15px);
            /* Frosted blur effect */
            -webkit-backdrop-filter: blur(15px);
            /* Safari support */
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 15px;
            width: 320px;
            padding: 1.5rem;
            z-index: 1050;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .profile-card.active {
            display: block;
        }

        .profile-card img {
            border: 2px solid rgba(255, 255, 255, 0.4);
        }

        .profile-card h5,
        .profile-card p {
            color: #fff;
        }

        .btn-danger {
            background: rgba(255, 0, 0, 0.8);
            border: none;
        }

        .btn-danger:hover {
            background: rgba(255, 0, 0, 1);
        }

        .submenu a.active {
            color: var(--accent-color);
            font-weight: 600;
        }
    </style>
    <nav id="sidebar" class="sidebar">
        <a class="sidebar-brand text-decoration-none fs-5 text-accent d-block text-center mt-3 mb-4"
            href="{{ route('dashboard', ['segment' => request()->route('segment')]) }}">
            <i class="fas fa-heartbeat me-2"></i> AL-<span class="fw-light">BARAQAH</span>
        </a>
        <hr class="border-secondary opacity-25">

        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard', ['segment' => request()->route('segment')]) }}"><i
                        class="fas fa-th-large"></i> Dashboard</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('doctors.index', ['segment' => request()->route('segment')]) }}"><i
                        class="fas fa-user-md"></i> Doctor List</a>
            </li>

            @php($settingsOpen = request()->routeIs('users.*') || request()->routeIs('branches.*') || request()->routeIs('specializations.*'))
            <div class="dropdown {{ $settingsOpen ? 'open' : '' }}">
                <a href="#" class="nav-link dropdown-toggle {{ $settingsOpen ? 'active' : '' }}"><i
                        class="fas fa-cog"></i> Settings</a>
                <ul class="submenu" @if ($settingsOpen) style="display: block" @endif>
                    <li><a class="{{ request()->routeIs('users.*') ? 'active' : '' }}"
                            href="{{ route('users.index', ['segment' => request()->route('segment')]) }}">Users</a></li>
                    <li>
                        <a class="{{ request()->routeIs('branches.*') ? 'active' : '' }}"
                            href="{{ route('branches.index', ['segment' => request()->route('segment')]) }}">Branches</a>
                    </li>
                    <li>
                        <a class="{{ request()->routeIs('appointment-status.*') ? 'active' : '' }}"
                            href="{{ route('appointment-status.index', ['segment' => request()->route('segment')]) }}">Appointment
                            Status</a>
                    </li>
                    <li>
                        <a class="{{ request()->routeIs('leave-reason.*') ? 'active' : '' }}"
                            href="{{ route('leave-reason.index', ['segment' => request()->route('segment')]) }}">Leave
                            Reason</a>
                    </li>
                    <li><a class="{{ request()->routeIs('specializations.*') ? 'active' : '' }}"
                            href="{{ route('specializations.index', ['segment' => request()->route('segment')]) }}">Specializations</a>
                    </li>
                </ul>
            </div>

             <div class="dropdown {{ $settingsOpen ? 'open' : '' }}">
                <a href="#" class="nav-link dropdown-toggle {{ $settingsOpen ? 'active' : '' }}">
                    <i class="fas fa-sticky-note"></i> Appointments</a>
                <ul class="submenu" @if ($settingsOpen) style="display: block" @endif>
                    <li>
                        <a class="{{ request()->routeIs('export-appointment.*') ? 'active' : '' }}"
                            href="{{ route('export-appointment.index', ['segment' => request()->route('segment')]) }}">
                            Export Appointments
                        </a>
                    </li>
                </ul>
            </div>
        </ul>


        <div id="profileBtn" class="position-absolute bottom-0 w-100 p-3">
            <button class="btn w-100 fw-bold btn-accent" disabled>
                <i class="fas fa-user-circle me-2"></i> Profile
            </button>
        </div>
    </nav>

    <div id="sidebar-backdrop" class="sidebar-backdrop"></div>
    <div id="profileCard" class="profile-card shadow-lg">
        <button class="btn-close position-absolute top-0 end-0 m-2" id="closeCard"></button>
        <div class="text-center p-4">
            <img src="https://via.placeholder.com/100" alt="Doctor" class="rounded-circle mb-3">
            <h5 class="mb-2">{{ auth()->user()->name ?? (session('name') ?? 'User') }}</h5>
            <p class="text-muted">General Physician</p>
            <a href="{{ route('auth.logout') }}"
                onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                class="btn btn-danger w-100"><i class="fas fa-sign-out-alt me-2"></i>
                Logout</a>
            <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

    <script>
        const profileBtn = document.getElementById('profileBtn');
        const profileCard = document.getElementById('profileCard');
        const closeCard = document.getElementById('closeCard');

        profileBtn.addEventListener('click', () => {
            profileCard.classList.add('active');
        });

        closeCard.addEventListener('click', () => {
            profileCard.classList.remove('active');
        });

        // Optional: close when clicking outside the card
        window.addEventListener('click', (e) => {
            if (e.target === profileCard) {
                profileCard.classList.remove('active');
            }
        });
        // document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
        //     toggle.addEventListener('click', e => {
        //         e.preventDefault();
        //         const parent = toggle.closest('.dropdown');
        //         parent.classList.toggle('open');
        //         const submenu = parent.querySelector('.submenu');
        //         submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
        //     });
        // });
    </script>
