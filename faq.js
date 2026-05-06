document.addEventListener('DOMContentLoaded', function() {
    const faqItems = document.querySelectorAll('.faq-item');

    // Exit silently if no FAQ on this page
    if (!faqItems.length) return;

    faqItems.forEach(function(item) {
        const btn = item.querySelector('.faq-question');
        if (!btn) return;

        btn.addEventListener('click', function() {
            const isOpen = item.classList.contains('is-open');

            // Close all items first
            faqItems.forEach(function(i) {
                i.classList.remove('is-open');
                const b = i.querySelector('.faq-question');
                if (b) b.setAttribute('aria-expanded', 'false');
            });

            // If it wasn't open, open it now
            if (!isOpen) {
                item.classList.add('is-open');
                btn.setAttribute('aria-expanded', 'true');
            }
        });
    });
});