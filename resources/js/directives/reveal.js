/**
 * v-reveal Directive
 * Adds smooth scroll-reveal / entrance animation using IntersectionObserver.
 * 
 * Usage:
 *   v-reveal
 *   v-reveal="{ delay: 150, direction: 'up', duration: 700 }"
 *   v-reveal.fade
 *   v-reveal.scale
 */

const observerMap = new WeakMap();

export const vReveal = {
    mounted(el, binding) {
        // If reduced motion is preferred, display immediately
        if (typeof window !== 'undefined' && window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            el.classList.add('is-revealed');
            return;
        }

        // If IntersectionObserver is not supported, reveal immediately
        if (typeof window === 'undefined' || !('IntersectionObserver' in window)) {
            el.classList.add('is-revealed');
            return;
        }

        const value = binding.value || {};
        const delay = value.delay || 0;
        const duration = value.duration || 1150;
        const threshold = value.threshold !== undefined ? value.threshold : 0.08;
        const rootMargin = value.rootMargin || '0px 0px -30px 0px';
        const once = value.once !== undefined ? value.once : true;

        // Determine direction
        let direction = value.direction || 'up';
        if (binding.modifiers.fade) direction = 'fade';
        else if (binding.modifiers.scale) direction = 'scale';
        else if (binding.modifiers.down) direction = 'down';
        else if (binding.modifiers.left) direction = 'left';
        else if (binding.modifiers.right) direction = 'right';

        el.classList.add('reveal-init');
        el.classList.add(`reveal-${direction}`);

        if (delay) {
            el.style.setProperty('--reveal-delay', `${delay}ms`);
        }
        if (duration) {
            el.style.setProperty('--reveal-duration', `${duration}ms`);
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    // Trigger reveal
                    el.classList.add('is-revealed');

                    if (once) {
                        observer.unobserve(el);
                        observerMap.delete(el);
                    }
                } else if (!once) {
                    el.classList.remove('is-revealed');
                }
            });
        }, {
            threshold,
            rootMargin,
        });

        observer.observe(el);
        observerMap.set(el, observer);
    },

    unmounted(el) {
        const observer = observerMap.get(el);
        if (observer) {
            observer.unobserve(el);
            observerMap.delete(el);
        }
    },
};

export default vReveal;
