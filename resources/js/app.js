import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('mobileCarousel', (options = {}) => ({
    active: 0,
    total: Math.max(1, options.count ?? 1),
    peek: Boolean(options.peek),
    touchStartX: 0,
    touchDelta: 0,
    slideOffset: 0,

    get trackStyle() {
        if (this.peek && this.slideOffset > 0) {
            return { transform: `translateX(-${this.slideOffset}px)` };
        }

        return { transform: `translateX(-${this.active * 100}%)` };
    },

    init() {
        this.$nextTick(() => {
            this.measure();
            window.addEventListener('resize', () => this.measure(), { passive: true });
        });
    },

    measure() {
        const viewport = this.$refs.viewport;
        const track = this.$refs.track;

        if (!viewport || !track) {
            return;
        }

        const slides = [...track.children];

        if (slides.length === 0) {
            return;
        }

        if (this.peek) {
            const slide = slides[0];
            const gap = parseFloat(getComputedStyle(track).columnGap || getComputedStyle(track).gap) || 16;
            this.slideOffset = this.active * (slide.offsetWidth + gap);
        }

        const activeSlide = slides[this.active];

        if (activeSlide) {
            viewport.style.minHeight = `${activeSlide.offsetHeight}px`;
        }
    },

    goTo(index) {
        this.active = Math.max(0, Math.min(index, this.total - 1));
        this.$nextTick(() => this.measure());
    },

    next() {
        this.goTo(this.active + 1);
    },

    prev() {
        this.goTo(this.active - 1);
    },

    onTouchStart(event) {
        this.touchStartX = event.changedTouches[0].screenX;
        this.touchDelta = 0;
    },

    onTouchEnd(event) {
        const endX = event.changedTouches[0].screenX;
        this.touchDelta = this.touchStartX - endX;

        if (Math.abs(this.touchDelta) < 48) {
            return;
        }

        if (this.touchDelta > 0) {
            this.next();
        } else {
            this.prev();
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

function initTechMarquee() {
    const tracks = document.querySelectorAll('[data-tech-marquee]');

    tracks.forEach((track) => {
        if (track.dataset.marqueeReady) {
            return;
        }

        track.dataset.marqueeReady = '1';

        const items = [...track.children];

        if (items.length < 2) {
            return;
        }

        items.forEach((node) => {
            track.appendChild(node.cloneNode(true));
        });

        let paused = false;
        let resumeTimer = null;
        const speed = 0.35;

        const pause = () => {
            paused = true;
            clearTimeout(resumeTimer);
        };

        const resumeLater = (delay = 2500) => {
            clearTimeout(resumeTimer);
            resumeTimer = setTimeout(() => {
                paused = false;
            }, delay);
        };

        track.addEventListener('touchstart', pause, { passive: true });
        track.addEventListener('touchend', () => resumeLater(), { passive: true });
        track.addEventListener('mouseenter', pause);
        track.addEventListener('mouseleave', () => {
            paused = false;
        });

        const tick = () => {
            if (!paused && track.scrollWidth > track.clientWidth) {
                track.scrollLeft += speed;

                const half = track.scrollWidth / 2;

                if (track.scrollLeft >= half) {
                    track.scrollLeft -= half;
                }
            }

            requestAnimationFrame(tick);
        };

        requestAnimationFrame(tick);
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initRevealAnimations();
    initTechMarquee();
});
