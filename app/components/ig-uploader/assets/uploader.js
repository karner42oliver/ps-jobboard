jQuery(function ($) {
    var file_port;
    var igu_uploader;
    
    // Formular inline laden (Hinzufügen)
    $('body').on('click', '.add-file', function () {
        var key = 'igu_uploader_' + $(this).parent().parent().parent().attr('id');
        igu_uploader = window[key];
        var container = $(this).closest('section').find('.uploader-form-container');
        
        if (container.is(':visible')) {
            container.slideUp().html('');
            return;
        }
        
        $.ajax({
            url: igu_uploader.add_url,
            success: function(data) {
                container.html(data).slideDown();
                file_port = $(this).closest('section').find('.file-view-port');
            }
        });
    });
    
    // Datei bearbeiten
    $('body').on('click', '.igu-file-update', function () {
        var key = 'igu_uploader_' + $(this).closest('section').parent().parent().attr('id');
        igu_uploader = window[key];
        var container = $(this).closest('section').find('.uploader-form-container');
        var fileId = $(this).data('id');
        
        if (container.is(':visible')) {
            container.slideUp().html('');
            return;
        }
        
        $.ajax({
            url: igu_uploader.edit_url + fileId,
            success: function(data) {
                container.html(data).slideDown();
                file_port = $(this).closest('section').find('.file-view-port');
            }
        });
    });
    
    // Uploader Submit Button Click Handler
    $('body').on('click', '.igu-submit-uploader', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $('.uploader-form-container .igu-upload-form').trigger('igu-upload-submit');
    });
    
    $('body').on('igu-upload-submit', '.igu-upload-form', function (e) {
        e.preventDefault();
        e.stopPropagation();
        
        var that = $(this);
        var section = that.closest('section');
        var container = section.find('.uploader-form-container');
        var fileInput = that.find('input[name="portfolio_file"]')[0];
        
        // Find igu_uploader config
        var sectionId = section.attr('id');
        var igu_uploader_config = null;
        if (sectionId) {
            igu_uploader_config = window['igu_uploader_' + sectionId];
        }
        
        if (!igu_uploader_config) {
            for (var key in window) {
                if (key.indexOf('igu_uploader_') === 0 && typeof window[key] === 'object') {
                    igu_uploader_config = window[key];
                    break;
                }
            }
        }
        
        if (!igu_uploader_config) {
            alert('Fehler: Uploader-Konfiguration nicht gefunden.');
            return false;
        }
        
        // Create FormData with file upload
        var formData = new FormData();
        
        // Add file if selected
        if (fileInput && fileInput.files && fileInput.files.length > 0) {
            formData.append('portfolio_file', fileInput.files[0]);
        }
        
        // Add other form fields
        that.find(':input:not([type="file"])').each(function() {
            var name = $(this).attr('name');
            var value = $(this).val();
            if (name && value) {
                formData.append(name, value);
            }
        });
        
        $.ajax(igu_uploader_config.form_submit_url, {
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                that.find('button').attr('disabled', 'disabled');
            },
            success: function (data) {
                that.find('button').removeAttr('disabled');
                
                // Parse data if it's a string
                if (typeof data === 'string') {
                    try {
                        data = JSON.parse(data);
                    } catch(e) {
                        alert('Fehler beim Hochladen der Datei.');
                        return;
                    }
                }
                
                if (data.status == 'success') {
                    // Find file-view-port - could be the section itself or a child
                    var file_view_port = section.hasClass('file-view-port') ? section : section.find('.file-view-port');
                    
                    // Prüfe ob Update oder Insert
                    var existingFile = $('#igu-media-file-' + data.id);
                    
                    if (existingFile.length > 0) {
                        // Update
                        var html = $(data.html);
                        existingFile.html(html.html());
                    } else {
                        // Insert
                        var att = $(data.html);
                        att.css('display', 'none');
                        file_view_port.find('.no-file').remove();
                        file_view_port.prepend(att);
                        
                        if (file_view_port.width() <= (180 * 3)) {
                            att.css('width', '49%');
                        }
                        if (file_view_port.width() >= (180 * 4)) {
                            att.css('width', '25%');
                        }
                        att.css('display', 'block');
                        
                        // Find portfolios hidden input in main form (IG_Active_Form uses array-style names)
                        var input = $('input[name="portfolios"], input[name$="[portfolios]"]');
                        console.log('[PORTFOLIO] Found hidden input:', input.length);
                        console.log('[PORTFOLIO] Current value:', input.val());
                        var currentVal = input.val() || '';
                        var newVal = (currentVal ? currentVal + ',' : '') + data.id;
                        input.val(newVal);
                        console.log('[PORTFOLIO] New value:', newVal);
                    }
                    
                    that.find(':input:not([type=hidden])').val('');
                    container.slideUp().html('');
                } else {
                    // Fehlerbehandlung
                    that.find('.form-group').removeClass('has-error has-success');
                    $.each(data.errors, function (i, v) {
                        var element = that.find('.error-' + i);
                        element.parent().addClass('has-error');
                        element.html(v);
                    });
                    that.find('.form-group').each(function () {
                        if (!$(this).hasClass('has-error')) {
                            $(this).find('.m-b-none').text('');
                            $(this).addClass('has-success');
                        }
                    });
                }
            },
            error: function(xhr, status, error) {
                that.find('button').removeAttr('disabled');
                alert('Fehler beim Hochladen: ' + (error || 'Unbekannter Fehler'));
            }
        });
        return false;
    });
    
    $('body').on('click', '.igu-close-uploader', function () {
        $(this).closest('section').find('.uploader-form-container').slideUp().html('');
    });
    
    $('body').on('click', '.igu-file-delete', function (e) {
        e.preventDefault();
        var section = $(this).closest('section');
        var key = 'igu_uploader_' + section.parent().parent().attr('id');
        igu_uploader = window[key];
        var id = $(this).data('id');
        var that = $(this);
        var parent = $('#igu-media-file-' + id);
        
        $.ajax({
            type: 'POST',
            url: igu_uploader.ajax_url,
            data: {
                action: 'igu_file_delete',
                id: id,
                _wpnonce: igu_uploader.delete_nonce
            },
            beforeSend: function () {
                parent.find('button').attr('disabled', 'disabled');
                parent.css('opacity', 0.5);
            },
            success: function () {
                var element = $('#' + igu_uploader.target_id);
                element.val(element.val().replace(id, ''));
                parent.remove();
            }
        })
    });
    
    $('.file-view-port').each(function () {
        if ($(this).width() >= (180 * 4)) {
            $(this).find('.igu-media-file-land').css('width', '25%');
        }
        if ($(this).width() <= (180 * 3)) {
            $(this).find('.igu-media-file-land').css('width', '49%');
        }
    })
});
