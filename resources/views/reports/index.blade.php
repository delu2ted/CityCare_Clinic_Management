<x-dashboard-layout>
    <h2 class="h4 mb-4">Reports</h2>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="dash-panel h-100">
                <h6 class="mb-3">📅 Appointments Report</h6>
                <form action="{{ route('reports.appointments') }}" method="GET">
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <label class="form-label small">From</label>
                            <input type="date" name="date_from" class="form-control form-control-sm">
                        </div>
                        <div class="col-6">
                            <label class="form-label small">To</label>
                            <input type="date" name="date_to" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small">Department</label>
                        <select name="department_id" class="form-select form-select-sm">
                            <option value="">All</option>
                            @foreach($departments as $d)
                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Status</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="">All</option>
                            <option value="scheduled">Scheduled</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                            <option value="no_show">No Show</option>
                        </select>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <button type="submit" class="btn btn-outline-secondary btn-sm">View</button>
                        <button type="submit" name="format" value="pdf" class="btn btn-outline-danger btn-sm">PDF</button>
                        <button type="submit" name="format" value="excel" class="btn btn-outline-success btn-sm">Excel</button>
                        <button type="submit" name="format" value="csv" class="btn btn-outline-primary btn-sm">CSV</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-6">
            <div class="dash-panel h-100">
                <h6 class="mb-3">🩺 Doctor Schedule Report</h6>
                <form action="{{ route('reports.doctor-schedule') }}" method="GET">
                    <div class="mb-2">
                        <label class="form-label small">Doctor</label>
                        <select name="doctor_id" class="form-select form-select-sm" required>
                            <option value="">Select doctor</option>
                            @foreach($doctors as $d)
                                <option value="{{ $d->id }}">{{ $d->user->name ?? 'Unknown' }} ({{ $d->specialization }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Date</label>
                        <input type="date" name="date" class="form-control form-control-sm" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <button type="submit" class="btn btn-outline-secondary btn-sm">View</button>
                        <button type="submit" name="format" value="pdf" class="btn btn-outline-danger btn-sm">PDF</button>
                        <button type="submit" name="format" value="excel" class="btn btn-outline-success btn-sm">Excel</button>
                        <button type="submit" name="format" value="csv" class="btn btn-outline-primary btn-sm">CSV</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-6">
            <div class="dash-panel h-100">
                <h6 class="mb-3">💳 Payments Report</h6>
                <form action="{{ route('reports.payments') }}" method="GET">
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <label class="form-label small">From</label>
                            <input type="date" name="date_from" class="form-control form-control-sm">
                        </div>
                        <div class="col-6">
                            <label class="form-label small">To</label>
                            <input type="date" name="date_to" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Status</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="">All</option>
                            <option value="pending">Pending</option>
                            <option value="paid">Paid</option>
                            <option value="partially_paid">Partially Paid</option>
                            <option value="refunded">Refunded</option>
                        </select>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <button type="submit" class="btn btn-outline-secondary btn-sm">View</button>
                        <button type="submit" name="format" value="pdf" class="btn btn-outline-danger btn-sm">PDF</button>
                        <button type="submit" name="format" value="excel" class="btn btn-outline-success btn-sm">Excel</button>
                        <button type="submit" name="format" value="csv" class="btn btn-outline-primary btn-sm">CSV</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-6">
            <div class="dash-panel h-100">
                <h6 class="mb-3">🧑‍🤝‍🧑 Patient Visit Report</h6>
                <form action="{{ route('reports.patient-visits') }}" method="GET">
                    <div class="mb-3">
                        <label class="form-label small">Patient</label>
                        <select name="patient_id" class="form-select form-select-sm" required>
                            <option value="">Select patient</option>
                            @foreach(\App\Models\Patient::with('user')->get() as $p)
                                <option value="{{ $p->id }}">{{ $p->user->name ?? 'Unknown' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <button type="submit" class="btn btn-outline-secondary btn-sm">View</button>
                        <button type="submit" name="format" value="pdf" class="btn btn-outline-danger btn-sm">PDF</button>
                        <button type="submit" name="format" value="excel" class="btn btn-outline-success btn-sm">Excel</button>
                        <button type="submit" name="format" value="csv" class="btn btn-outline-primary btn-sm">CSV</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-dashboard-layout>