document.addEventListener('DOMContentLoaded', function() {

    // ============================================
    // 1. MOBILE MENU TOGGLE (old — keep for safety)
    // ============================================
    const toggle = document.querySelector('.menu-toggle');
    const menu = document.querySelector('.nav-menu');

    if (toggle && menu) {
        toggle.addEventListener('click', function() {
            menu.classList.toggle('is-active');
            toggle.classList.toggle('open');
            const isExpanded = menu.classList.contains('is-active');
            toggle.setAttribute('aria-expanded', isExpanded);
        });
    }

    // ============================================
    // 2. REGION SLIDER — Custom centered slider
    // ============================================
    (function() {
        const track = document.getElementById('rsTrack');
        if (!track) return;

        const slides = Array.from(track.querySelectorAll('.rs-slide'));
        const total = slides.length;
        let current = 0;

        function render() {
            slides.forEach((slide, i) => {
                let offset = i - current;

                // Handle loop wrap
                if (offset > total / 2) offset -= total;
                if (offset < -total / 2) offset += total;

                const absOffset = Math.abs(offset);
                const isMobile = window.innerWidth <= 639;
                const gap = isMobile ? 160 : 220;

                const x = offset * gap;
                const scale = absOffset === 0 ? 1 :
                    absOffset === 1 ? 0.82 :
                    absOffset === 2 ? 0.66 :
                    0.52;
                const opacity = absOffset === 0 ? 1 :
                    absOffset === 1 ? 0.55 :
                    absOffset === 2 ? 0.3 :
                    0;
                const zIndex = 20 - absOffset;
                const grayscale = absOffset === 0 ? 0 : Math.min(absOffset * 35, 80);

                slide.style.transform = `translateX(${x}px) scale(${scale})`;
                slide.style.opacity = opacity;
                slide.style.zIndex = zIndex;
                slide.style.filter = grayscale > 0 ? `grayscale(${grayscale}%)` : 'none';
                slide.style.display = absOffset > 3 ? 'none' : 'block';
            });
        }

        // Click to navigate
        slides.forEach((slide, i) => {
            slide.addEventListener('click', function() {
                const offset = i - current;
                const normalizedOffset = offset > total / 2 ? offset - total :
                    offset < -total / 2 ? offset + total :
                    offset;
                if (normalizedOffset === 0) {
                    // Navigate to region page
                    const url = slide.dataset.url;
                    if (url && url !== '#') window.location.href = url;
                } else {
                    current = i;
                    render();
                }
            });
        });

        document.getElementById('rsPrev').addEventListener('click', function() {
            current = (current - 1 + total) % total;
            render();
        });

        document.getElementById('rsNext').addEventListener('click', function() {
            current = (current + 1) % total;
            render();
        });

        render();
        window.addEventListener('resize', render);
    })();

    // ============================================
    // 3. NEW NAVIGATION — Drawer + Dropdown
    // ============================================
    var hamburger = document.getElementById('navHamburger');
    var drawer = document.getElementById('navDrawer');
    var overlay = document.getElementById('navOverlay');
    var closeBtn = document.getElementById('navDrawerClose');
    var header = document.getElementById('siteHeader');

    function openDrawer() {
        if (!drawer) return;
        drawer.classList.add('is-open');
        if (overlay) overlay.classList.add('is-open');
        if (hamburger) hamburger.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    }

    function closeDrawer() {
        if (!drawer) return;
        drawer.classList.remove('is-open');
        if (overlay) overlay.classList.remove('is-open');
        if (hamburger) hamburger.classList.remove('is-open');
        document.body.style.overflow = '';
    }
    if (hamburger) {
        hamburger.addEventListener('click', function() {
            if (drawer.classList.contains('is-open')) {
                closeDrawer();
            } else {
                openDrawer();
                setTimeout(initMobileAccordion, 150);
            }
        });
    }

    if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
    if (overlay) overlay.addEventListener('click', closeDrawer);

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDrawer();
    });

    // ============================================
    // MOBILE SUBMENU ACCORDION
    // ============================================
    var accordionReady = false;

    function initMobileAccordion() {
        if (accordionReady) return; // Only run once
        accordionReady = true;

        var allParents = document.querySelectorAll('#navDrawer .menu-item-has-children');

        allParents.forEach(function(parent) {
            var link = parent.querySelector(':scope > a');
            if (!link) return;

            // Add arrow only if not already added
            if (!link.querySelector('.mob-arrow')) {
                var arrow = document.createElement('span');
                arrow.className = 'mob-arrow';
                arrow.textContent = '›';
                arrow.style.cssText = 'margin-left:auto;transition:transform 0.3s;display:inline-block;color:#c99b2d;font-size:18px;padding-left:8px;flex-shrink:0;';
                link.style.display = 'flex';
                link.style.justifyContent = 'space-between';
                link.style.alignItems = 'center';
                link.appendChild(arrow);
            }

            link.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                var submenu = parent.querySelector(':scope > .sub-menu');
                if (!submenu) return;

                var isOpen = parent.classList.contains('mob-open');

                // Close siblings at same level
                var siblings = parent.parentElement.querySelectorAll(':scope > .menu-item-has-children');
                siblings.forEach(function(sib) {
                    if (sib !== parent) {
                        sib.classList.remove('mob-open');
                        var sibSub = sib.querySelector(':scope > .sub-menu');
                        if (sibSub) sibSub.style.maxHeight = '0';
                        var sibArrow = sib.querySelector(':scope > a .mob-arrow');
                        if (sibArrow) sibArrow.style.transform = 'rotate(0deg)';
                    }
                });

                // Toggle current
                if (isOpen) {
                    parent.classList.remove('mob-open');
                    submenu.style.maxHeight = '0';
                    link.querySelector('.mob-arrow').style.transform = 'rotate(0deg)';
                } else {
                    parent.classList.add('mob-open');
                    submenu.style.maxHeight = submenu.scrollHeight + 500 + 'px';
                    link.querySelector('.mob-arrow').style.transform = 'rotate(90deg)';
                }
            });
        });
    }

    // Single hamburger click handler
    // Also run on load in case drawer is already open
    initMobileAccordion();
    // ============================================
    // TABLE OF CONTENTS — Auto-build from headings
    // ============================================
    var postContent = document.getElementById('postContent');
    var tocNav = document.getElementById('postTocNav');
    var tocNavMobile = document.getElementById('postTocNavMobile');
    var tocMobile = document.getElementById('postTocMobile');
    var tocToggle = document.getElementById('postTocToggle');

    if (postContent && tocNav) {
        var headings = postContent.querySelectorAll('h2, h3');

        if (headings.length > 0) {

            // Build TOC links
            headings.forEach(function(heading, i) {
                // Add ID to heading if missing
                if (!heading.id) {
                    heading.id = 'toc-' + i + '-' + heading.textContent
                        .toLowerCase()
                        .replace(/[^a-z0-9]+/g, '-')
                        .replace(/^-|-$/g, '');
                }

                var link = document.createElement('a');
                link.href = '#' + heading.id;
                link.textContent = heading.textContent;
                link.className = heading.tagName === 'H3' ? 'toc-h3' : '';

                // Smooth scroll
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    var target = document.getElementById(this.getAttribute('href').slice(1));
                    if (target) {
                        var offset = 100;
                        var top = target.getBoundingClientRect().top + window.scrollY - offset;
                        window.scrollTo({ top: top, behavior: 'smooth' });
                    }
                });

                tocNav.appendChild(link);

                // Also add to mobile TOC
                if (tocNavMobile) {
                    var linkMobile = link.cloneNode(true);
                    linkMobile.addEventListener('click', function(e) {
                        e.preventDefault();
                        var target = document.getElementById(this.getAttribute('href').slice(1));
                        if (target) {
                            var offset = 100;
                            var top = target.getBoundingClientRect().top + window.scrollY - offset;
                            window.scrollTo({ top: top, behavior: 'smooth' });
                            // Close mobile TOC after clicking
                            if (tocMobile) tocMobile.classList.remove('is-open');
                        }
                    });
                    tocNavMobile.appendChild(linkMobile);
                }
            });

            // Active state on scroll
            var tocLinks = tocNav.querySelectorAll('a');
            window.addEventListener('scroll', function() {
                var scrollY = window.scrollY + 120;
                var current = '';

                headings.forEach(function(heading) {
                    if (heading.offsetTop <= scrollY) {
                        current = heading.id;
                    }
                });

                tocLinks.forEach(function(link) {
                    link.classList.toggle(
                        'is-active',
                        link.getAttribute('href') === '#' + current
                    );
                });
            }, { passive: true });

        } else {
            // No headings — hide TOC
            var tocSidebar = document.getElementById('postTocSidebar');
            var tocMobileEl = document.getElementById('postTocMobile');
            if (tocSidebar) tocSidebar.style.display = 'none';
            if (tocMobileEl) tocMobileEl.style.display = 'none';
        }
    }

    // Mobile TOC toggle
    if (tocToggle && tocMobile) {
        tocToggle.addEventListener('click', function() {
            tocMobile.classList.toggle('is-open');
        });
    }
    // Scrolled header shadow
    // ============================================
    // GLASS PILL HOVER HEADER
    // ============================================
    var pillWrap = document.getElementById('headerPillWrap');
    var glassPill = document.getElementById('headerGlassPill');

    if (pillWrap && header) {
        // Show header on pill hover
        glassPill.addEventListener('mouseenter', function() {
            header.classList.add('is-revealed');
            pillWrap.classList.add('is-hidden');
        });

        // Hide header when mouse leaves header
        header.addEventListener('mouseleave', function() {
            header.classList.remove('is-revealed');
            pillWrap.classList.remove('is-hidden');
        });

        // Keep header visible when mouse moves from pill to header
        header.addEventListener('mouseenter', function() {
            header.classList.add('is-revealed');
            pillWrap.classList.add('is-hidden');
        });
    }

    // Scrolled header shadow
    (function() {
        if (!document.getElementById('pmtBody')) return;

        const totalSteps = 6;
        let currentStep = 0;
        const selections = {};

        const steps = document.querySelectorAll('.pmt-step');
        const progSteps = document.querySelectorAll('.pmt-prog-step');
        const progLines = document.querySelectorAll('.pmt-prog-line');
        const btnBack = document.getElementById('pmtBack');
        const btnNext = document.getElementById('pmtNext');
        const counter = document.getElementById('pmtCounter');

        // Option card clicks
        document.querySelectorAll('.pmt-opt').forEach(function(opt) {
            opt.addEventListener('click', function() {
                const field = this.dataset.field;
                document.querySelectorAll('.pmt-opt[data-field="' + field + '"]').forEach(function(o) {
                    o.classList.remove('selected');
                });
                this.classList.add('selected');
                if (field === 'region') {
                    selections.region = this.dataset.value;
                } else if (field === 'duration') {
                    selections.durationMin = parseInt(this.dataset.min);
                    selections.durationMax = parseInt(this.dataset.max);
                    selections.durationLabel = this.querySelector('.pmt-opt-name').textContent;
                } else if (field === 'difficulty') {
                    selections.difficulty = this.dataset.value;
                }
            });
        });

        // Range sliders
        var groupRange = document.getElementById('groupRange');
        var budgetRange = document.getElementById('budgetRange');

        if (groupRange) {
            groupRange.addEventListener('input', function() {
                document.getElementById('groupVal').textContent = this.value;
                selections.groupSize = parseInt(this.value);
            });
            selections.groupSize = parseInt(groupRange.value);
        }

        if (budgetRange) {
            budgetRange.addEventListener('input', function() {
                document.getElementById('budgetVal').textContent = parseInt(this.value).toLocaleString();
                selections.budget = parseInt(this.value);
            });
            selections.budget = parseInt(budgetRange.value);
        }

        function updateProgress() {
            progSteps.forEach(function(s, i) {
                s.classList.remove('active', 'done');
                if (i < currentStep) s.classList.add('done');
                else if (i === currentStep) s.classList.add('active');

                // Update number to checkmark when done
                var num = s.querySelector('.pmt-prog-num');
                if (i < currentStep) {
                    num.innerHTML = '✓';
                } else {
                    num.textContent = i + 1;
                }
            });
            progLines.forEach(function(l, i) {
                l.classList.toggle('done', i < currentStep);
            });
            counter.textContent = 'Step ' + (currentStep + 1) + ' of ' + totalSteps;
            btnBack.disabled = currentStep === 0;
            btnNext.textContent = currentStep === totalSteps - 1 ? 'Send Inquiry →' : 'Continue →';
        }

        function showStep(n) {
            steps.forEach(function(s) { s.classList.add('hidden'); });
            steps[n].classList.remove('hidden');
            currentStep = n;
            updateProgress();

            if (n === totalSteps - 1) {
                renderResults();
                renderSummary();
            }

            // Scroll to top of container
            var container = document.querySelector('.pmt-container');
            if (container) {
                container.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }

        function getMatchScore(trip) {
            var score = 0;

            // Region match
            if (selections.region && selections.region !== 'any') {
                if (trip.region && trip.region.toLowerCase().includes(selections.region.toLowerCase())) {
                    score += 40;
                }
            } else {
                score += 20;
            }

            // Duration match
            if (selections.durationMin && trip.days) {
                if (trip.days >= selections.durationMin && trip.days <= selections.durationMax) {
                    score += 30;
                } else if (trip.days >= selections.durationMin - 2 && trip.days <= selections.durationMax + 2) {
                    score += 15;
                }
            } else {
                score += 15;
            }

            // Difficulty match
            if (selections.difficulty && trip.difficulty) {
                if (trip.difficulty === selections.difficulty) {
                    score += 20;
                } else {
                    score += 5;
                }
            } else {
                score += 10;
            }

            // Budget match
            if (selections.budget && trip.price_num) {
                if (trip.price_num <= selections.budget) {
                    score += 10;
                } else if (trip.price_num <= selections.budget * 1.2) {
                    score += 5;
                }
            } else {
                score += 5;
            }

            return Math.min(score, 98);
        }

        function renderResults() {
            var container = document.getElementById('pmtResults');
            if (!container || typeof pmtTrips === 'undefined') return;

            // Score and sort trips
            var scored = pmtTrips.map(function(t) {
                return { trip: t, score: getMatchScore(t) };
            });
            scored.sort(function(a, b) { return b.score - a.score; });
            var top = scored.slice(0, 4);

            if (top.length === 0) {
                container.innerHTML = '<div class="pmt-no-results"><p>No trips found matching your preferences.</p><p>Our team will help you find the perfect trek!</p></div>';
                return;
            }

            container.innerHTML = top.map(function(item) {
                var t = item.trip;
                var score = item.score;
                return '<div class="pmt-result-card" onclick="pmtSelectTrip(\'' + t.id + '\', \'' + encodeURIComponent(t.name) + '\', this)">' +
                    '<div class="pmt-result-thumb" style="background-image:url(\'' + t.thumb + '\')"></div>' +
                    '<div class="pmt-result-info">' +
                    '<span class="pmt-match-badge">' + score + '% match</span>' +
                    '<div class="pmt-result-name">' + t.name + '</div>' +
                    '<div class="pmt-result-meta">' + (t.duration || 'Duration TBA') + ' · ' + (t.difficulty || 'All levels') + '</div>' +
                    '<div class="pmt-result-price">' + (t.price || 'Contact us') + ' / person</div>' +
                    '</div>' +
                    '</div>';
            }).join('');
        }

        function renderSummary() {
            var wrap = document.getElementById('pmtSummary');
            if (!wrap) return;
            var pills = [];
            if (selections.region) pills.push(selections.region === 'any' ? 'Any region' : selections.region + ' Region');
            if (selections.durationLabel) pills.push(selections.durationLabel);
            if (selections.difficulty) pills.push(selections.difficulty + ' level');
            if (selections.groupSize) pills.push(selections.groupSize + ' people');
            if (selections.budget) pills.push('Budget: USD ' + selections.budget.toLocaleString());

            wrap.innerHTML = '<p style="font-size:12px;color:#6B6558;margin-bottom:8px;font-weight:600;">Your preferences:</p>' +
                pills.map(function(p) {
                    return '<span class="pmt-summary-pill">' + p + '</span>';
                }).join('');

            // Fill hidden inputs
            var selInput = document.getElementById('pmtSelections');
            if (selInput) selInput.value = JSON.stringify(selections);
        }

        // Trip selection
        window.pmtSelectTrip = function(id, name, el) {
            document.querySelectorAll('.pmt-result-card').forEach(function(c) {
                c.classList.remove('selected');
            });
            el.classList.add('selected');
            var input = document.getElementById('pmtMatchedTrip');
            if (input) input.value = decodeURIComponent(name) + ' (ID: ' + id + ')';
        };

        // Navigation
        btnNext.addEventListener('click', function() {
            if (currentStep < totalSteps - 1) {
                showStep(currentStep + 1);
            } else {
                // Submit form
                document.getElementById('pmtInquiryForm').submit();
            }
        });

        btnBack.addEventListener('click', function() {
            if (currentStep > 0) showStep(currentStep - 1);
        });

        // Init
        showStep(0);

    })();
});
// ============================================
// WHY CHOOSE US CARD SLIDER
// ============================================
const whyTrack = document.getElementById('whyCardsTrack');
const whyPrev = document.getElementById('whyPrev');
const whyNext = document.getElementById('whyNext');
const whyDotsWrap = document.getElementById('whyDots');

if (whyTrack && whyPrev && whyNext) {
    let whyCurrent = 0;
    const totalCards = whyTrack.children.length; // 6

    function getPerSlide() {
        if (window.innerWidth <= 768) return 1;
        if (window.innerWidth <= 1024) return 2;
        return 3;
    }

    function getTotalSlides() {
        return Math.ceil(totalCards / getPerSlide());
    }

    function buildDots() {
        whyDotsWrap.innerHTML = '';
        const total = getTotalSlides();
        for (let i = 0; i < total; i++) {
            const dot = document.createElement('button');
            dot.className = 'why-dot' + (i === 0 ? ' active' : '');
            dot.dataset.index = i;
            dot.addEventListener('click', () => {
                whyCurrent = i;
                updateWhySlider();
            });
            whyDotsWrap.appendChild(dot);
        }
    }

    function updateWhySlider() {
        const perSlide = getPerSlide();
        const cardWidthPct = 100 / perSlide;
        whyTrack.style.transform = `translateX(calc(-${whyCurrent * cardWidthPct * perSlide}% - ${whyCurrent * 12 * perSlide}px))`;
        whyPrev.disabled = whyCurrent === 0;
        whyNext.disabled = whyCurrent >= getTotalSlides() - 1;
        document.querySelectorAll('.why-dot').forEach((d, i) => d.classList.toggle('active', i === whyCurrent));
    }

    whyPrev.addEventListener('click', () => {
        whyCurrent = Math.max(0, whyCurrent - 1);
        updateWhySlider();
    });
    whyNext.addEventListener('click', () => {
        whyCurrent = Math.min(getTotalSlides() - 1, whyCurrent + 1);
        updateWhySlider();
    });

    // Rebuild dots on resize
    window.addEventListener('resize', () => {
        whyCurrent = 0;
        buildDots();
        updateWhySlider();
    });

    buildDots();
    updateWhySlider();
} // ============================================
// FEATURED TRIPS — Word Grid Background
// ============================================
(function() {
    const grid = document.querySelector('.ft-word-grid');
    if (!grid) return;

    const words = ['TREK', 'PEAK', 'HIKE', 'CAMP', 'SNOW', 'ALPS', 'TRAIL', 'BASE', 'RIDGE', 'CLIMB'];
    const W = grid.parentElement.offsetWidth;
    const H = grid.parentElement.offsetHeight;
    const colW = 72;
    const rowH = 32;
    const cols = Math.ceil(W / colW) + 2;
    const rows = Math.ceil(H / rowH) + 2;

    let idx = 0;
    for (let row = 0; row < rows; row++) {
        for (let col = 0; col < cols; col++) {
            const el = document.createElement('span');
            el.textContent = words[idx % words.length];
            const isGold = idx % 4 === 0;
            const size = 12;
            const stroke = isGold ?
                '0.5px rgba(201,155,45,0.25)' :
                '0.5px rgba(255,255,255,0.15)';

            el.style.cssText = `
                position: absolute;
                font-family: 'Arial Black', Impact, sans-serif;
                font-weight: 900;
                font-size: ${size}px;
                text-transform: uppercase;
                letter-spacing: 1px;
                white-space: nowrap;
                line-height: 1;
                left: ${col * colW}px;
                top: ${row * rowH}px;
                color: transparent;
                -webkit-text-stroke: ${stroke};
                user-select: none;
            `;
            grid.appendChild(el);
            idx++;
        }
    }
})();