document.addEventListener('DOMContentLoaded', function() {

    if (!document.querySelector('.tp-booking-card')) return;

    // ============================================
    // SHARED STATE
    // ============================================
    var state = {
        bookNowDate: null,
        bookNowPax: 2,
        joinDepStart: null,
        joinDepEnd: null,
        joinDepPrice: null,
        joinDepPax: 2,
    };

    var tripData = window.tpTripData || {};
    var departures = tripData.departures || [];
    var bookingPage = tripData.bookingPage || '/booking/';

    // ============================================
    // 1. POPUP SYSTEM
    // ============================================
    function openPopup(id) {
        var overlay = document.getElementById(id);
        if (!overlay) return;
        overlay.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    }

    function closePopup(id) {
        var overlay = document.getElementById(id);
        if (!overlay) return;
        overlay.classList.remove('is-open');
        document.body.style.overflow = '';
    }

    // Close buttons
    document.querySelectorAll('.tp-popup-close').forEach(function(btn) {
        btn.addEventListener('click', function() {
            closePopup(this.dataset.popup);
        });
    });

    // Close on backdrop click
    document.querySelectorAll('.tp-popup-overlay').forEach(function(overlay) {
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) closePopup(overlay.id);
        });
    });

    // Close on Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.tp-popup-overlay.is-open').forEach(function(o) {
                closePopup(o.id);
            });
        }
    });

    // ============================================
    // 2. SIDEBAR BUTTONS
    // ============================================
    var btnBookNow = document.getElementById('btnBookNow');
    var btnJoinDep = document.getElementById('btnJoinDep');
    var btnEnquiry = document.getElementById('btnEnquiry');

    if (btnBookNow) {
        btnBookNow.addEventListener('click', function() {
            buildCalendar('calBookNow', 'bookNow');
            openPopup('popupBookNow');
        });
    }

    if (btnJoinDep) {
        btnJoinDep.addEventListener('click', function() {
            // Scroll to departures section smoothly
            var depSection = document.getElementById('tp-departures');
            if (depSection) {
                var subnav = document.querySelector('.tp-subnav-wrap');
                var offset = subnav ? subnav.offsetHeight + 20 : 60;
                var top = depSection.getBoundingClientRect().top + window.pageYOffset - offset;
                window.scrollTo({ top: top, behavior: 'smooth' });
            }
        });
    }

    if (btnEnquiry) {
        btnEnquiry.addEventListener('click', function() {
            openPopup('popupEnquiry');
        });
    }

    // ============================================
    // 3. DEPARTURE TABLE — Join buttons
    // ============================================
    document.querySelectorAll('.tp-btn-join-dep').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var start = this.dataset.start;
            var end = this.dataset.end;
            var startFmt = this.dataset.startFmt;
            var endFmt = this.dataset.endFmt;
            var price = this.dataset.price;

            state.joinDepStart = start;
            state.joinDepEnd = end;
            state.joinDepPrice = price;

            // Update popup content
            var titleEl = document.getElementById('depConfirmTitle');
            var priceEl = document.getElementById('depPriceBadge');
            var priceTitleEl = document.getElementById('depPriceTitle');

            if (titleEl) {
                titleEl.textContent = startFmt + (endFmt ? ' – ' + endFmt : '');
            }

            if (priceEl && priceTitleEl && price) {
                priceTitleEl.textContent = price + ' per person';
                priceEl.style.display = 'flex';
            } else if (priceEl) {
                priceEl.style.display = 'none';
            }

            // Reset checkbox
            var cb = document.getElementById('joinDepConfirm');
            if (cb) cb.checked = false;

            // Reset pax
            state.joinDepPax = 2;
            var paxEl = document.getElementById('paxJoinDep');
            if (paxEl) paxEl.textContent = '2';

            openPopup('popupJoinDep');
        });
    });

    // ============================================
    // 4. PAX SELECTOR
    // ============================================
    document.querySelectorAll('.tp-pax-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var action = this.dataset.action;
            var target = this.dataset.target;
            var el = document.getElementById(target);
            if (!el) return;

            var current = parseInt(el.textContent) || 1;

            if (action === 'minus') current = Math.max(1, current - 1);
            if (action === 'plus') current = Math.min(10, current + 1);

            el.textContent = current;

            if (target === 'paxBookNow') state.bookNowPax = current;
            if (target === 'paxJoinDep') state.joinDepPax = current;
        });
    });

    // ============================================
    // 5. CONTINUE BUTTONS
    // ============================================
    var btnContinueBook = document.getElementById('btnContinueBook');
    var btnContinueJoin = document.getElementById('btnContinueJoin');

    if (btnContinueBook) {
        btnContinueBook.addEventListener('click', function() {
            if (!state.bookNowDate) {
                alert('Please select a departure date first.');
                return;
            }
            var params = new URLSearchParams({
                trip_id: tripData.tripId || '',
                trip: tripData.tripName || '',
                date: state.bookNowDate,
                pax: state.bookNowPax,
                type: 'custom'
            });
            window.location.href = bookingPage + '?' + params.toString();
        });
    }

    if (btnContinueJoin) {
        btnContinueJoin.addEventListener('click', function() {
            var cb = document.getElementById('joinDepConfirm');
            if (!cb || !cb.checked) {
                alert('Please confirm you want to join this departure.');
                return;
            }
            var params = new URLSearchParams({
                trip_id: tripData.tripId || '',
                trip: tripData.tripName || '',
                date: state.joinDepStart || '',
                end: state.joinDepEnd || '',
                pax: state.joinDepPax,
                type: 'departure'
            });
            window.location.href = bookingPage + '?' + params.toString();
        });
    }

    // ============================================
    // 6. CALENDAR
    // ============================================
    var calState = {
        year: new Date().getFullYear(),
        month: new Date().getMonth(),
    };

    function buildCalendar(containerId, mode) {
        var container = document.getElementById(containerId);
        if (!container) return;

        var year = calState.year;
        var month = calState.month;
        var today = new Date();
        today.setHours(0, 0, 0, 0);

        var monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
        var dayNames = ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'];

        var firstDay = new Date(year, month, 1).getDay();
        var daysInMonth = new Date(year, month + 1, 0).getDate();

        // Build header
        var html = '<div class="tp-cal">';
        html += '<div class="tp-cal-header">';
        html += '<button class="tp-cal-nav" id="calPrev">‹</button>';
        html += '<span class="tp-cal-month">' + monthNames[month] + ' ' + year + '</span>';
        html += '<button class="tp-cal-nav" id="calNext">›</button>';
        html += '</div>';

        // Day names
        html += '<div class="tp-cal-grid">';
        dayNames.forEach(function(d) {
            html += '<div class="tp-cal-dn">' + d + '</div>';
        });

        // Empty cells before first day
        for (var e = 0; e < firstDay; e++) {
            html += '<div class="tp-cal-cell tp-cal-empty"></div>';
        }

        // Day cells
        for (var day = 1; day <= daysInMonth; day++) {
            var date = new Date(year, month, day);
            var dateStr = year + '-' + String(month + 1).padStart(2, '0') + '-' + String(day).padStart(2, '0');
            var isPast = date < today;
            var isDep = departures.indexOf(dateStr) !== -1;
            var isSel = state.bookNowDate === dateStr;

            var classes = 'tp-cal-cell';
            if (isPast) classes += ' tp-cal-past';
            if (isDep) classes += ' tp-cal-dep';
            if (isSel) classes += ' tp-cal-sel';

            html += '<div class="' + classes + '"' +
                (!isPast ? ' data-date="' + dateStr + '"' : '') + '>' +
                day +
                (isDep ? '<span class="tp-cal-dot"></span>' : '') +
                '</div>';
        }

        html += '</div></div>';
        container.innerHTML = html;

        // Navigation
        var prevBtn = container.querySelector('#calPrev');
        var nextBtn = container.querySelector('#calNext');

        if (prevBtn) {
            prevBtn.addEventListener('click', function() {
                calState.month--;
                if (calState.month < 0) {
                    calState.month = 11;
                    calState.year--;
                }
                buildCalendar(containerId, mode);
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', function() {
                calState.month++;
                if (calState.month > 11) {
                    calState.month = 0;
                    calState.year++;
                }
                buildCalendar(containerId, mode);
            });
        }

        // Date selection
        container.querySelectorAll('.tp-cal-cell:not(.tp-cal-empty):not(.tp-cal-past)').forEach(function(cell) {
            cell.addEventListener('click', function() {
                if (!this.dataset.date) return;
                state.bookNowDate = this.dataset.date;

                // Update button label
                var btn = document.getElementById('btnContinueBook');
                if (btn) {
                    var d = new Date(state.bookNowDate + 'T00:00:00');
                    var fmt = d.toLocaleDateString('en-US', { day: 'numeric', month: 'short', year: 'numeric' });
                    btn.textContent = 'Continue — ' + fmt + ' →';
                }

                buildCalendar(containerId, mode); // Re-render with selection
            });
        });
    }
    // ============================================
    // TRIP REVIEWS SLIDER
    // ============================================
    var reviewSlides = document.querySelectorAll('.tp-review-slide');
    var reviewDots = document.querySelectorAll('.tp-reviews-dot');
    var reviewPrev = document.getElementById('tpReviewsPrev');
    var reviewNext = document.getElementById('tpReviewsNext');

    if (reviewSlides.length > 1) {
        var currentReview = 0;

        function goToReview(n) {
            reviewSlides[currentReview].classList.remove('is-active');
            if (reviewDots[currentReview]) reviewDots[currentReview].classList.remove('is-active');

            currentReview = (n + reviewSlides.length) % reviewSlides.length;

            reviewSlides[currentReview].classList.add('is-active');
            if (reviewDots[currentReview]) reviewDots[currentReview].classList.add('is-active');
        }

        if (reviewPrev) {
            reviewPrev.addEventListener('click', function() {
                goToReview(currentReview - 1);
            });
        }

        if (reviewNext) {
            reviewNext.addEventListener('click', function() {
                goToReview(currentReview + 1);
            });
        }

        reviewDots.forEach(function(dot) {
            dot.addEventListener('click', function() {
                goToReview(parseInt(this.dataset.index));
            });
        });

        // Auto advance every 6 seconds
        setInterval(function() {
            goToReview(currentReview + 1);
        }, 6000);
    }
    // ============================================
    // COPY LINK BUTTON
    // ============================================
    var copyBtn = document.getElementById('tpCopyLink');
    if (copyBtn) {
        copyBtn.addEventListener('click', function() {
            var url = this.dataset.url;
            var textEl = document.getElementById('tpCopyText');

            if (navigator.clipboard) {
                navigator.clipboard.writeText(url).then(function() {
                    textEl.textContent = 'Copied!';
                    copyBtn.classList.add('tp-share-copied');
                    setTimeout(function() {
                        textEl.textContent = 'Copy Link';
                        copyBtn.classList.remove('tp-share-copied');
                    }, 2000);
                });
            } else {
                // Fallback for older browsers
                var temp = document.createElement('input');
                temp.value = url;
                document.body.appendChild(temp);
                temp.select();
                document.execCommand('copy');
                document.body.removeChild(temp);
                textEl.textContent = 'Copied!';
                setTimeout(function() {
                    textEl.textContent = 'Copy Link';
                }, 2000);
            }
        });
    }
    // ============================================
    // PRINT ITINERARY
    // ============================================
    var printBtn = document.getElementById('tpPrintBtn');
    if (printBtn) {
        printBtn.addEventListener('click', function() {
            // Show template before printing
            var template = document.getElementById('tp-print-template');
            if (template) template.style.display = 'block';

            window.print();

            // Hide template after print dialog closes
            window.addEventListener('afterprint', function() {
                if (template) template.style.display = 'none';
            }, { once: true });
        });
    }

    // ============================================
    // DOWNLOAD ITINERARY
    // ============================================
    var downloadBtn = document.getElementById('tpDownloadBtn');
    if (downloadBtn) {
        downloadBtn.addEventListener('click', function() {
            var btn = this;
            var spanEl = btn.querySelector('span');
            var originalText = spanEl ? spanEl.textContent : 'Download';

            spanEl.textContent = 'Generating...';
            btn.disabled = true;

            var template = document.getElementById('tp-print-template');
            if (!template) {
                alert('Template not found. Please refresh and try again.');
                spanEl.textContent = originalText;
                btn.disabled = false;
                return;
            }

            // Show day photos
            document.querySelectorAll('.tp-pdf-only').forEach(function(el) {
                el.style.display = 'block';
            });

            // Get trip title
            var titleEl = document.querySelector('.tp-hero-title');
            var tripTitle = titleEl ? titleEl.textContent.trim() : 'Trek Itinerary';

            // Strip emojis FIRST before building docContent
            var rawContent = template.querySelector('.tp-print-doc').innerHTML;
            var printContent = rawContent
                .replace(/<img[^>]*class="[^"]*emoji[^"]*"[^>]*>/gi, '')
                .replace(/[^\x00-\x7F\u00C0-\u024F\u1E00-\u1EFF]/g, ' ')
                .replace(/\s{2,}/g, ' ');

            var fontUrl = 'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600&family=DM+Sans:wght@400;500;700&display=swap';

            // Build ONE clean docContent using stripped printContent
            var docContent = '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>' + tripTitle + ' Itinerary</title><link rel="stylesheet" href="' + fontUrl + '"><style>' +
                '* { margin:0; padding:0; box-sizing:border-box; }' +
                'body { font-family:"DM Sans",sans-serif; font-size:12pt; line-height:1.6; color:#1C1A17; background:#fff; }' +
                '.tp-print-doc { max-width:720px; margin:0 auto; padding:30px 40px; }' +
                '.tp-print-header { display:flex; justify-content:space-between; align-items:flex-start; padding-bottom:20px; border-bottom:3px solid #0f5a43; margin-bottom:24px; gap:20px; }' +
                '.tp-print-logo-text { font-family:"Cormorant Garamond",serif; font-size:22pt; font-weight:600; color:#0f5a43; text-transform:uppercase; letter-spacing:1px; }' +
                '.tp-print-logo img { max-height:55px; width:auto; }' +
                '.tp-print-title { font-family:"Cormorant Garamond",serif; font-size:22pt; font-weight:600; color:#0f5a43; margin-bottom:8px; line-height:1.2; }' +
                '.tp-print-meta-row { display:flex; flex-wrap:wrap; gap:12px; font-size:10pt; color:#555; }' +
                '.tp-print-price-block { background:#0f5a43; color:#fff; padding:12px 20px; border-radius:6px; margin-bottom:24px; display:flex; align-items:center; gap:10px; }' +
                '.tp-print-price-label { font-size:10pt; opacity:0.6; }' +
                '.tp-print-price-val { font-family:"Cormorant Garamond",serif; font-size:20pt; font-weight:600; color:#c99b2d; }' +
                '.tp-print-price-pp { font-size:10pt; opacity:0.6; }' +
                '.tp-print-discount { background:#e74c3c; color:#fff; font-size:9pt; font-weight:700; padding:2px 8px; border-radius:100px; }' +
                '.tp-print-section { margin-bottom:28px; }' +
                '.tp-print-section-title { font-family:"Cormorant Garamond",serif; font-size:16pt; font-weight:600; color:#0f5a43; padding-bottom:8px; border-bottom:2px solid #c99b2d; margin-bottom:16px; }' +
                '.tp-print-content { font-size:11pt; color:#333; line-height:1.7; }' +
                '.tp-print-content p { margin-bottom:10px; }' +
                '.tp-print-day { display:flex; gap:16px; margin-bottom:16px; padding-bottom:16px; border-bottom:1px solid #eee; page-break-inside:avoid; }' +
                '.tp-print-day-num { font-size:10pt; font-weight:700; text-transform:uppercase; color:#fff; background:#0f5a43; padding:4px 8px; border-radius:4px; white-space:nowrap; flex-shrink:0; height:fit-content; }' +
                '.tp-print-day-body { flex:1; }' +
                '.tp-print-day-title { font-size:12pt; font-weight:700; color:#1C1A17; margin-bottom:4px; }' +
                '.tp-print-day-chips { display:flex; gap:10px; margin-bottom:6px; }' +
                '.tp-print-day-chips span { font-size:9pt; color:#888; background:#f5f5f5; padding:2px 8px; border-radius:100px; }' +
                '.tp-print-day-desc { font-size:11pt; color:#555; line-height:1.6; }' +
                '.tp-print-day-photo { width:100%; max-height:220px; object-fit:cover; border-radius:6px; margin-top:10px; display:block; }' +
                '.tp-print-inc-grid { display:flex; gap:24px; }' +
                '.tp-print-inc-col { flex:1; }' +
                '.tp-print-inc-col h4 { font-size:11pt; font-weight:700; margin-bottom:8px; }' +
                '.tp-print-inc-col ul { padding-left:16px; }' +
                '.tp-print-inc-col li { font-size:10pt; color:#444; margin-bottom:4px; line-height:1.5; }' +
                '.tp-print-page-break { page-break-before:always; }' +
                '.tp-print-footer { margin-top:40px; padding-top:16px; border-top:1px solid #ddd; text-align:center; font-size:9pt; color:#888; }' +
                '@page { margin:15mm; size:A4 portrait; }' +
                'img.emoji, img.wp-smiley { display:none !important; width:0 !important; height:0 !important; }' +
                '.tp-acc-block-icon, .tp-pack-icon, .tp-highlights-icon { display:none !important; }' +
                'span:empty { display:none !important; }' +
                '@media print { body { background:#fff; } .tp-print-day { page-break-inside:avoid; } }' +
                '</style></head><body>' +
                '<div style="position:fixed;top:16px;right:16px;z-index:9999;display:flex;gap:8px;">' +
                '<button onclick="window.print()" style="background:#0f5a43;color:#fff;border:none;padding:10px 20px;border-radius:8px;font-family:DM Sans,sans-serif;font-size:13px;font-weight:700;cursor:pointer;">Save as PDF</button>' +
                '<button onclick="window.close()" style="background:#eee;color:#333;border:none;padding:10px 20px;border-radius:8px;font-family:DM Sans,sans-serif;font-size:13px;font-weight:700;cursor:pointer;">Close</button>' +
                '</div>' +
                '<div class="tp-print-doc">' + printContent + '</div>' +
                '</body></html>';

            // Open new window
            var printWin = window.open('', '_blank', 'width=900,height=700');

            if (!printWin) {
                alert('Pop-up blocked! Please allow pop-ups for this site and try again.');
                spanEl.textContent = originalText;
                btn.disabled = false;
                document.querySelectorAll('.tp-pdf-only').forEach(function(el) {
                    el.style.display = 'none';
                });
                return;
            }

            printWin.document.write(docContent);
            printWin.document.close();

            printWin.onload = function() {
                setTimeout(function() {
                    printWin.print();

                    // Reset button after print dialog opens
                    spanEl.textContent = originalText;
                    btn.disabled = false;
                    document.querySelectorAll('.tp-pdf-only').forEach(function(el) {
                        el.style.display = 'none';
                    });
                }, 1000);
            };

            // Fallback reset in case onload never fires
            setTimeout(function() {
                spanEl.textContent = originalText;
                btn.disabled = false;
                document.querySelectorAll('.tp-pdf-only').forEach(function(el) {
                    el.style.display = 'none';
                });
            }, 3000);
            // Extra safety — remove emoji images after write
            printWin.document.querySelectorAll('img').forEach(function(img) {
                if (img.src.indexOf('emoji') !== -1 || img.src.indexOf('twemoji') !== -1 || img.width < 30) {
                    img.parentNode.removeChild(img);
                }
            });
        });
    }
    // ============================================
    // 7. MOBILE FLOATER
    // ============================================
    var floater = document.getElementById('tpMobileFloater');
    var floaterPanel = document.getElementById('tpFloaterPanel');
    var floaterTrigger = document.getElementById('tpFloaterTrigger');

    if (floater && floaterPanel && floaterTrigger) {

        function openFloater() {
            floaterPanel.classList.add('is-open');
            floaterTrigger.classList.add('is-open');
            floaterTrigger.setAttribute('aria-expanded', 'true');
        }

        function closeFloater() {
            floaterPanel.classList.remove('is-open');
            floaterTrigger.classList.remove('is-open');
            floaterTrigger.setAttribute('aria-expanded', 'false');
        }

        floaterTrigger.addEventListener('click', function(e) {
            e.stopPropagation();
            floaterPanel.classList.contains('is-open') ? closeFloater() : openFloater();
        });

        document.addEventListener('click', function(e) {
            if (!floater.contains(e.target)) closeFloater();
        });

        // Wire mobile floater buttons to popups
        var mBtnBook = document.getElementById('mBtnBookNow');
        var mBtnJoin = document.getElementById('mBtnJoinDep');
        var mBtnEnq = document.getElementById('mBtnEnquiry');

        if (mBtnBook) {
            mBtnBook.addEventListener('click', function() {
                closeFloater();
                buildCalendar('calBookNow', 'bookNow');
                openPopup('popupBookNow');
            });
        }

        if (mBtnJoin) {
            mBtnJoin.addEventListener('click', function() {
                closeFloater();
                var depSection = document.getElementById('tp-departures');
                if (depSection) {
                    var offset = 60;
                    var top = depSection.getBoundingClientRect().top + window.pageYOffset - offset;
                    window.scrollTo({ top: top, behavior: 'smooth' });
                }
            });
        }

        if (mBtnEnq) {
            mBtnEnq.addEventListener('click', function() {
                closeFloater();
                openPopup('popupEnquiry');
            });
        }
    }

});