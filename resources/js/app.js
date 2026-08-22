import './bootstrap';
import 'bootstrap';

import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

document.addEventListener('DOMContentLoaded', () => {
    const doctorSelect = document.getElementById('doctor_id');
    const dateInput = document.getElementById('appointment_date');
    const slotSelect = document.getElementById('appointment_time');

    async function loadSlots() {
        if (!doctorSelect || !dateInput || !slotSelect) return;
        const doctorId = doctorSelect.value;
        const date = dateInput.value;
        if (!doctorId || !date) return;

        slotSelect.innerHTML = '<option>Loading available slots...</option>';
        try {
            const res = await window.axios.get(`/api/doctors/${doctorId}/available-slots`, { params: { date } });
            const slots = res.data.slots || [];
            if (slots.length === 0) {
                slotSelect.innerHTML = '<option value="">No slots available this day</option>';
                return;
            }
            slotSelect.innerHTML = slots.map(s => `<option value="${s.value}">${s.label}</option>`).join('');
        } catch (e) {
            slotSelect.innerHTML = '<option value="">Could not load slots</option>';
        }
    }

    doctorSelect?.addEventListener('change', loadSlots);
    dateInput?.addEventListener('change', loadSlots);
});


document.addEventListener('DOMContentLoaded', () => {
    const patientSearch = document.getElementById('patient-instant-search');
    const patientResults = document.getElementById('patient-search-results');
    let searchTimer;

    patientSearch?.addEventListener('input', (e) => {
        clearTimeout(searchTimer);
        const q = e.target.value.trim();
        searchTimer = setTimeout(async () => {
            if (q.length < 2) { patientResults.innerHTML = ''; return; }
            try {
                const res = await window.axios.get('/api/patients/search', { params: { q } });
                patientResults.innerHTML = res.data.map(p =>
                    `<a href="/patients/${p.id}" class="d-block px-3 py-2 text-decoration-none border-bottom small">
                        <strong>${p.full_name}</strong> <span class="text-muted">· ${p.phone ?? ''}</span>
                    </a>`
                ).join('') || '<div class="px-3 py-2 text-muted small">No matches</div>';
            } catch (e) {
                patientResults.innerHTML = '';
            }
        }, 300);
    });

    document.addEventListener('click', (e) => {
        if (patientResults && !patientResults.contains(e.target) && e.target !== patientSearch) {
            patientResults.innerHTML = '';
        }
    });
});

