document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.editKegiatanBtn');
    const modal = document.getElementById('editKegiatanModal');
    const form = document.getElementById('editKegiatanForm');
    const cancelBtn = document.getElementById('cancelEditBtn');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const kegiatanId = this.getAttribute('data-kegiatan-id');
            const judul = this.getAttribute('data-judul');
            const kuota = this.getAttribute('data-kuota');
            const status = this.getAttribute('data-status');

            document.getElementById('editKegiatanId').value = kegiatanId;
            document.getElementById('editJudul').value = judul;
            document.getElementById('editKuota').value = kuota;
            document.getElementById('editStatus').value = status;

            modal.classList.remove('hidden');
        });
    });

    cancelBtn.addEventListener('click', function () {
        modal.classList.add('hidden');
        form.reset();
    });

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        fetch(`/buatKegiatan/store/${document.getElementById('editKegiatanId').value}`, {
            method: 'PUT',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                modal.classList.add('hidden');
                location.reload();
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    });
});