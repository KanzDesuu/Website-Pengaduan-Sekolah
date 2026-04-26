// ================= MODAL FEEDBACK =================
function openInputModal(id) {
    document.getElementById("feedbackModal").style.display = "block";
    document.getElementById("overlay").style.display = "block";
    document.getElementById("aspirasi_id").value = id;
}

function closeModal() {
    const feedback = document.getElementById("feedbackModal");
    const view = document.getElementById("viewModal");
    const balas = document.getElementById("balasModal");
    const overlay = document.getElementById("overlay");

    if (feedback) feedback.style.display = "none";
    if (view) view.style.display = "none";
    if (balas) balas.style.display = "none";
    if (overlay) overlay.style.display = "none";
}

// ================= TOGGLE TABLE FEEDBACK =================
function toggleFeedback(id) {
    let el = document.getElementById("feedback-" + id);

    if (el.style.display === "none" || el.style.display === "") {
        el.style.display = "table-row";
    } else {
        el.style.display = "none";
    }
}

// ================= MODAL LIHAT + EDIT =================
function openViewModal(isi, id, id_pengaduan, status) {
    document.getElementById("viewModal").style.display = "block";
    document.getElementById("overlay").style.display = "block";

    document.getElementById("isiView").innerHTML = isi;

    document.getElementById("edit_isi").value = isi;
    document.getElementById("edit_id").value = id;
    document.getElementById("edit_pengaduan_id").value = id_pengaduan;
    document.getElementById("edit_status").value = status;

    document.getElementById("viewMode").style.display = "block";
    document.getElementById("editMode").style.display = "none";
    
}
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".viewBtn").forEach(btn => {
        btn.addEventListener("click", function () {

            const isi = this.dataset.isi;
            const id = this.dataset.id;
            const id_pengaduan = this.dataset.pengaduan;
            const status = this.dataset.status;

            openViewModal(isi, id, id_pengaduan, status);
        });
    });
});
function showEdit() {
    document.getElementById("viewMode").style.display = "none";
    document.getElementById("editMode").style.display = "block";
}

function closeViewModal() {
    document.getElementById("viewModal").style.display = "none";
    document.getElementById("overlay").style.display = "none";
}

// ================= CONFIRM EDIT =================
function confirmEdit() {
    let konfirmasi = confirm("Apakah kamu yakin mau edit umpan balik ini?");

    if (konfirmasi) {
        document.querySelector("#editMode form").submit();
    }
}

// ================= MODAL BALASAN (SISWA) =================
function openModalFromBtn(btn) {
    const balasan = btn.getAttribute("data-balasan");

    const modal = document.getElementById("balasModal");
    const overlay = document.getElementById("overlay");
    const isi = document.getElementById("isiBalasan");

    if (!modal || !overlay || !isi) {
        console.error("Elemen modal tidak ditemukan!");
        return;
    }

    isi.innerText = balasan;
    modal.style.display = "block";
    overlay.style.display = "block";
}

// ================= GENERIC MODAL =================
function openModal(id) {
    document.getElementById(id).style.display = 'flex';
}

function closeModalById(id) {
    document.getElementById(id).style.display = 'none';
}

// ================= LOGOUT =================
function logout() {
    if (confirm("Yakin mau logout?")) {
        window.location.href = "../controllers/AuthController.php?action=logout";
    }
}

// ================= ANONIM CHECKBOX =================
document.addEventListener("DOMContentLoaded", function () {
    const checkbox = document.getElementById("anonimCheckbox");
    const namaField = document.getElementById("namaField");

    if (checkbox && namaField) {
        checkbox.addEventListener("change", function () {
            if (this.checked) {
                namaField.value = "Anonymous";
            } else {
                namaField.value = namaField.getAttribute("data-nama");
            }
        });
    }
});