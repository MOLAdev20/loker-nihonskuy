import Swal from "sweetalert2";

window.Swal = Swal;

const sidebar = document.getElementById("sidebar");
const overlay = document.getElementById("overlay");
const btnOpen = document.getElementById("btnOpen");

function openSidebar() {
    sidebar.classList.remove("-translate-x-full");
    overlay.classList.remove("hidden");
    btnOpen.setAttribute("aria-expanded", "true");
    document.body.classList.add("overflow-hidden"); // lock scroll (mobile)
}

function closeSidebar() {
    sidebar.classList.add("-translate-x-full");
    overlay.classList.add("hidden");
    btnOpen.setAttribute("aria-expanded", "false");
    document.body.classList.remove("overflow-hidden");
}

btnOpen.addEventListener("click", () => {
    const isClosed = sidebar.classList.contains("-translate-x-full");
    isClosed ? openSidebar() : closeSidebar();
});

overlay.addEventListener("click", closeSidebar);

// ESC to close
window.addEventListener("keydown", (e) => {
    if (e.key === "Escape") closeSidebar();
});

// Kalau pindah ke desktop, pastikan overlay mati & body scroll balik normal
window.addEventListener("resize", () => {
    if (window.matchMedia("(min-width: 1024px)").matches) {
        overlay.classList.add("hidden");
        document.body.classList.remove("overflow-hidden");
        sidebar.classList.remove("-translate-x-full");
        btnOpen.setAttribute("aria-expanded", "false");
    } else {
        // di mobile defaultnya tertutup
        closeSidebar();
    }
});

const logoutForms = document.querySelectorAll(".js-logout-form");

logoutForms.forEach((form) => {
    form.addEventListener("submit", async (event) => {
        event.preventDefault();

        if (typeof Swal === "undefined") {
            if (confirm("Yakin ingin logout?")) {
                form.submit();
            }

            return;
        }

        const result = await Swal.fire({
            title: "Logout?",
            text: "Anda yakin ingin logout?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, logout",
            cancelButtonText: "Batal",
            confirmButtonColor: "#0f172a",
            cancelButtonColor: "#64748b",
            reverseButtons: true,
        });

        if (result.isConfirmed) {
            form.submit();
        }
    });
});