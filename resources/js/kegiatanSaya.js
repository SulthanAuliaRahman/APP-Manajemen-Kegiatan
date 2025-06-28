document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.editKegiatanBtn');
    const modal = document.getElementById('editKegiatanModal');
    const form = document.getElementById('editKegiatanForm');
    const cancelBtn = document.getElementById('cancelEditBtn');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Debug log
    console.log('KegiatanSaya.js loaded');
    console.log('Edit buttons found:', editButtons.length);

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const kegiatanId = this.getAttribute('data-kegiatan-id');
            const judul = this.getAttribute('data-judul');
            const deskripsi = this.getAttribute('data-deskripsi');
            const kuota = this.getAttribute('data-kuota');
            const status = this.getAttribute('data-status');

            console.log('Editing kegiatan:', { kegiatanId, judul, deskripsi, kuota, status });

            // Jangan biarkan edit kegiatan yang sudah approved
            if (status === 'approved') {
                alert('Kegiatan yang sudah di-approve tidak dapat diedit!');
                return;
            }

            document.getElementById('editKegiatanId').value = kegiatanId;
            document.getElementById('editJudul').value = judul;
            document.getElementById('editDeskripsi').value = deskripsi;
            document.getElementById('editKuota').value = kuota;

            modal.classList.remove('hidden');
        });
    });

    // Close modal when clicking cancel
    cancelBtn.addEventListener('click', function () {
        modal.classList.add('hidden');
        form.reset();
    });

    // Close modal when clicking outside
    modal.addEventListener('click', function (e) {
        if (e.target === modal) {
            modal.classList.add('hidden');
            form.reset();
        }
    });

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(form);
        const kegiatanId = document.getElementById('editKegiatanId').value;

        // Debug log for form data
        for (let [key, value] of formData.entries()) {
            console.log('FormData:', key, value);
        }

        console.log('Submitting form for kegiatan ID:', kegiatanId);

        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.textContent = 'Updating...';
        submitBtn.disabled = true;

        fetch(`/buatKegiatan/update/${kegiatanId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                // Note: Do not set Content-Type manually with FormData; let the browser handle it
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            
            if (data.success) {
                modal.classList.add('hidden');
                form.reset();
                alert('Kegiatan berhasil diupdate!');
                location.reload();
            } else {
                alert(data.message || 'Terjadi kesalahan saat mengupdate kegiatan');
                console.log('Validation errors:', data.errors); // Log detailed errors
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengupdate kegiatan');
        })
        .finally(() => {
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
        });
    });
});