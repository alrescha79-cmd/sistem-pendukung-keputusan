document.addEventListener("DOMContentLoaded", function () {
    const deleteButtons = document.querySelectorAll(".btn-delete");
    const btnConfirmDeleteAlternatif = document.getElementById("btnConfirmDeleteAlternatif");
    const btnConfirmDeleteKriteria = document.getElementById("btnConfirmDeleteKriteria");
    const deleteAlternatifModal = new bootstrap.Modal(document.getElementById("deleteAlternatifModal"));
    const deleteKriteriaModal = new bootstrap.Modal(document.getElementById("deleteKriteriaModal"));


    let selectedId; // Variabel untuk menyimpan ID kriteria yang akan dihapus
    let selectedName; // Variabel untuk menyimpan nama kriteria yang akan dihapus

    deleteButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            selectedId = this.getAttribute("data-id");
            selectedName = this.getAttribute("data-name"); // Ambil nama kriteria dari atribut data-name
        });
    });

    // Event listener untuk tombol konfirmasi hapus dan mengarahkan ke halaman hapus
    btnConfirmDeleteAlternatif.addEventListener("click", function () {
        if (selectedId) {
            window.location.href = `?page=alternatif&action=hapus&id_alternatif=${selectedId}`;
        }
    });

    btnConfirmDeleteKriteria.addEventListener("click", function () {
        if (selectedId) {
            window.location.href = `?page=kriteria&action=hapus&id_kriteria=${selectedId}`;
        }
    });


    // Event listener untuk menampilkan nama kriteria yang akan dihapus pada modal
    deleteKriteriaModal._element.addEventListener("shown.bs.modal", function () {
        const modalTitle = this.querySelector("#namaKri");
        modalTitle.textContent = `${selectedName}`; // Ubah judul modal sesuai dengan nama kriteria yang akan dihapus
    });


    deleteAlternatifModal._element.addEventListener("shown.bs.modal", function () {
        const modalTitle = this.querySelector("#namaAlt");
        modalTitle.textContent = `${selectedName}`; 
    });
});


