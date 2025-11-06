<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Al-Baraqah | Appointment Management Wallboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/YOUR_KITS_CODE.js" crossorigin="anonymous"></script>

    <style>
        /* Import the suggested UI font for a modern look */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');

        /* BASE VARIABLES */
        :root {
            --transition-speed: 0.4s;
            --main-bg: #0A0D11;
            /* Even DEEPER Charcoal Base */
            --accent-color: #00FFFF;
            /* Electric Cyan */
            --accent-glow: 0 0 12px rgba(0, 255, 255, 0.7);
            --text-secondary: #9AA8BA;
            --sidebar-width: 230px;
            /* Defined for easy CSS/JS reference */
        }

        /* 1. Global Setup */
        body {
            background-color: var(--main-bg);
            color: #E6E6E6;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            /* Prevents horizontal scroll when sidebar is off-screen */
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            transition: all var(--transition-speed) ease;
        }

        .text-accent {
            color: var(--accent-color) !important;
        }

        .text-secondary {
            color: var(--text-secondary) !important;
        }

        /* 2. Unique Glassmorphism Card Style */
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 255, 255, 0.15);
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 4px 40px rgba(0, 0, 0, 0.4);
            height: 100%;
        }

        .glass-card:hover {
            border: 1px solid var(--accent-color);
            box-shadow: var(--accent-glow);
            transform: translateY(-4px);
        }

        /* 3. Sidebar & Layout (Desktop View) */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            /* width: 200px */
            width: var(--sidebar-width);
            z-index: 1050;
            /* Above regular content, below modal */
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.8);
            padding: .5rem;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            /* Push content over */
            padding: 1rem;
        }

        /* Sidebar content styles (Brand, Nav Links, etc.) */
        .sidebar-brand {
            font-size: 2.0rem;
            font-weight: 900;
            text-shadow: var(--accent-glow);
        }

        .sidebar .nav-link {
            color: var(--text-secondary);
            border-radius: 10px;
            padding: 0.75rem 1rem;
        }

        .sidebar .nav-link.active {
            background: rgba(0, 255, 255, 0.1);
            color: white !important;
            border-left: 5px solid var(--accent-color);
            font-weight: 700;
        }

        /* End Sidebar Content Styles */

        /* 4. Header Styling */
        .main-header {
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(8px);
            border-radius: 15px;
            padding: 1rem 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }

        /* 5. Utility Button */
        .btn-accent {
            background-color: var(--accent-color);
            color: var(--main-bg);
            font-weight: bold;
            border: none;
            box-shadow: 0 0 5px var(--accent-color);
        }

        .btn-accent:hover {
            background-color: #00DCDC;
            color: var(--main-bg);
            box-shadow: var(--accent-glow);
        }

        /* 6. Mobile Responsiveness */
        @media (max-width: 991.98px) {

            /* Adjust Main Content for Mobile */
            .main-content {
                margin-left: 0;
                /* No push from sidebar */
            }

            /* Sidebar behaves like an offcanvas menu */
            .sidebar {
                left: calc(var(--sidebar-width) * -1);
                /* Hidden off-screen initially */
                transition: left var(--transition-speed) ease;
                box-shadow: none;
                /* Remove shadow when off-screen */
            }

            .sidebar.show-sidebar {
                left: 0;
                /* Slide in */
                box-shadow: 2px 0 15px rgba(0, 0, 0, 0.8);
            }

            /* Backdrop overlay when sidebar is open */
            .sidebar-backdrop {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.7);
                backdrop-filter: blur(5px);
                z-index: 1040;
                opacity: 0;
                visibility: hidden;
                transition: opacity var(--transition-speed) ease, visibility var(--transition-speed) ease;
            }

            .sidebar.show-sidebar+.sidebar-backdrop {
                opacity: 1;
                visibility: visible;
            }
        }

        .offcanvas {
            box-shadow: -4px 0 25px rgba(0, 255, 255, 0.15);
        }

        .offcanvas .form-control,
        .offcanvas .form-select,
        .offcanvas textarea {
            border: 1px solid rgba(0, 255, 255, 0.15);
            border-radius: 10px;
        }

        .offcanvas .form-control:focus,
        .offcanvas .form-select:focus,
        .offcanvas textarea:focus {
            border-color: var(--accent-color);
            box-shadow: var(--accent-glow);
            outline: none;
        }

        /* Bottom Buttons Styling */
        .cancel-btn {
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #E6E6E6;
            font-weight: 500;
            border-radius: 30px;
            padding: 0.45rem 1.2rem;
            transition: all 0.3s ease;
        }

        .cancel-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--accent-color);
            color: var(--accent-color);
        }

        .save-btn {
            border-radius: 30px;
            padding: 0.45rem 1.4rem;
            font-weight: 600;
            box-shadow: 0 0 10px rgba(0, 255, 255, 0.4);
        }

        .save-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 0 18px rgba(0, 255, 255, 0.8);
        }

        .table {
            color: #dfe9ef;
            margin-bottom: 0;
        }

        .table thead {
            background: rgba(255, 255, 255, 0.05);
        }

        .table thead th {
            border: none;
            color: #9ca3af;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.08em;
        }

        .table tbody tr {
            border-color: rgba(255, 255, 255, 0.05);
            transition: 0.2s;
        }

        .table tbody tr:hover {
            background: rgba(255, 255, 255, 0.05);
            transform: scale(1.01);
        }

        .badge-upcoming {
            background: rgba(110, 231, 183, 0.1);
            color: #6ee7b7;
            border: 1px solid rgba(110, 231, 183, 0.2);
        }

        .badge-completed {
            background: rgba(147, 197, 253, 0.08);
            color: #93c5fd;
            border: 1px solid rgba(147, 197, 253, 0.15);
        }

        .badge-cancelled {
            background: rgba(255, 124, 124, 0.1);
            color: #f87171;
            border: 1px solid rgba(255, 124, 124, 0.15);
        }

        .avatar {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: #6ee7b7;
        }

        .icon-btn {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.05);
            border: none;
            color: #9ca3af;
            transition: 0.2s;
        }

        .icon-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #6ee7b7;
            transform: translateY(-2px);
        }
    </style>
</head>

<body>
    <!-- Offcanvas Form -->
    <div class="offcanvas offcanvas-end text-light" tabindex="-1" id="addAppointmentOffcanvas"
        aria-labelledby="offcanvasLabel"
        style="background: rgba(15, 18, 22, 0.95); backdrop-filter: blur(15px); border-left: 2px solid var(--accent-color); width: 420px;">
        <div class="offcanvas-header border-bottom border-secondary-subtle">
            <h5 class="offcanvas-title text-accent fw-bold" id="offcanvasLabel">
                <i class="fas fa-user-plus me-2"></i> Add New Appointment
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">
            <form class="glass-card py-3">
                <div class="mb-3">
                    <label class="form-label small text-secondary">Patient Name</label>
                    <input type="text"
                        class="form-control form-control-sm bg-transparent text-light border-secondary"
                        placeholder="Enter patient name">
                </div>

                <div class="mb-3">
                    <label class="form-label small text-secondary">Appointment Date</label>
                    <input type="date"
                        class="form-control form-control-sm bg-transparent text-light border-secondary">
                </div>

                <div class="mb-3 d-flex gap-2">
                    <div class="flex-fill">
                        <label class="form-label small text-secondary">Start Time</label>
                        <input type="time"
                            class="form-control form-control-sm bg-transparent text-light border-secondary">
                    </div>
                    <div class="flex-fill">
                        <label class="form-label small text-secondary">End Time</label>
                        <input type="time"
                            class="form-control form-control-sm bg-transparent text-light border-secondary">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small text-secondary">Room</label>
                    <select class="form-select form-select-sm bg-transparent text-light border-secondary">
                        <option selected disabled>Select room</option>
                        <option>Room 1</option>
                        <option>Room 2</option>
                        <option>Room 3</option>
                        <option>Room 4</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label small text-secondary">Reason / Notes</label>
                    <textarea class="form-control form-control-sm bg-transparent text-light border-secondary" rows="3"
                        placeholder="Enter appointment details..."></textarea>
                </div>

                <div class="d-flex justify-content-end  gap-2">
                    <button type="button" class="btn btn-outline-light cancel-btn" data-bs-dismiss="offcanvas">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-accent save-btn">
                        <i class="fas fa-check me-1"></i> Save Appointment
                    </button>
                </div>

            </form>
        </div>
    </div>

    <nav id="sidebar" class="sidebar">
        <a class="sidebar-brand text-decoration-none fs-5 text-accent d-block text-center mt-3 mb-4" href="#">
            <i class="fas fa-heartbeat me-2"></i> AL-<span class="fw-light">BARAQAH</span>
        </a>
        <hr class="border-secondary opacity-25">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#"><i class="fas fa-th-large me-3"></i>
                    Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="fas fa-clock me-3"></i> Real-Time Queue</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="fas fa-user-injured me-3"></i> Patient Records</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="fas fa-chart-area me-3"></i> System Analytics</a>
            </li>
        </ul>

        <div class="position-absolute bottom-0 w-100 p-3">
            <button class="btn w-100 fw-bold btn-accent" disabled>
                <i class="fas fa-user-circle me-2"></i> Profile
            </button>
        </div>
    </nav>

    <div id="sidebar-backdrop" class="sidebar-backdrop"></div>


    <div class="main-content">

        <header class="main-header mb-4 d-flex justify-content-between align-items-center sticky-top">

            <div class="d-flex align-items-center">
                <button class="btn btn-outline-secondary me-3 d-lg-none" id="sidebarToggle">
                    <i class="fas fa-bars text-accent"></i>
                </button>
                <h1 class="h3 my-0 fw-light">Welcome, <span class="fw-bold text-accent">Dr. K. Sharma</span></h1>
            </div>

            <div class="d-flex align-items-center">
                <!-- Replaced Button (Offcanvas Trigger) -->
                <button class="btn btn-accent rounded-pill me-3 d-none d-md-block" data-bs-toggle="offcanvas"
                    data-bs-target="#addAppointmentOffcanvas">
                    <i class="fas fa-calendar-plus me-2"></i> New Appointment
                </button>

                <img src="placeholder.jpg" class="rounded-circle" alt="User"
                    style="width: 45px; height: 45px; border: 3px solid var(--accent-color);">
            </div>
        </header>

        <div class="row g-4">

            <div class="col-xl-6 col-12">
                <div class="glass-card card-wide">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="text-accent fw-bold"><i class="fas fa-exclamation-triangle me-2"></i> Next Patient
                            Up</h5>
                        <span class="badge bg-warning text-dark p-2">Waiting: 5 mins</span>
                    </div>
                    <h1 class="mb-1 text-white">Mr. David Chen</h1>
                    <p class="text-secondary small">Reason: Annual Physical Checkup | Room 4</p>
                    <div class="progress mt-4" role="progressbar" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: 75%"></div>
                    </div>
                    <small class="text-success">75% of appt. duration remaining</small>

                    <div class="mt-4 d-flex justify-content-end">
                        <button class="btn btn-sm btn-outline-secondary me-2">View History</button>
                        <button class="btn btn-sm btn-accent">Start Consultation</button>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="glass-card">
                    <p class="text-uppercase text-secondary small mb-1">Total Patients In Queue</p>
                    <h1 class="display-3 fw-bold text-light">14</h1>
                    <span class="text-success small"><i class="fas fa-caret-up"></i> +4 scheduled this hour</span>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="glass-card">
                    <p class="text-uppercase text-secondary small mb-1">Avg. Wait Time</p>
                    <h1 class="display-3 fw-bold text-warning">12<small class="h3 fw-light ms-1">mins</small></h1>
                    <span class="text-danger small"><i class="fas fa-caret-up"></i> +3 mins vs yesterday</span>
                </div>
            </div>

            <div class="col-xl-4 col-12">
                <div class="glass-card card-tall">
                    <h5 class="text-accent fw-bold mb-3">Room Availability</h5>
                    <ul class="list-unstyled">
                        <li
                            class="d-flex justify-content-between align-items-center mb-3 border-bottom border-secondary-subtle pb-2">
                            <span class="text-white fw-bold">Room 1</span>
                            <span class="badge bg-danger">Busy (Dr. T)</span>
                        </li>
                        <li
                            class="d-flex justify-content-between align-items-center mb-3 border-bottom border-secondary-subtle pb-2">
                            <span class="text-white fw-bold">Room 2</span>
                            <span class="badge bg-success">Available</span>
                        </li>
                        <li
                            class="d-flex justify-content-between align-items-center mb-3 border-bottom border-secondary-subtle pb-2">
                            <span class="text-white fw-bold">Room 3</span>
                            <span class="badge bg-warning text-dark">Cleaning</span>
                        </li>
                        <li
                            class="d-flex justify-content-between align-items-center mb-3 border-bottom border-secondary-subtle pb-2">
                            <span class="text-white fw-bold">Room 4</span>
                            <span class="badge bg-primary">In Use (Dr. K)</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-xl-8 col-12">
                <div class="glass-card card-tall">
                    <h5 class="text-accent fw-bold">Patient Throughput (Last 7 Days)</h5>
                    <div class="bg-dark p-4 rounded-3 mt-3"
                        style="height: 250px; border: 2px solid var(--accent-color); background-image: linear-gradient(180deg, rgba(0,255,255,0.1) 0%, rgba(0,0,0,0) 100%);">
                        <p class="text-secondary text-center mt-5 pt-3">High-contrast Area Chart Placeholder</p>
                    </div>
                </div>
            </div>


            <div class="container">
                <div class="glassy-card" style="padding: 10px;">
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-3">
                        <div>
                            <h4 class="fw-bold mb-0">Today's Appointments</h4>
                            <small class="text-secondary">Doctor appointment schedule — dark glassy theme</small>
                        </div>
                        <div class="d-flex gap-2">
                            <input type="search"
                                class="form-control form-control-sm bg-transparent border-light text-light"
                                placeholder="Search...">
                            <button class="btn btn-outline-light btn-sm">Filter</button>
                            <button class="btn btn-success btn-sm">New Appointment</button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle table-borderless">
                            <thead>
                                <tr>
                                    <th>Patient</th>
                                    <th>Doctor</th>
                                    <th>Date & Time</th>
                                    <th>Duration</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar">AJ</div>
                                            <div>
                                                <div class="fw-semibold">Ayesha Jahan</div>
                                                <small class="text-secondary">+880 17 1234 567</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">Dr. Farhana Rahman</div>
                                        <small class="text-secondary">Cardiology — Room 3</small>
                                    </td>
                                    <td>Nov 2, 2025 — 10:30 AM</td>
                                    <td>30 mins</td>
                                    <td><span class="badge rounded-pill badge-upcoming">Upcoming</span></td>
                                    <td class="text-end">
                                        <button class="icon-btn"><i class="bi bi-eye"></i></button>
                                        <button class="icon-btn"><i class="bi bi-pencil"></i></button>
                                        <button class="icon-btn"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar">RH</div>
                                            <div>
                                                <div class="fw-semibold">Rafid Hasan</div>
                                                <small class="text-secondary">+880 18 9988 667</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">Dr. Alamgir Hossain</div>
                                        <small class="text-secondary">Neurology — Room 5</small>
                                    </td>
                                    <td>Nov 2, 2025 — 11:15 AM</td>
                                    <td>45 mins</td>
                                    <td><span class="badge rounded-pill badge-completed">Completed</span></td>
                                    <td class="text-end">
                                        <button class="icon-btn"><i class="bi bi-eye"></i></button>
                                        <button class="icon-btn"><i class="bi bi-pencil"></i></button>
                                        <button class="icon-btn"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar">SS</div>
                                            <div>
                                                <div class="fw-semibold">Sadia Sultana</div>
                                                <small class="text-secondary">+880 19 2223 887</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">Dr. Mahfuz Rahman</div>
                                        <small class="text-secondary">Dermatology — Room 1</small>
                                    </td>
                                    <td>Nov 2, 2025 — 12:00 PM</td>
                                    <td>30 mins</td>
                                    <td><span class="badge rounded-pill badge-cancelled">Cancelled</span></td>
                                    <td class="text-end">
                                        <button class="icon-btn"><i class="bi bi-eye"></i></button>
                                        <button class="icon-btn"><i class="bi bi-pencil"></i></button>
                                        <button class="icon-btn"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const toggleButton = document.getElementById('sidebarToggle');
            const backdrop = document.getElementById('sidebar-backdrop');
            const body = document.body;

            // Function to toggle the sidebar state
            function toggleSidebar() {
                const isSidebarOpen = sidebar.classList.toggle('show-sidebar');

                // Toggle body overflow to prevent background scrolling when menu is open
                body.style.overflowY = isSidebarOpen ? 'hidden' : 'auto';
            }

            // 1. Open/Close when the Hamburger Button is clicked
            toggleButton.addEventListener('click', toggleSidebar);

            // 2. Close when the backdrop is clicked
            backdrop.addEventListener('click', toggleSidebar);

            // 3. Close when a navigation link inside the sidebar is clicked (optional but good UX)
            sidebar.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', () => {
                    // Check if we are on a mobile device (less than 992px) before closing
                    if (window.innerWidth < 992) {
                        toggleSidebar();
                    }
                });
            });

            // Ensure backdrop is closed when resizing from mobile to desktop
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 992) {
                    sidebar.classList.remove('show-sidebar');
                    body.style.overflowY = 'auto'; // Reset overflow for desktop
                }
            });
        });
    </script>
</body>

</html>
