<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Doctor Appointment System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    /* General input styling */
input[type="date"],
input[type="time"],
input[type="datetime-local"] {
  color-scheme: dark; /* Ensures white icons in dark backgrounds */
  color: #fff;
  background-color: transparent;
  border: 1px solid rgba(255, 255, 255, 0.3);
  padding: 0.5rem 0.75rem;
  border-radius: 8px;
}

/* Chrome, Edge, Safari */
input[type="date"]::-webkit-calendar-picker-indicator,
input[type="time"]::-webkit-calendar-picker-indicator,
input[type="datetime-local"]::-webkit-calendar-picker-indicator {
  filter: brightness(0) invert(1); /* Makes icons white */
  opacity: 0.9;
  cursor: pointer;
}

/* Firefox */
input[type="date"],
input[type="time"],
input[type="datetime-local"] {
  --calendar-picker-color: #fff;
}

/* Optional hover effect */
input[type="date"]:hover::-webkit-calendar-picker-indicator,
input[type="time"]:hover::-webkit-calendar-picker-indicator {
  opacity: 1;
  transform: scale(1.1);
}
.form-check-input {
  appearance: none;
  -webkit-appearance: none;
  width: 14px;
  height: 14px;
  border: 1px solid rgba(255,255,255,0.4);
  background-color: transparent;
  border-radius: 3px;
  display: inline-block;
  position: relative;
  cursor: pointer;
  transition: all 0.2s ease-in-out;
}

.form-check-input:checked {
  background-color: #00e6ff; /* neon cyan */
  border-color: #00e6ff;
  box-shadow: 0 0 5px #00e6ff, 0 0 15px #00e6ff;
}

/* Create the tick mark */
.form-check-input:checked::after {
  content: "";
  position: absolute;
  top: 2px;
  left: 4px;
  width: 4px;
  height: 8px;
  border: solid #000;
  border-width: 0 2px 2px 0;
  transform: rotate(45deg);
}

/* Optional hover glow */
.form-check-input:hover {
  box-shadow: 0 0 8px rgba(0,230,255,0.5);
}
.form-check-label {
  cursor: pointer;
  user-select: none;
  color: #ccc;
}

/* Dropdown arrow for modern browsers */


/* On focus */

/* <option> text and background fix */
option {
  color: #000;
}

/* Optional hover/focus for open dropdowns (Chrome/Edge) */

    :root {
      --neon-cyan: #00bfff;
      --dark-bg: #0b0f1a;
      --panel-bg: rgba(20, 26, 40, 0.6);
      --text-light: #e5e5e5;
      --border-color: rgba(255, 255, 255, 0.08);
      --glow: 0 0 12px rgba(0, 245, 255, 0.3);
    }

    body {
      font-size: 13px;
      background: var(--dark-bg);
      color: var(--text-light);
      font-family: 'Segoe UI', sans-serif;
      overflow-x: hidden;
    }

    .panel {
      background: var(--panel-bg);
      border-radius: 12px;
      border: 1px solid var(--border-color);
      box-shadow: inset 1px 1px 2px rgba(255,255,255,0.06), 0 0 18px rgba(0, 245, 255, 0.05);
      backdrop-filter: blur(10px);
      padding: 12px;
      transition: all 0.3s ease;
    }

    .panel:hover {
      box-shadow: 0 0 20px rgba(0,245,255,0.2);
      transform: translateY(-2px);
    }

    .section-title {
      font-weight: 600;
      font-size: 14px;
      color: var(--neon-cyan);
      border-bottom: 1px solid rgba(0, 245, 255, 0.25);
      margin-bottom: 8px;
      padding-bottom: 3px;
      text-shadow: 0 0 5px rgba(0,245,255,0.4);
    }

    input, select, .form-control, .form-select {
      font-size: 12px;
      height: 28px;
      padding: 2px 6px;
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(0,245,255,0.15);
      color: var(--text-light);
      border-radius: 6px;
      transition: all 0.2s ease;
    }

    input:focus, select:focus {
      outline: none;
      background: rgba(0,245,255,0.08);
      border-color: var(--neon-cyan);
      box-shadow: 0 0 8px rgba(0,245,255,0.25);
      color: #fff;
    }

    input::placeholder { color: #bbb; }

    .table {
      color: var(--text-light);
      border-color: rgba(255,255,255,0.1) !important;
    }

    .table thead th {
      background: rgba(0,245,255,0.08) !important;
      color: var(--neon-cyan) !important;
      border-bottom: 1px solid rgba(0,245,255,0.15);
    }

    .table tbody tr:hover {
      background: rgba(0,245,255,0.05);
      transition: 0.2s;
    }

    .btn {
      border-radius: 6px;
      font-size: 12px;
      padding: 3px 10px;
      border: 1px solid transparent;
      transition: all 0.3s ease;
    }

    .btn-primary {
      background: var(--neon-cyan);
      border: none;
      color: #000;
      font-weight: 600;
      box-shadow: var(--glow);
    }

    .btn-primary:hover {
      /* background: #00ffff; */
      box-shadow: 0 0 15px rgba(0,245,255,0.4);
    }

    .btn-outline-secondary {
      color: var(--text-light);
      border: 1px solid rgba(0,245,255,0.2);
    }

    .btn-outline-secondary:hover {
      background: rgba(0,245,255,0.1);
      color: var(--neon-cyan);
    }

    .nav-tabs .nav-link {
      color: #aaa;
      border: none;
      transition: all 0.3s ease;
    }

    .nav-tabs .nav-link.active {
      color: var(--neon-cyan);
      background-color: rgba(0,245,255,0.12);
      border-bottom: 2px solid var(--neon-cyan);
      box-shadow: 0 0 10px rgba(0,245,255,0.2);
    }

    .badge {
      font-size: 10px;
      border-radius: 6px;
      padding: 3px 6px;
      box-shadow: 0 0 8px rgba(0,245,255,0.15);
    }

    .small-label { font-size: 11px; color: #aaa; }

    .progress {
      background: rgba(255,255,255,0.05);
      border-radius: 5px;
    }

    .progress-bar {
      box-shadow: 0 0 8px rgba(0,245,255,0.4);
    }

    /* Scrollbar Styling */
    ::-webkit-scrollbar {
      width: 6px;
    }
    ::-webkit-scrollbar-thumb {
      background: rgba(0,245,255,0.3);
      border-radius: 4px;
    }
  </style>
</head>
<body>

<div class="container-fluid p-2">
  <div class="row g-3">

    <!-- Doctor List -->
    <div class="col-lg-3 col-md-4">
      <div class="panel">
        <div class="section-title">Doctor List</div>
        <div class="mb-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 5px;">
          <input type="date" class="form-control">
          <select class="form-select">
            <option>Morning</option>
            <option>Evening</option>
          </select>
          <input type="text" placeholder="Doctor Name" class="form-control doctor_name">
          <select class="form-select specialized">
            <option>Select Specialization</option>
            <option>Nephrologist</option>
            <option>Cardiologist</option>
          </select>
        </div>
        <div class="table-responsive" style="max-height:70vh; overflow:auto;">
          <table class="table table-bordered table-hover table-sm align-middle">
            <thead class="table-light">
              <tr>
                <th>Doctor No</th>
                <th>Doctor Name</th>
                <th>Specialization</th>
              </tr>
            </thead>
            <tbody>
              <tr><td>Y3430</td><td class="text-info">Dr. Suman Chandra Roy</td><td>Nephrologist</td></tr>
              <tr><td>XX9765</td><td>Dr. Julfekar Helal</td><td>Nephrologist</td></tr>
              <tr><td>Y1641</td><td>Dr. A.K.M. Ahsan Ullah</td><td>General & Lap</td></tr>
              <tr><td>XY7044</td><td>Dr. Ajmery Sultana</td><td>Paediatric</td></tr>
              <tr><td>22973</td><td>Dr. Lokman Hossain</td><td>Cardiac Surg</td></tr>
              <tr><td>46206</td><td>Dr. Md. Zia Uddin</td><td>Orthopedic</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Appointment Slab -->
    <div class="col-lg-4 col-md-8">
      <div class="panel">
        <div class="section-title mb-3">Appointment Slab</div>
        <div class="row g-2 mb-3 align-items-end">
          <div class="col-md-7">
            <label class="small-label mb-1">App. Time</label>
            <div class="d-flex">
              <input type="time" class="form-control form-control-sm me-1" value="10:00">
              <input type="time" class="form-control form-control-sm" value="13:00">
            </div>
          </div>
          <div class="col-md-3">
            <label class="small-label mb-1">Avg. Load</label>
            <input type="number" class="form-control form-control-sm" value="100">
          </div>
          <div class="col-md-2">
            <label class="small-label mb-1">Duration</label>
            <input type="number" class="form-control form-control-sm" value="5">
          </div>
        </div>
        <button class="btn btn-primary btn-sm w-100 mb-3">Generate New Slot</button>
        <div class="d-flex justify-content-between mb-2 small">
          <div style="display: flex; align-items: center; gap: 8px;">
            <label class="form-check-label" style="display: flex; align-items: center; gap: 3px;"><input type="radio" name="priority" checked> Normal</label>
            <label class="form-check-label" style="display: flex; align-items: center; gap: 3px;"><input type="radio" name="priority"> VIP</label>
          </div>
          <div>
            <span class="badge bg-info text-dark">Fast</span>
            <span class="badge bg-warning text-dark">Split</span>
            <span class="badge bg-secondary">R.Slot</span>
          </div>
        </div>
        <div class="table-responsive mb-3">
          <table class="table table-bordered table-sm text-center align-middle">
            <thead class="table-light small">
              <tr><th>#</th><th>Fast</th><th>Split</th><th>Time</th><th>Start</th><th>End</th></tr>
            </thead>
            <tbody class="small">
              <tr><td>1</td><td>✔</td><td></td><td>10:00 AM</td><td>10:00</td><td>10:05</td></tr>
              <tr><td>2</td><td></td><td>✔</td><td>10:05 AM</td><td>10:05</td><td>10:10</td></tr>
              <tr><td>3</td><td></td><td></td><td>10:10 AM</td><td>10:10</td><td>10:15</td></tr>
            </tbody>
          </table>
        </div>
        <div class="d-flex justify-content-between small">
          <div><span class="badge bg-success">Occupied</span></div>
          <div><span class="badge bg-danger">Expired</span></div>
          <div><span class="badge bg-info text-dark">Prs.com</span></div>
          <div><span class="badge bg-warning text-dark">Paid</span></div>
          <div><span class="badge bg-secondary">Cancel</span></div>
        </div>
      </div>
    </div>

    <!-- Doctor Info -->
    <div class="col-lg-5">
      <div class="panel" style="max-height: 85vh; overflow-y: auto;">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <div class="section-title">Doctor's Information</div>
          <div>
            <button class="btn btn-outline-secondary btn-sm me-1">View Schedule</button>
            <div class="form-check form-check-inline">
              <input type="checkbox" class="form-check-input" id="extDoc">
              <label class="form-check-label small" for="extDoc">External Doctor?</label>
            </div>
          </div>
        </div>

        <div class="row g-2 mb-3 text-light">
          <div class="col-6"><strong class="text-info">Doctor No :</strong> Y3430</div>
          <div class="col-6"><strong class="text-info">Name :</strong> Dr. Suman Chandra Roy</div>
          <div class="col-6"><strong class="text-info">Degree :</strong> MBBS, MD (Nephrology)</div>
          <div class="col-6"><strong class="text-info">Specialty :</strong> Kidney & Medicine</div>
          <div class="col-6 text-danger"><strong class="text-info">Remarks :</strong> Friday Close</div>
          <div class="col-6"><strong class="text-info">Location :</strong> Chamber (S-282)</div>
          <div class="col-6"><strong class="text-info">Phone :</strong> Milton</div>
          <div class="col-6"><strong class="text-info">Prev. Ins. :</strong> Labaid Hospital</div>
          <div class="col-6"><strong class="text-info">Start Time :</strong> 10:00</div>
          <div class="col-6"><strong class="text-info">End Time :</strong> 13:00</div>
          <div class="col-6"><strong class="text-info">Avg. Duration :</strong> 5 Min</div>
          <div class="col-6"><strong class="text-info">Avg. Load :</strong> 100/Day</div>
        </div>

        <hr class="my-2 border-secondary">

        <ul class="nav nav-tabs small mb-2" id="appTabs" role="tablist">
          <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#appointment">Appointment</a></li>
          <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#cancel">Cancelled</a></li>
          <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#replace">Replaced</a></li>
        </ul>

        <div class="tab-content">
          <div class="tab-pane fade show active" id="appointment">
            <div class="row g-2">
              <div class="col-4">
                <label class="small-label">Start Time</label>
                <input type="time" class="form-control form-control-sm">
              </div>
              <div class="col-4">
                <label class="small-label">End Time</label>
                <input type="time" class="form-control form-control-sm">
              </div>
              <div class="col-4">
                <label class="small-label">App. Mode</label>
                <select class="form-select form-select-sm"><option>Walking</option></select>
              </div>
              <div class="col-4">
                <label class="small-label">Arrival Mode</label>
                <select class="form-select form-select-sm"><option>Walking</option></select>
              </div>
              <div class="col-4">
                <label class="small-label">Con Type</label>
                <select class="form-select form-select-sm"><option>New</option><option>Old</option></select>
              </div>
              <div class="col-4">
                <label class="small-label">HN / No HN</label>
                <select class="form-select form-select-sm"><option>HN</option><option>No HN</option></select>
              </div>
              <div class="col-8">
                <label class="small-label">Patient</label>
                <input type="text" class="form-control form-control-sm">
              </div>
              <div class="col-2">
                <label class="small-label">Age</label>
                <input type="text" class="form-control form-control-sm" placeholder="YY">
              </div>
              <div class="col-2">
                <label class="small-label">Phone</label>
                <input type="text" class="form-control form-control-sm">
              </div>
            </div>
            <div class="mt-3 d-flex justify-content-between align-items-center">
              <div class="form-check">
                <input type="checkbox" class="form-check-input" id="printReport">
                <label for="printReport" class="form-check-label small">Print Report?</label>
              </div>
              <div>
                <button class="btn btn-primary btn-sm">New</button>
                <button class="btn btn-success btn-sm">Save</button>
                <button class="btn btn-warning btn-sm text-dark">Token</button>
                <button class="btn btn-info btn-sm text-dark">Report</button>
              </div>
            </div>
            <div class="progress mt-3" style="height: 8px;">
              <div class="progress-bar bg-success" style="width: 70%;"></div>
            </div>
          </div>
          <div class="tab-pane fade" id="cancel">
            <p class="small text-light mt-2">Cancelled appointments list here...</p>
          </div>
          <div class="tab-pane fade" id="replace">
            <p class="small text-light mt-2">Cancelled & replaced appointments list here...</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
