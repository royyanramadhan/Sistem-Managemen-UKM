/**
 * PORTAL UKM — Animations
 * Vanilla JS: scroll reveal (IntersectionObserver) + counter angka statistik.
 * Menghormati prefers-reduced-motion.
 */

(function () {
    'use strict';

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // ===== 1. Scroll Reveal =====
    // Elemen dengan class .portal-reveal akan di-observe.
    // Saat masuk viewport → tambah .portal-reveal-in (transisi opacity+transform).
    // Stagger delay via data-reveal-delay (ms) atau class .portal-stagger-*.
    function initScrollReveal() {
        const items = document.querySelectorAll('.portal-reveal');
        if (!items.length) return;

        // Jika user prefer reduced motion → langsung tampilkan semua tanpa animasi.
        if (prefersReducedMotion) {
            items.forEach((el) => {
                el.classList.add('portal-reveal-in');
            });
            return;
        }

        if (!('IntersectionObserver' in window)) {
            items.forEach((el) => el.classList.add('portal-reveal-in'));
            return;
        }

        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        const el = entry.target;
                        const delay = parseInt(el.dataset.revealDelay || '0', 10);
                        if (delay > 0) {
                            el.style.transitionDelay = delay + 'ms';
                        }
                        el.classList.add('portal-reveal-in');
                        observer.unobserve(el);
                    }
                });
            },
            { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
        );

        items.forEach((el) => observer.observe(el));
    }

    // ===== 2. Counter Angka Statistik =====
    // Elemen dengan class .portal-counter dan data-counter-value akan dianimasikan
    // dari 0 naik ke nilai asli saat masuk viewport.
    function animateCounter(el, target, duration) {
        const start = performance.now();
        const step = (now) => {
            const progress = Math.min((now - start) / duration, 1);
            // ease-out cubic
            const eased = 1 - Math.pow(1 - progress, 3);
            const current = Math.round(target * eased);
            el.textContent = current.toLocaleString('id-ID');
            if (progress < 1) {
                requestAnimationFrame(step);
            } else {
                el.textContent = target.toLocaleString('id-ID');
            }
        };
        requestAnimationFrame(step);
    }

    function initCounters() {
        const counters = document.querySelectorAll('.portal-counter[data-counter-value]');
        if (!counters.length) return;

        if (prefersReducedMotion) {
            counters.forEach((el) => {
                el.textContent = el.dataset.counterValue;
            });
            return;
        }

        if (!('IntersectionObserver' in window)) {
            counters.forEach((el) => {
                el.textContent = el.dataset.counterValue;
            });
            return;
        }

        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        const el = entry.target;
                        const target = parseInt(el.dataset.counterValue || '0', 10);
                        const duration = parseInt(el.dataset.counterDuration || '1000', 10);
                        animateCounter(el, target, duration);
                        observer.unobserve(el);
                    }
                });
            },
            { threshold: 0.4 }
        );

        counters.forEach((el) => observer.observe(el));
    }

    // ===== 3. Progress bar & Bar chart animasi (width/height dari 0) =====
    // Elemen dengan class .portal-progress-animate akan di-set width/height dari 0
    // lalu dianimasikan ke nilai data-progress-target saat masuk viewport.
    function initProgressBars() {
        const bars = document.querySelectorAll('.portal-progress-animate');
        if (!bars.length) return;

        if (prefersReducedMotion) {
            bars.forEach((el) => {
                const target = el.dataset.progressTarget;
                if (target) {
                    if (el.dataset.progressAxis === 'height') {
                        el.style.height = target + '%';
                    } else {
                        el.style.width = target + '%';
                    }
                }
            });
            return;
        }

        if (!('IntersectionObserver' in window)) {
            bars.forEach((el) => {
                const target = el.dataset.progressTarget;
                if (target) {
                    if (el.dataset.progressAxis === 'height') {
                        el.style.height = target + '%';
                    } else {
                        el.style.width = target + '%';
                    }
                }
            });
            return;
        }

        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        const el = entry.target;
                        const target = el.dataset.progressTarget;
                        if (target) {
                            // Mulai dari 0
                            if (el.dataset.progressAxis === 'height') {
                                el.style.height = '0%';
                                requestAnimationFrame(() => {
                                    requestAnimationFrame(() => {
                                        el.style.height = target + '%';
                                    });
                                });
                            } else {
                                el.style.width = '0%';
                                requestAnimationFrame(() => {
                                    requestAnimationFrame(() => {
                                        el.style.width = target + '%';
                                    });
                                });
                            }
                        }
                        observer.unobserve(el);
                    }
                });
            },
            { threshold: 0.3 }
        );

        bars.forEach((el) => observer.observe(el));
    }

    // ===== Init =====
    document.addEventListener('DOMContentLoaded', () => {
        initScrollReveal();
        initCounters();
        initProgressBars();
    });
})();