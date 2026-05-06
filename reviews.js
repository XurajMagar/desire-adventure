// ============================================
// REVIEWS SLIDER
// ============================================
function moveSlider(direction) {
    const slider = document.getElementById('reviewsSlider');
    if (!slider) return;

    const firstCard = slider.querySelector('.ta-card');
    if (firstCard) {
        const cardWidth = firstCard.getBoundingClientRect().width + 15;
        slider.scrollBy({
            left: direction * cardWidth,
            behavior: 'smooth'
        });
    }
}

// ============================================
// REVIEW MODALS
// ============================================
function openReview(id) {
    const modal = document.getElementById('review-modal-' + id);
    if (modal) {
        modal.showModal();
        document.body.style.overflow = 'hidden';
    }
}

function closeReview(id) {
    const modal = document.getElementById('review-modal-' + id);
    if (modal) {
        modal.close();
        document.body.style.overflow = 'auto';
    }
}

// ============================================
// LIGHTBOX
// ============================================
function openLightbox(src) {
    const lb = document.getElementById('lightbox-modal');
    const img = document.getElementById('lightbox-img');
    const btn = document.getElementById('lightbox-close-btn');
    if (lb && img) {
        img.src = src;
        lb.showModal();
        if (btn) btn.style.display = 'flex';
    }
}

// ============================================
// DOM READY
// ============================================
document.addEventListener('DOMContentLoaded', function() {

    // --- Lightbox close button ---
    const lb = document.getElementById('lightbox-modal');
    const btn = document.getElementById('lightbox-close-btn');

    if (btn) {
        btn.style.display = 'none';
        btn.addEventListener('click', function() {
            if (lb) lb.close();
            btn.style.display = 'none';
        });
    }

    if (lb) {
        lb.addEventListener('click', function(e) {
            if (e.target === lb) {
                lb.close();
                if (btn) btn.style.display = 'none';
            }
        });
    }

    // --- Review modal: close on backdrop click ---
    document.querySelectorAll('.review-dialog').forEach(function(modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.close();
                document.body.style.overflow = 'auto';
            }
        });

        // --- Reset scroll lock on Escape key too ---
        modal.addEventListener('close', function() {
            document.body.style.overflow = 'auto';
        });
    });

});