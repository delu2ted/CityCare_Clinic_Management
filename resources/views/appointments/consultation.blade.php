<x-dashboard-layout>
    <h2 class="h4 mb-4">Consultation — {{ $appointment->patient->user->name ?? 'N/A' }}</h2>

    <div class="dash-panel mb-3">
        <p class="mb-1"><strong>Date:</strong> {{ $appointment->appointment_time->format('d M Y, H:i') }}</p>
        <p class="mb-0"><strong>Patient's Reported Concerns:</strong> {{ $appointment->notes ?? '—' }}</p>
    </div>

    <div class="dash-panel">
        <form action="{{ route('appointments.consultation.update', $appointment) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Diagnosis</label>
                <textarea name="diagnosis" class="form-control" rows="2">{{ old('diagnosis', $appointment->diagnosis) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Consultation Notes</label>
                <textarea name="consultation_notes" class="form-control" rows="4">{{ old('consultation_notes', $appointment->consultation_notes) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Prescription</label>
                <textarea name="prescription" class="form-control" rows="3">{{ old('prescription', $appointment->prescription) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="form-label">Appointment Status</label>
                <select name="status" class="form-select" required>
                    @foreach(['scheduled','completed','cancelled','no_show'] as $s)
                        <option value="{{ $s }}" {{ $appointment->status === $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Save Consultation</button>
                <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</x-dashboard-layout>