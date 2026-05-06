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
    // DOWNLOAD ITINERARY AS PDF
    // ============================================
    var downloadBtn = document.getElementById('tpDownloadBtn');
    if (downloadBtn) {
        downloadBtn.addEventListener('click', function() {
            var btn = this;
            var spanEl = btn.querySelector('span');
            var originalText = spanEl ? spanEl.textContent : 'Download';

            spanEl.textContent = 'Loading...';
            btn.disabled = true;

            // Remove any previously loaded html2pdf script to avoid conflicts
            var existingScript = document.querySelector('script[data-html2pdf]');
            if (existingScript) existingScript.remove();

            var script = document.createElement('script');
            script.setAttribute('data-html2pdf', 'true');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js';

            script.onload = function() {
                console.log('html2pdf loaded successfully');
                spanEl.textContent = 'Generating...';

                setTimeout(function() {
                    runPDF();
                }, 300);
            };

            script.onerror = function() {
                console.error('Failed to load html2pdf from CDN');
                // Try fallback CDN
                var fallback = document.createElement('script');
                fallback.src = 'https://unpkg.com/html2pdf.js@0.10.1/dist/html2pdf.bundle.min.js';
                fallback.onload = function() {
                    console.log('html2pdf loaded from fallback CDN');
                    spanEl.textContent = 'Generating...';
                    setTimeout(runPDF, 300);
                };
                fallback.onerror = function() {
                    alert('Could not load PDF library. Please check your internet connection and try again.');
                    spanEl.textContent = originalText;
                    btn.disabled = false;
                };
                document.head.appendChild(fallback);
            };

            document.head.appendChild(script);

            function runPDF() {
                var template = document.getElementById('tp-print-template');

                if (!template) {
                    console.error('tp-print-template element not found');
                    alert('Print template not found. Please refresh the page and try again.');
                    spanEl.textContent = originalText;
                    btn.disabled = false;
                    return;
                }

                // Show PDF-only elements (day photos)
                document.querySelectorAll('.tp-pdf-only').forEach(function(el) {
                    el.style.display = 'block';
                });

                // Make template visible for html2canvas to capture
                template.style.cssText = [
                    'display: block !important',
                    'position: fixed !important',
                    'top: 0 !important',
                    'left: 0 !important',
                    'width: 794px !important',
                    'min-height: 100px !important',
                    'background: #fff !important',
                    'z-index: -9999 !important',
                    'opacity: 0.01 !important',
                    'pointer-events: none !important'
                ].join(';');

                var element = template.querySelector('.tp-print-doc');

                if (!element) {
                    console.error('.tp-print-doc not found inside template');
                    template.style.cssText = 'display:none';
                    spanEl.textContent = originalText;
                    btn.disabled = false;
                    return;
                }

                console.log('Starting PDF generation...');
                console.log('Element dimensions:', element.offsetWidth, 'x', element.offsetHeight);

                // Get trip title for filename
                var titleEl = document.querySelector('.tp-hero-title') ||
                    document.querySelector('h1.tp-print-title') ||
                    document.querySelector('h1');
                var tripTitle = titleEl ? titleEl.textContent.trim() : 'Itinerary';
                var filename = tripTitle
                    .toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-|-$/g, '') +
                    '-itinerary.pdf';

                console.log('Filename:', filename);

                var opt = {
                    margin: [10, 10, 10, 10],
                    filename: filename,
                    image: { type: 'jpeg', quality: 0.85 },
                    html2canvas: {
                        scale: 1.5,
                        useCORS: true,
                        allowTaint: true,
                        logging: true,
                        width: 794,
                        windowWidth: 794
                    },
                    jsPDF: {
                        unit: 'mm',
                        format: 'a4',
                        orientation: 'portrait'
                    },
                    pagebreak: {
                        mode: ['css', 'legacy'],
                        before: '.tp-print-page-break'
                    }
                };

                html2pdf()
                    .set(opt)
                    .from(element)
                    .save()
                    .then(function() {
                        console.log('PDF generated successfully');
                        cleanup();
                    })
                    .catch(function(err) {
                        console.error('PDF generation failed:', err);
                        alert('PDF generation failed: ' + err.message + '\nPlease try again.');
                        cleanup();
                    });

                function cleanup() {
                    template.style.cssText = 'display: none !important';
                    document.querySelectorAll('.tp-pdf-only').forEach(function(el) {
                        el.style.display = 'none';
                    });
                    spanEl.textContent = originalText;
                    btn.disabled = false;
                }
            }
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