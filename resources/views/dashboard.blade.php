<x-master>
    <x-slot name="title">Note</x-slot>
    <div class="container">
        <div class="glassy-card" style="padding: 10px;">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-3">
                <div>
                    <h4 class="fw-bold mb-0">Today's Appointments</h4>
                    <small class="text-secondary">Doctor appointment schedule — dark glassy theme</small>
                </div>
                <div class="d-flex gap-2">
                    {{-- <input type="search" class="form-control form-control-sm bg-transparent border-light text-light"
                        placeholder="Search...">
                    <button class="btn btn-outline-light btn-sm">Filter</button> --}}
                    <button class="btn btn-success btn-sm">New Appointment</button>
                </div>
            </div>

            <div class="table-responsive mehedi">
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
</x-master>
