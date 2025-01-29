// script.js

// Fungsi untuk validasi form
function validateForm(formId) {
    const form = document.getElementById(formId);
    let isValid = true;

    form.querySelectorAll("input, select, textarea").forEach((input) => {
        if (input.required && input.value.trim() === "") {
            isValid = false;
            alert(`Field ${input.name} wajib diisi.`);
        }
    });

    return isValid;
}

// Fungsi untuk menampilkan popup message
function showPopupMessage(message, type = "info") {
    const popup = document.createElement("div");
    popup.className = `popup-message ${type}`;
    popup.textContent = message;

    document.body.appendChild(popup);

    setTimeout(() => {
        popup.remove();
    }, 3000);
}

// Fungsi untuk logout
function logout() {
    if (confirm("Anda yakin ingin logout?")) {
        window.location.href = "logout.php";
    }
}

// Fungsi untuk menampilkan jarak pendaftar
function calculateDistance(lat1, lon1, lat2, lon2) {
    const toRad = (value) => (value * Math.PI) / 180;
    const R = 6371; // Radius bumi dalam km

    const dLat = toRad(lat2 - lat1);
    const dLon = toRad(lon2 - lon1);
    const a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
        Math.sin(dLon / 2) * Math.sin(dLon / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    const distance = R * c;

    return distance.toFixed(2); // Jarak dalam km
}

// Event listener untuk tombol submit form pendaftaran
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("registration-form");

    if (form) {
        form.addEventListener("submit", (e) => {
            if (!validateForm("registration-form")) {
                e.preventDefault(); // Mencegah submit jika form tidak valid
            }
        });
    }
});
