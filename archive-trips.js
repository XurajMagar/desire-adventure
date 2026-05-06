document.addEventListener('DOMContentLoaded', function() {

    // ============================================
    // STATE
    // ============================================
    var state = {
        region: '',
        difficulty: '',
        duration: '',
        sort: 'default'
    };

    var cards = Array.from(document.querySelectorAll('.arc-card'));
    var grid = document.getElementById('arcGrid');
    var countEl = document.getElementById('arcCount');
    var noResults = document.getElementById('arcNoResults');
    var activeWrap = document.getElementById('arcActiveFilters');
    var activeTags = document.getElementById('arcActiveTags');
    var clearAll = document.getElementById('arcClearAll');
    var clearBtn = document.getElementById('arcClearBtn');

    var filterLabels = {
        region: 'Region',
        difficulty: 'Difficulty',
        duration: 'Duration',
    };

    var durationLabels = {
        short: 'Under 7 Days',
        medium: '7 – 14 Days',
        long: '15+ Days',
    };

    // ============================================
    // DROPDOWN TOGGLE
    // ============================================
    document.querySelectorAll('.arc-filter-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            var filter = this.dataset.filter;
            var dropdown = document.querySelector('.arc-filter-dropdown[data-for="' + filter + '"]');
            var isOpen = dropdown.classList.contains('is-open');

            // Close all
            document.querySelectorAll('.arc-filter-dropdown').forEach(function(d) {
                d.classList.remove('is-open');
            });
            document.querySelectorAll('.arc-filter-btn').forEach(function(b) {
                b.classList.remove('is-active');
            });

            if (!isOpen) {
                dropdown.classList.add('is-open');
                this.classList.add('is-active');
            }
        });
    });

    // Close dropdowns on outside click
    document.addEventListener('click', function() {
        document.querySelectorAll('.arc-filter-dropdown').forEach(function(d) {
            d.classList.remove('is-open');
        });
        document.querySelectorAll('.arc-filter-btn').forEach(function(b) {
            b.classList.remove('is-active');
        });
    });

    // ============================================
    // FILTER SELECTION
    // ============================================
    document.querySelectorAll('.arc-dropdown-item').forEach(function(item) {
        item.addEventListener('click', function(e) {
            e.stopPropagation();
            var filter = this.dataset.filter;
            var value = this.dataset.value;

            // Update state
            state[filter] = value;

            // Update active class in dropdown
            var dropdown = this.closest('.arc-filter-dropdown');
            dropdown.querySelectorAll('.arc-dropdown-item').forEach(function(i) {
                i.classList.remove('is-active');
            });
            this.classList.add('is-active');

            // Update button label
            var btn = document.querySelector('.arc-filter-btn[data-filter="' + filter + '"]');
            var label = btn.querySelector('.arc-filter-label');
            if (value && filter !== 'sort') {
                var displayVal = filter === 'duration' ?
                    durationLabels[value] :
                    this.textContent.trim().replace(/\d+$/, '').trim();
                label.textContent = displayVal;
                btn.classList.add('has-value');
            } else {
                label.textContent = filter.charAt(0).toUpperCase() + filter.slice(1);
                if (filter === 'sort') label.textContent = 'Sort By';
                btn.classList.remove('has-value');
            }

            // Close dropdown
            dropdown.classList.remove('is-open');
            btn.classList.remove('is-active');

            applyFilters();
        });
    });

    // ============================================
    // APPLY FILTERS + SORT
    // ============================================
    function applyFilters() {
        var visible = [];

        cards.forEach(function(card) {
            var show = true;

            // Region filter
            if (state.region && card.dataset.region !== state.region) {
                show = false;
            }

            // Difficulty filter
            if (state.difficulty && card.dataset.difficulty !== state.difficulty) {
                show = false;
            }

            // Duration filter
            if (state.duration) {
                var dur = parseInt(card.dataset.durationNum) || 0;
                if (state.duration === 'short' && dur >= 7) show = false;
                if (state.duration === 'medium' && (dur < 7 || dur > 14)) show = false;
                if (state.duration === 'long' && dur < 15) show = false;
            }

            if (show) visible.push(card);

            // Show/hide with animation
            card.classList.toggle('arc-card-hidden', !show);
        });

        // Sort visible cards
        sortCards(visible);

        // Update count
        if (countEl) countEl.textContent = visible.length;

        // No results
        if (noResults) {
            noResults.style.display = visible.length === 0 ? 'flex' : 'none';
        }

        // Active filter tags
        updateActiveTags();
    }

    // ============================================
    // SORT
    // ============================================
    function sortCards(visibleCards) {
        if (!grid) return;

        var sorted = visibleCards.slice();

        switch (state.sort) {
            case 'price-asc':
                sorted.sort(function(a, b) {
                    return (parseFloat(a.dataset.priceNum) || 0) -
                        (parseFloat(b.dataset.priceNum) || 0);
                });
                break;
            case 'price-desc':
                sorted.sort(function(a, b) {
                    return (parseFloat(b.dataset.priceNum) || 0) -
                        (parseFloat(a.dataset.priceNum) || 0);
                });
                break;
            case 'duration-asc':
                sorted.sort(function(a, b) {
                    return (parseInt(a.dataset.durationNum) || 0) -
                        (parseInt(b.dataset.durationNum) || 0);
                });
                break;
            case 'duration-desc':
                sorted.sort(function(a, b) {
                    return (parseInt(b.dataset.durationNum) || 0) -
                        (parseInt(a.dataset.durationNum) || 0);
                });
                break;
        }

        // Re-append in sorted order
        sorted.forEach(function(card) {
            grid.appendChild(card);
        });
    }

    // ============================================
    // ACTIVE FILTER TAGS
    // ============================================
    function updateActiveTags() {
        if (!activeTags || !activeWrap) return;

        activeTags.innerHTML = '';
        var hasActive = false;

        Object.keys(filterLabels).forEach(function(key) {
            if (state[key]) {
                hasActive = true;
                var val = key === 'duration' ?
                    durationLabels[state[key]] :
                    state[key];
                var tag = document.createElement('span');
                tag.className = 'arc-active-tag';
                tag.innerHTML = filterLabels[key] + ': <strong>' + val + '</strong>' +
                    '<button class="arc-tag-remove" data-filter="' + key + '">×</button>';
                activeTags.appendChild(tag);
            }
        });

        activeWrap.style.display = hasActive ? 'flex' : 'none';

        // Remove individual tag
        activeTags.querySelectorAll('.arc-tag-remove').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var filter = this.dataset.filter;
                state[filter] = '';

                // Reset button label
                var filterBtn = document.querySelector('.arc-filter-btn[data-filter="' + filter + '"]');
                if (filterBtn) {
                    filterBtn.querySelector('.arc-filter-label').textContent =
                        filterLabels[filter] || filter;
                    filterBtn.classList.remove('has-value');
                }

                // Reset dropdown item
                var dropdown = document.querySelector('.arc-filter-dropdown[data-for="' + filter + '"]');
                if (dropdown) {
                    dropdown.querySelectorAll('.arc-dropdown-item').forEach(function(i) {
                        i.classList.toggle('is-active', i.dataset.value === '');
                    });
                }

                applyFilters();
            });
        });
    }

    // ============================================
    // CLEAR ALL
    // ============================================
    function clearAllFilters() {
        state = { region: '', difficulty: '', duration: '', sort: 'default' };

        document.querySelectorAll('.arc-filter-btn').forEach(function(btn) {
            var filter = btn.dataset.filter;
            var label = btn.querySelector('.arc-filter-label');
            var defaults = {
                region: 'Region',
                difficulty: 'Difficulty',
                duration: 'Duration',
                sort: 'Sort By'
            };
            if (label) label.textContent = defaults[filter] || filter;
            btn.classList.remove('has-value', 'is-active');
        });

        document.querySelectorAll('.arc-dropdown-item').forEach(function(item) {
            item.classList.toggle('is-active', item.dataset.value === '' ||
                item.dataset.value === 'default');
        });

        applyFilters();
    }

    if (clearAll) clearAll.addEventListener('click', clearAllFilters);
    if (clearBtn) clearBtn.addEventListener('click', clearAllFilters);

    // ============================================
    // STICKY FILTER BAR
    // ============================================
    var filterBar = document.getElementById('arcFilterBar');
    if (filterBar) {
        window.addEventListener('scroll', function() {
            filterBar.classList.toggle('is-sticky', window.scrollY > 200);
        });
    }

});