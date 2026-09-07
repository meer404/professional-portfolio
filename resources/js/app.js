import './bootstrap';
import Alpine from 'alpinejs';

/* ---------------------------------------------------------------------------
 * Theme (dark mode) — resolved before paint by an inline script in the layout.
 * This store just exposes toggling + keeps <html class="dark"> in sync.
 * ------------------------------------------------------------------------- */
Alpine.store('theme', {
    dark: document.documentElement.classList.contains('dark'),

    toggle() {
        this.dark = !this.dark;
        document.documentElement.classList.toggle('dark', this.dark);
        try {
            localStorage.setItem('theme', this.dark ? 'dark' : 'light');
        } catch (e) {
            /* private mode / storage disabled — ignore */
        }
    },
});

/* ---------------------------------------------------------------------------
 * x-reveal — fade/slide a section in when it scrolls into view.
 * Usage: <div x-reveal> ... </div>  or  <div x-reveal.delay-200>
 * ------------------------------------------------------------------------- */
Alpine.directive('reveal', (el, { modifiers }) => {
    el.classList.add('reveal');

    const delayMod = modifiers.find((m) => m.startsWith('delay-'));
    if (delayMod) {
        el.style.transitionDelay = `${parseInt(delayMod.replace('delay-', ''), 10)}ms`;
    }

    if (!('IntersectionObserver' in window)) {
        el.classList.add('is-visible');
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.12, rootMargin: '0px 0px -8% 0px' }
    );

    observer.observe(el);
});

/* ---------------------------------------------------------------------------
 * x-data="typewriter(['One', 'Two'])" — cycling animated tagline.
 * ------------------------------------------------------------------------- */
Alpine.data('typewriter', (phrases = [], speed = 65, pause = 1800) => ({
    phrases,
    text: '',
    phraseIndex: 0,
    charIndex: 0,
    deleting: false,

    start() {
        if (!this.phrases.length) return;
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            this.text = this.phrases[0];
            return;
        }
        this.tick();
    },

    tick() {
        const current = this.phrases[this.phraseIndex];

        if (this.deleting) {
            this.charIndex--;
        } else {
            this.charIndex++;
        }
        this.text = current.substring(0, this.charIndex);

        let delay = this.deleting ? speed / 2 : speed;

        if (!this.deleting && this.charIndex === current.length) {
            delay = pause;
            this.deleting = true;
        } else if (this.deleting && this.charIndex === 0) {
            this.deleting = false;
            this.phraseIndex = (this.phraseIndex + 1) % this.phrases.length;
            delay = speed * 3;
        }

        setTimeout(() => this.tick(), delay);
    },
}));

window.Alpine = Alpine;
Alpine.start();
