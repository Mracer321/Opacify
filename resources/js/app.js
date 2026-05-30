import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('mobileCarousel', (total) => ({
    active: 0,
    total: Math.max(1, total),
    touchStartX: 0,
    touchDelta: 0,

    goTo(index) {
        this.active = Math.max(0, Math.min(index, this.total - 1));
    },

    onTouchStart(event) {
        this.touchStartX = event.changedTouches[0].screenX;
        this.touchDelta = 0;
    },

    onTouchEnd(event) {
        const endX = event.changedTouches[0].screenX;
        this.touchDelta = this.touchStartX - endX;

        if (Math.abs(this.touchDelta) < 40) {
            return;
        }

        if (this.touchDelta > 0) {
            this.goTo(this.active + 1);
        } else {
            this.goTo(this.active - 1);
        }
    },
}));

Alpine.start();

function initRevealAnimations() {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
    );

    document.querySelectorAll('.reveal-on-scroll').forEach((el, index) => {
        if (el.dataset.revealDelay) {
            el.style.transitionDelay = `${el.dataset.revealDelay}ms`;
        } else if (el.closest('[data-reveal-stagger]')) {
            el.style.transitionDelay = `${Math.min(index * 60, 360)}ms`;
        }
        observer.observe(el);
    });
}

document.addEventListener('DOMContentLoaded', initRevealAnimations);
