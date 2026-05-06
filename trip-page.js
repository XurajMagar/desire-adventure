document.addEventListener('DOMContentLoaded', function() {

    // ============================================
    // 1. HERO SLIDESHOW
    // ============================================
    const slides = document.querySelectorAll('.tp-slide');
    const thumbs = document.querySelectorAll('.tp-thumb');
    const dotsWrap = document.getElementById('tpSlideDots');

    if (slides.length > 1 && dotsWrap) {
        let current = 0;
        let timer;

        // Build dots
        slides.forEach(function(_, i) {
            const dot = document.createElement('button');
            dot.className = 'tp-dot' + (i === 0 ? ' active' : '');
            dot.setAttribute('aria-label', 'Go to slide ' + (i + 1));
            dot.addEventListener('click', function() { goTo(i); });
            dotsWrap.appendChild(dot);
        });

        function goTo(n) {
            slides[current].classList.remove('active');
            if (thumbs[current]) thumbs[current].classList.remove('active');
            dotsWrap.children[current].classList.remove('active');

            current = n;

            slides[current].classList.add('active');
            if (thumbs[current]) thumbs[current].classList.add('active');
            dotsWrap.children[current].classList.add('active');

            clearInterval(timer);
            timer = setInterval(function() {
                goTo((current + 1) % slides.length);
            }, 5000);
        }

        // Thumbnail clicks
        thumbs.forEach(function(thumb) {
            thumb.addEventListener('click', function() {
                goTo(parseInt(this.dataset.slide));
            });
        });

        // Start autoplay
        timer = setInterval(function() {
            goTo((current + 1) % slides.length);
        }, 5000);
    }

    // ============================================
    // 2. STICKY SUBNAV ACTIVE STATE
    // ============================================
    const tpSections = document.querySelectorAll('.tp-section');
    const tpNavLinks = document.querySelectorAll('.tp-subnav-link');
    if (tpSections.length && tpNavLinks.length) {
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    tpNavLinks.forEach(function(l) {
                        l.classList.remove('active');
                    });
                    const link = document.querySelector(
                        '.tp-subnav-link[href="#' + entry.target.id + '"]'
                    );
                    if (link) link.classList.add('active');
                }
            });
        }, {
            // Trigger when section top is within 15% from top of viewport
            // This accounts for the sticky subnav height
            rootMargin: '-55px 0px -60% 0px'
        });

        tpSections.forEach(function(section) {
            observer.observe(section);
        });
    }

    // ============================================
    // 3. MOBILE BAR — Hide when sidebar in view
    // ============================================
    const mobileBar = document.querySelector('.tp-mobile-bar');
    const sidebar = document.querySelector('.tp-sidebar');

    if (mobileBar && sidebar && window.innerWidth <= 1024) {
        const sidebarObserver = new IntersectionObserver(function(entries) {
            mobileBar.style.display = entries[0].isIntersecting ? 'none' : 'flex';
        }, { threshold: 0.1 });
        sidebarObserver.observe(sidebar);
    }

    // ============================================
    // 4. LIGHTBOX
    // ============================================
    const lb = document.getElementById('tp-lightbox');
    const lbImg = document.getElementById('tp-lightbox-img');
    const lbClose = document.getElementById('tp-lightbox-close');

    window.openTripLightbox = function(src) {
        if (!lb || !lbImg) return;
        lbImg.src = src;
        lb.showModal();
        if (lbClose) lbClose.style.display = 'flex';
    };

    if (lb) {
        lb.addEventListener('click', function(e) {
            if (e.target === lb) {
                lb.close();
                if (lbClose) lbClose.style.display = 'none';
            }
        });
    }

    // ============================================
    // 5. ENQUIRY FORM — Basic validation feedback
    // ============================================
    const form = document.querySelector('.tp-enquiry-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const btn = form.querySelector('.tp-btn-submit');
            if (btn) {
                btn.textContent = 'Sending...';
                btn.disabled = true;
            }
        });
    }

});

const tpAccItems = document.querySelectorAll('.tp-acc-item');
if (tpAccItems.length) {
    tpAccItems.forEach(function(item) {
        const trigger = item.querySelector('.tp-acc-trigger');
        if (!trigger) return;

        trigger.addEventListener('click', function() {
            const isOpen = item.classList.contains('open');

            // Close all
            tpAccItems.forEach(function(i) {
                i.classList.remove('open');
                const icon = i.querySelector('.tp-acc-icon');
                if (icon) icon.textContent = '+';
                const btn = i.querySelector('.tp-acc-trigger');
                if (btn) btn.setAttribute('aria-expanded', 'false');
            });

            // Open clicked one if it was closed
            if (!isOpen) {
                item.classList.add('open');
                const icon = item.querySelector('.tp-acc-icon');
                if (icon) icon.textContent = '×';
                trigger.setAttribute('aria-expanded', 'true');
            }
        });
    });
}
// ============================================
// ALTITUDE CHART
// ============================================
if (typeof tpAltitudeData !== 'undefined' && tpAltitudeData.length >= 2) {
    var canvas = document.getElementById('tpAltitudeChart');
    if (canvas) {
        function drawAltitudeChart() {
            var ctx = canvas.getContext('2d');
            var dpr = window.devicePixelRatio || 1;

            var W = canvas.parentElement.clientWidth - 32;
            var H = 260;
            // Only draw if we have a real width
            if (W <= 0) return;
            canvas.width = W * dpr;
            canvas.height = H * dpr;
            // Set CSS display size
            canvas.style.width = W + 'px';
            canvas.style.height = H + 'px';
            // Scale context for retina — all drawing coordinates stay the same
            ctx.scale(dpr, dpr);
            var data = tpAltitudeData; // ← ADD THIS LINE first
            var altitudes = data.map(function(d) { return d.altitude; });

            var padL = 56,
                padR = 20,
                padT = 20,
                padB = 48;
            var chartW = W - padL - padR;
            var chartH = H - padT - padB;

            var minAlt = Math.min.apply(null, altitudes);
            var maxAlt = Math.max.apply(null, altitudes);
            var range = maxAlt - minAlt || 1;

            // Add 10% padding to range
            minAlt = Math.max(0, minAlt - range * 0.1);
            maxAlt = maxAlt + range * 0.1;
            range = maxAlt - minAlt;

            function xPos(i) {
                return padL + (i / (data.length - 1)) * chartW;
            }

            function yPos(alt) {
                return padT + chartH - ((alt - minAlt) / range) * chartH;
            }

            // Draw grid lines
            ctx.strokeStyle = '#f0ede8';
            ctx.lineWidth = 1;
            for (var g = 0; g <= 4; g++) {
                var gy = padT + (g / 4) * chartH;
                ctx.beginPath();
                ctx.moveTo(padL, gy);
                ctx.lineTo(padL + chartW, gy);
                ctx.stroke();

                // Altitude labels on left
                var altLabel = Math.round(maxAlt - (g / 4) * range);
                ctx.fillStyle = '#aaa';
                ctx.font = '11px DM Sans, sans-serif';
                ctx.textAlign = 'right';
                ctx.fillText(altLabel + 'm', padL - 6, gy + 4);
            }

            // Draw gradient fill
            var gradient = ctx.createLinearGradient(0, padT, 0, padT + chartH);
            gradient.addColorStop(0, 'rgba(44, 74, 53, 0.3)');
            gradient.addColorStop(1, 'rgba(44, 74, 53, 0.02)');

            ctx.beginPath();
            ctx.moveTo(xPos(0), yPos(data[0].altitude));
            for (var i = 1; i < data.length; i++) {
                // Smooth curve using bezier
                var x0 = xPos(i - 1),
                    y0 = yPos(data[i - 1].altitude);
                var x1 = xPos(i),
                    y1 = yPos(data[i].altitude);
                var cpx = (x0 + x1) / 2;
                ctx.bezierCurveTo(cpx, y0, cpx, y1, x1, y1);
            }
            ctx.lineTo(xPos(data.length - 1), padT + chartH);
            ctx.lineTo(xPos(0), padT + chartH);
            ctx.closePath();
            ctx.fillStyle = gradient;
            ctx.fill();

            // Draw line
            ctx.beginPath();
            ctx.moveTo(xPos(0), yPos(data[0].altitude));
            for (var j = 1; j < data.length; j++) {
                var ax = xPos(j - 1),
                    ay = yPos(data[j - 1].altitude);
                var bx = xPos(j),
                    by = yPos(data[j].altitude);
                var cp = (ax + bx) / 2;
                ctx.bezierCurveTo(cp, ay, cp, by, bx, by);
            }
            ctx.strokeStyle = '#2D4A35';
            ctx.lineWidth = 2.5;
            ctx.stroke();

            // Draw dots + day labels
            data.forEach(function(point, i) {
                var px = xPos(i);
                var py = yPos(point.altitude);

                // Dot
                ctx.beginPath();
                ctx.arc(px, py, 5, 0, Math.PI * 2);
                ctx.fillStyle = '#C17F3A';
                ctx.strokeStyle = '#fff';
                ctx.lineWidth = 2;
                ctx.fill();
                ctx.stroke();

                // Day label below x-axis
                ctx.fillStyle = '#888';
                ctx.font = '10px DM Sans, sans-serif';
                ctx.textAlign = 'center';
                ctx.fillText('D' + point.day, px, H - padB + 16);
            });

            // Tooltip on hover
            var tooltip = null;
            // Reuse existing tooltip or create new one
            var tooltipEl = canvas.parentElement.querySelector('.tp-chart-tooltip');
            if (!tooltipEl) {
                tooltipEl = document.createElement('div');
                tooltipEl.className = 'tp-chart-tooltip';
                tooltipEl.style.cssText = 'position:absolute;background:#1A2E20;color:#fff;padding:8px 12px;border-radius:6px;font-size:12px;pointer-events:none;opacity:0;transition:opacity 0.2s;z-index:10;max-width:180px;line-height:1.5';
                canvas.parentElement.style.position = 'relative';
                canvas.parentElement.appendChild(tooltipEl);
            }

            canvas.addEventListener('mousemove', function(e) {
                var rect = canvas.getBoundingClientRect();
                var mouseX = e.clientX - rect.left;
                var closest = null;
                var minDist = Infinity;

                data.forEach(function(point, i) {
                    var dist = Math.abs(mouseX - xPos(i));
                    if (dist < minDist) {
                        minDist = dist;
                        closest = { point: point, i: i };
                    }
                });

                if (closest && minDist < 30) {
                    // Strip any leading "Day X:" or "Day X -" prefix from title since we show it separately
                    var cleanTitle = closest.point.title
                        .replace(/^Day\s*\d+[\s:\-–]+/i, '')
                        .substring(0, 50);

                    tooltipEl.innerHTML = '<strong style="color:#C17F3A">Day ' + closest.point.day + '</strong><br>' +
                        '<span style="font-size:11px;opacity:0.85">' + cleanTitle + '</span><br>' +
                        '<span style="color:#C17F3A;font-weight:700">' + closest.point.altitude + 'm</span>';
                    tooltipEl.style.opacity = '1';

                    var tooltipW = tooltipEl.offsetWidth || 160;
                    var tooltipH = tooltipEl.offsetHeight || 70;

                    // Calculate ideal position centered above the dot
                    var tx = xPos(closest.i) - tooltipW / 2;
                    var ty = yPos(closest.point.altitude) - tooltipH - 12;

                    // Clamp left — never go past left edge
                    tx = Math.max(4, tx);

                    // Clamp right — never go past right edge of canvas
                    tx = Math.min(W - tooltipW - 4, tx);

                    // Clamp top — if tooltip goes above chart, show it below the dot instead
                    if (ty < 4) {
                        ty = yPos(closest.point.altitude) + 16;
                    }

                    tooltipEl.style.left = tx + 'px';
                    tooltipEl.style.top = ty + 'px';
                } else {
                    tooltipEl.style.opacity = '0';
                }
            });

            canvas.addEventListener('mouseleave', function() {
                tooltipEl.style.opacity = '0';
            });
        } // end drawAltitudeChart function

        // Draw immediately
        drawAltitudeChart();

        // Redraw if window resizes — fixes blurry on orientation change
        var resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(drawAltitudeChart, 150);
        });

        // Safety net — redraw after 300ms in case layout shifted
        setTimeout(drawAltitudeChart, 300);
    }
}