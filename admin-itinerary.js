jQuery(document).ready(function($) {

    // ============================================
    // DYNAMIC ADD/REMOVE DAYS
    // ============================================
    var maxDays = 30;

    function getDayCount() {
        return $('.tp-day-row').length;
    }

    function updateDayNumbers() {
        $('.tp-day-row').each(function(i) {
            $(this).find('.tp-day-label').text('Day ' + (i + 1));
            // Update all input names to match new index
            var newIdx = i + 1;
            $(this).find('input, textarea').each(function() {
                var name = $(this).attr('name');
                if (name) {
                    $(this).attr('name', name.replace(/trip_day_\d+/, 'trip_day_' + newIdx));
                }
            });
        });
    }

    // Add new day
    $(document).on('click', '#tp-add-day', function() {
        var count = getDayCount();
        if (count >= maxDays) {
            alert('Maximum ' + maxDays + ' days allowed.');
            return;
        }
        var newIdx = count + 1;
        var row = $('<div class="tp-day-row" style="border:1px solid #ddd;border-radius:6px;padding:14px;margin-bottom:12px;background:#fafafa;">' +
            '<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px">' +
            '<strong class="tp-day-label" style="color:#1A2E20">Day ' + newIdx + '</strong>' +
            '<button type="button" class="tp-remove-day button" style="color:#c0392b;border-color:#c0392b">Remove</button>' +
            '</div>' +
            '<div style="display:grid;grid-template-columns:1fr 130px 130px;gap:8px;margin-bottom:8px">' +
            '<input type="text" name="trip_day_' + newIdx + '_title" placeholder="Day title (e.g. Fly to Lukla, Trek to Phakding)" style="width:100%">' +
            '<input type="text" name="trip_day_' + newIdx + '_duration" placeholder="Duration (e.g. 5-6 hrs)" style="width:100%">' +
            '<input type="text" name="trip_day_' + newIdx + '_altitude" placeholder="Altitude (e.g. 3440m)" style="width:100%">' +
            '</div>' +
            '<textarea name="trip_day_' + newIdx + '_desc" placeholder="Day description..." rows="2" style="width:100%;margin-bottom:8px"></textarea>' +
            '<div style="display:flex;align-items:center;gap:8px">' +
            '<input type="hidden" name="trip_day_' + newIdx + '_photo" class="tp-day-photo-url" value="">' +
            '<button type="button" class="tp-upload-photo button">📷 Add Photo</button>' +
            '<span class="tp-photo-preview" style="font-size:12px;color:#999"></span>' +
            '</div>' +
            '</div>');
        $('#tp-days-container').append(row);
        updateAddButton();
    });

    // Remove day
    $(document).on('click', '.tp-remove-day', function() {
        $(this).closest('.tp-day-row').remove();
        updateDayNumbers();
        updateAddButton();
    });

    function updateAddButton() {
        var count = getDayCount();
        if (count >= maxDays) {
            $('#tp-add-day').prop('disabled', true).text('Maximum ' + maxDays + ' days reached');
        } else {
            $('#tp-add-day').prop('disabled', false).text('+ Add Day ' + (count + 1));
        }
    }

    updateAddButton();

    // ============================================
    // WORDPRESS MEDIA UPLOADER FOR DAY PHOTOS
    // ============================================
    $(document).on('click', '.tp-upload-photo', function(e) {
        e.preventDefault();
        var btn = $(this);
        var row = btn.closest('.tp-day-row');
        var hiddenInput = row.find('.tp-day-photo-url');
        var preview = row.find('.tp-photo-preview');

        var frame = wp.media({
            title: 'Select Day Photo',
            button: { text: 'Use this photo' },
            multiple: false,
            library: { type: 'image' }
        });

        frame.on('select', function() {
            var attachment = frame.state().get('selection').first().toJSON();
            hiddenInput.val(attachment.url);
            preview.html('<img src="' + attachment.url + '" style="height:40px;border-radius:4px;vertical-align:middle;margin-right:6px"><a href="#" class="tp-remove-photo" style="color:#c0392b;font-size:11px">Remove</a>');
        });

        frame.open();
    });

    // Remove day photo
    $(document).on('click', '.tp-remove-photo', function(e) {
        e.preventDefault();
        var row = $(this).closest('.tp-day-row');
        row.find('.tp-day-photo-url').val('');
        row.find('.tp-photo-preview').html('');
    });

});