import InitSearchableSelect from "../components/searchable-select";
import Swiper from "swiper";
import { Autoplay, Navigation, Pagination } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";

document.addEventListener("DOMContentLoaded", () => {
    InitSearchableSelect();

    (() => {
        const urgentJobsSwiper = document.querySelector(".urgent-jobs-swiper");
        const urgentJobsPrevButton = document.querySelector(".urgent-jobs-swiper-prev");
        const urgentJobsNextButton = document.querySelector(".urgent-jobs-swiper-next");
        const urgentJobsPagination = document.querySelector(".urgent-jobs-swiper-pagination");

        if (!urgentJobsSwiper || !urgentJobsPrevButton || !urgentJobsNextButton || !urgentJobsPagination) {
            return;
        }

        const slideCount = urgentJobsSwiper.querySelectorAll(".swiper-slide").length;
        const isLoopEnabled = slideCount > 3;

        new Swiper(urgentJobsSwiper, {
            modules: [Autoplay, Navigation, Pagination],
            slidesPerView: 1,
            spaceBetween: 16,
            loop: isLoopEnabled,
            autoplay: slideCount > 1 ? {
                delay: 2500,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            } : false,
            navigation: {
                prevEl: urgentJobsPrevButton,
                nextEl: urgentJobsNextButton,
            },
            pagination: {
                el: urgentJobsPagination,
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
                1280: {
                    slidesPerView: 3,
                },
            },
        });
    })();

    (() => {
        const testimonialsSwiper = document.querySelector(".testimonials-swiper");
        const testimonialsPrevButton = document.querySelector(".testimonials-swiper-prev");
        const testimonialsNextButton = document.querySelector(".testimonials-swiper-next");
        const testimonialsPagination = document.querySelector(".testimonials-swiper-pagination");

        if (!testimonialsSwiper || !testimonialsPrevButton || !testimonialsNextButton || !testimonialsPagination) {
            return;
        }

        const slideCount = testimonialsSwiper.querySelectorAll(".swiper-slide").length;

        new Swiper(testimonialsSwiper, {
            modules: [Autoplay, Navigation, Pagination],
            slidesPerView: 1,
            slidesPerGroup: 1,
            spaceBetween: 16,
            loop: slideCount > 1,
            autoplay: slideCount > 1 ? {
                delay: 4500,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            } : false,
            navigation: {
                prevEl: testimonialsPrevButton,
                nextEl: testimonialsNextButton,
            },
            pagination: {
                el: testimonialsPagination,
                clickable: true,
            },
        });
    })();

    (() => {
        const rundownSwiper = document.querySelector(".rundown-swiper");
        const rundownPrevButton = document.querySelector(".rundown-swiper-prev");
        const rundownNextButton = document.querySelector(".rundown-swiper-next");
        const rundownPagination = document.querySelector(".rundown-swiper-pagination");

        if (!rundownSwiper || !rundownPrevButton || !rundownNextButton || !rundownPagination) {
            return;
        }

        const slideCount = rundownSwiper.querySelectorAll(".swiper-slide").length;

        new Swiper(rundownSwiper, {
            modules: [Autoplay, Navigation, Pagination],
            slidesPerView: 1,
            slidesPerGroup: 1,
            spaceBetween: 0,
            loop: false,
            autoplay: false,
            navigation: {
                prevEl: rundownPrevButton,
                nextEl: rundownNextButton,
            },
            pagination: {
                el: rundownPagination,
                clickable: true,
            },
            breakpoints: {
                0: {
                    slidesPerView: 1.05,
                },
                640: {
                    slidesPerView: 2,
                    slidesPerGroup: 1,
                },
                1024: {
                    slidesPerView: 3,
                    slidesPerGroup: 1,
                },
            },
        });
    })();

    // Mobil menu toggle logic
    (() => {
        const btn = document.getElementById("menu-btn");
        const menu = document.getElementById("mobile-menu");
        const openClasses = [
            "opacity-100",
            "scale-100",
            "translate-y-0",
            "max-h-[480px]",
            "pointer-events-auto",
        ];
        const closedClasses = [
            "opacity-0",
            "scale-95",
            "-translate-y-1",
            "max-h-0",
            "pointer-events-none",
        ];

        if (!btn || !menu) {
            return;
        }

        const applyOpenState = () => {
            menu.classList.remove("hidden");
            menu.classList.remove(...closedClasses);
            menu.classList.add(...openClasses);
            menu.dataset.state = "open";
            btn.setAttribute("aria-expanded", "true");
        };

        const applyClosedState = () => {
            menu.classList.remove(...openClasses);
            menu.classList.add(...closedClasses);
            menu.dataset.state = "closed";
            btn.setAttribute("aria-expanded", "false");
        };

        const openMenu = () => {
            if (menu.dataset.state === "open") return;
            menu.classList.remove("hidden");
            menu.classList.add(...closedClasses);
            requestAnimationFrame(() => {
                requestAnimationFrame(applyOpenState);
            });
        };

        const closeMenu = () => {
            if (menu.dataset.state === "closed") return;
            applyClosedState();
            const onEnd = (event) => {
                if (event.propertyName !== "max-height") return;
                if (menu.dataset.state === "closed") {
                    menu.classList.add("hidden");
                }
                menu.removeEventListener("transitionend", onEnd);
            };
            menu.addEventListener("transitionend", onEnd);
        };

        btn.addEventListener("click", () => {
            const isOpen = menu.dataset.state === "open";
            if (isOpen) {
                closeMenu();
            } else {
                openMenu();
            }
        });

        document.addEventListener("click", (event) => {
            if (menu.dataset.state !== "open") return;
            if (menu.contains(event.target) || btn.contains(event.target)) return;
            closeMenu();
        });

        menu.addEventListener("click", (event) => {
            if (event.target.closest("a")) {
                closeMenu();
            }
        });
    })();

});
