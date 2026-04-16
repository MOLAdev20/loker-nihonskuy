const sidebar = document.getElementById("userSidebar");
const sidebarOverlay = document.getElementById("userSidebarOverlay");
const sidebarToggle = document.getElementById("userSidebarToggle");

const modalRoot = document.getElementById("profileModal");
const modalPanel = modalRoot?.querySelector("[data-modal-panel]");

let sidebarOpen = false;
let modalOpen = false;

function syncBodyLock() {
    const isDesktop = window.matchMedia("(min-width: 1024px)").matches;
    const shouldLock = modalOpen || (!isDesktop && sidebarOpen);

    document.body.classList.toggle("overflow-hidden", shouldLock);
}

function openSidebar() {
    if (!sidebar || !sidebarOverlay || !sidebarToggle) return;

    sidebar.classList.remove("-translate-x-full");
    sidebarOverlay.classList.remove("hidden");
    requestAnimationFrame(() => sidebarOverlay.classList.remove("opacity-0"));
    sidebarToggle.setAttribute("aria-expanded", "true");
    sidebarOpen = true;
    syncBodyLock();
}

function closeSidebar() {
    if (!sidebar || !sidebarOverlay || !sidebarToggle) return;

    sidebar.classList.add("-translate-x-full");
    sidebarOverlay.classList.add("opacity-0");
    window.setTimeout(() => {
        if (!sidebarOpen) {
            sidebarOverlay.classList.add("hidden");
        }
    }, 300);
    sidebarToggle.setAttribute("aria-expanded", "false");
    sidebarOpen = false;
    syncBodyLock();
}

function setupSidebar() {
    if (!sidebar || !sidebarOverlay || !sidebarToggle) return;

    sidebarToggle.addEventListener("click", () => {
        sidebarOpen ? closeSidebar() : openSidebar();
    });

    sidebarOverlay.addEventListener("click", closeSidebar);
}

function setSubmenuState(toggle, submenu, isOpen) {
    const chevron = toggle.querySelector("[data-chevron]");
    toggle.setAttribute("aria-expanded", String(isOpen));
    submenu.style.maxHeight = isOpen ? `${submenu.scrollHeight}px` : "0px";
    submenu.classList.toggle("mt-2", isOpen);
    chevron?.classList.toggle("rotate-180", isOpen);
}

function setupSubmenus() {
    const toggles = document.querySelectorAll("[data-submenu-toggle]");

    toggles.forEach((toggle) => {
        const submenuName = toggle.getAttribute("data-submenu-toggle");
        const submenu = document.querySelector(`[data-submenu="${submenuName}"]`);

        if (!submenu) return;

        const isExpanded = toggle.getAttribute("aria-expanded") === "true";
        submenu.style.maxHeight = "0px";
        setSubmenuState(toggle, submenu, isExpanded);

        toggle.addEventListener("click", () => {
            const isOpen = toggle.getAttribute("aria-expanded") === "true";
            setSubmenuState(toggle, submenu, !isOpen);
        });
    });
}

function openModal() {
    if (!modalRoot || !modalPanel) return;

    modalRoot.classList.remove("pointer-events-none", "opacity-0");
    modalPanel.classList.remove("scale-95");
    modalOpen = true;
    syncBodyLock();
}

function closeModal() {
    if (!modalRoot || !modalPanel) return;

    modalRoot.classList.add("opacity-0");
    modalPanel.classList.add("scale-95");
    window.setTimeout(() => {
        if (!modalOpen) {
            modalRoot.classList.add("pointer-events-none");
        }
    }, 300);
    modalOpen = false;
    syncBodyLock();
}

function setupModal() {
    if (!modalRoot || !modalPanel) return;

    const openButtons = document.querySelectorAll('[data-modal-open="profile-modal"]');
    const closeButtons = modalRoot.querySelectorAll("[data-modal-close]");

    openButtons.forEach((button) => {
        button.addEventListener("click", openModal);
    });

    closeButtons.forEach((button) => {
        button.addEventListener("click", closeModal);
    });

    modalRoot.addEventListener("click", (event) => {
        if (event.target === modalRoot) {
            closeModal();
        }
    });
}

window.addEventListener("resize", () => {
    const isDesktop = window.matchMedia("(min-width: 1024px)").matches;

    if (isDesktop) {
        sidebarOverlay?.classList.add("hidden", "opacity-0");
        sidebar?.classList.remove("-translate-x-full");
        sidebarToggle?.setAttribute("aria-expanded", "false");
        sidebarOpen = false;
    } else if (!sidebarOpen) {
        sidebar?.classList.add("-translate-x-full");
    }

    document.querySelectorAll("[data-submenu]").forEach((submenu) => {
        const submenuName = submenu.getAttribute("data-submenu");
        const toggle = document.querySelector(`[data-submenu-toggle="${submenuName}"]`);
        const isOpen = toggle?.getAttribute("aria-expanded") === "true";

        submenu.style.maxHeight = isOpen ? `${submenu.scrollHeight}px` : "0px";
    });

    syncBodyLock();
});

window.addEventListener("keydown", (event) => {
    if (event.key !== "Escape") return;

    if (modalOpen) {
        closeModal();
        return;
    }

    if (sidebarOpen) {
        closeSidebar();
    }
});

setupSidebar();
setupSubmenus();
setupModal();
