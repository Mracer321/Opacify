import Alpine from 'alpinejs';
import {
    createIcons,
    ArrowRight, Check, CircleCheck, MessageSquare, CircleHelp, FileText, Globe, Lock,
    Shield, ShieldCheck, Sparkles, Workflow, Cpu, TrendingUp, LineChart, AppWindow,
    Smartphone, Building2, Terminal, Megaphone, Code, Layers, Network, Server, Database,
    Cloud, Clock, UserCheck, Briefcase, UserPlus, Users, ClipboardList, ClipboardCheck,
    Rocket, Flag, CircleDollarSign, Mail, Phone, MapPin, Bug,
} from 'lucide';

// Centralized Lucide init — replaces <i data-lucide="..."> placeholders rendered by <x-icon>.
const lucideIcons = {
    ArrowRight, Check, CircleCheck, MessageSquare, CircleHelp, FileText, Globe, Lock,
    Shield, ShieldCheck, Sparkles, Workflow, Cpu, TrendingUp, LineChart, AppWindow,
    Smartphone, Building2, Terminal, Megaphone, Code, Layers, Network, Server, Database,
    Cloud, Clock, UserCheck, Briefcase, UserPlus, Users, ClipboardList, ClipboardCheck,
    Rocket, Flag, CircleDollarSign, Mail, Phone, MapPin, Bug,
};

function initLucideIcons() {
    createIcons({ icons: lucideIcons, attrs: { 'stroke-width': 1.75 } });
}

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

// Admin-only: block-based blog content editor. Registered before Alpine.start().
Alpine.data('blogEditor', (options = {}) => ({
    blocks: (options.blocks ?? []).map((b) => ({ ...b, _uploading: false })),
    uploadUrl: options.uploadUrl,
    csrf: options.csrf,
    blockTypes: [
        { type: 'paragraph', label: 'Paragraph' },
        { type: 'heading', label: 'Heading' },
        { type: 'list', label: 'List' },
        { type: 'quote', label: 'Quote' },
        { type: 'code', label: 'Code' },
        { type: 'command', label: 'Command' },
        { type: 'image', label: 'Image' },
    ],

    blockLabel(type) {
        return (this.blockTypes.find((t) => t.type === type) || { label: type }).label;
    },

    add(type) {
        this.blocks.push({
            type,
            text: '',
            level: 2,
            style: 'bulleted',
            items: type === 'list' ? [''] : [],
            language: '',
            code: '',
            path: '',
            url: '',
            alt: '',
            title: '',
            caption: '',
            _uploading: false,
        });
    },

    remove(index) {
        this.blocks.splice(index, 1);
    },

    move(index, delta) {
        const target = index + delta;
        if (target < 0 || target >= this.blocks.length) {
            return;
        }
        const [item] = this.blocks.splice(index, 1);
        this.blocks.splice(target, 0, item);
    },

    async uploadImage(event, block) {
        const file = event.target.files?.[0];
        if (!file) {
            return;
        }

        const body = new FormData();
        body.append('image', file);
        body.append('topic', document.getElementById('title')?.value || '');

        block._uploading = true;
        try {
            const response = await fetch(this.uploadUrl, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': this.csrf, Accept: 'application/json' },
                body,
            });
            if (!response.ok) {
                throw new Error('Upload failed');
            }
            const data = await response.json();
            block.path = data.path;
            block.url = data.url;
            // Only fill blank metadata — never overwrite what the admin typed.
            const d = data.defaults || {};
            if (!block.alt) block.alt = d.alt || '';
            if (!block.title) block.title = d.title || '';
            if (!block.caption) block.caption = d.caption || '';
        } catch (error) {
            window.alert('Image upload failed. Please try again.');
        } finally {
            block._uploading = false;
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
    initLucideIcons();
    initRevealAnimations();
    initTechMarquee();
});
