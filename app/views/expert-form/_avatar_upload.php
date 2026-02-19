<div class="expert-avatar">
    <div class="panel panel-default">
        <div class="panel-body no-padding">
            <?php echo $model->get_avatar(420) ?>
        </div>
        <div class="panel-footer">
            <?php if (je()->can_upload_avatar()): ?>
                <button type="button" class="btn btn-primary btn-sm toggle-avatar-upload">
                    <?php _e("Avatar ändern", 'psjb') ?>
                </button>
                
                <!-- Inline Avatar Upload Form -->
                <div class="avatar-upload-form" style="display:none; margin-top: 15px; padding: 15px; background: #f5f5f5; border-radius: 4px;">
                    <div class="alert alert-danger" style="display:none;"></div>
                    <div class="file-uploader-form" style="margin: 0;">
                        <div class="form-group">
                            <label><?php _e("Bild auswählen", 'psjb') ?></label>
                            <input type="file" name="hn_uploader_element" class="hn_uploader_element form-control" accept="image/*" style="margin-bottom: 10px;">
                            <small class="form-text text-muted"><?php echo sprintf(__("Max. Größe: %s MB", 'psjb'), get_max_file_upload()) ?></small>
                        </div>
                        <input type="hidden" name="parent_id" value="<?php echo $model->id ?>">
                        <button type="button" class="btn btn-success btn-sm avatar-submit-btn"><?php _e("Hochladen", 'psjb') ?></button>
                        <button type="button" class="btn btn-default btn-sm cancel-avatar-upload"><?php _e("Abbrechen", 'psjb') ?></button>
                    </div>
                </div>
            <?php else: ?>
                <?php _e("Du hast keine Berechtigung zum Hochladen eines Avatars", 'psjb') ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php if (je()->can_upload_avatar()): ?>
    <script type="text/javascript">
        jQuery(function ($) {
            // Toggle Avatar Upload Form
            $('body').on('click', '.toggle-avatar-upload', function () {
                var form = $(this).closest('.expert-avatar').find('.avatar-upload-form');
                if (form.is(':visible')) {
                    form.slideUp();
                } else {
                    form.slideDown();
                }
            });
            
            // File Validation
            $('body').on('change', '.hn_uploader_element', function (e) {
                var file = e.target.files[0];
                if (!file) return;
                
                var type = file.type.split('/');
                var size_allowed = '<?php echo (get_max_file_upload() * 1000000) ?>';
                
                if (type[0] != 'image') {
                    alert(expert_form.avatar_error_file);
                    $(this).val("");
                } else if (file.size > size_allowed) {
                    alert(expert_form.avatar_error_size);
                    $(this).val("");
                }
            });
            
            // Form Submit - Trigger on button click instead of form submit
            $('body').on('click', '.avatar-submit-btn', function (e) {
                e.preventDefault();
                e.stopPropagation();
                
                var btn = $(this);
                var form = btn.closest('.file-uploader-form');
                var parent = form.closest('.avatar-upload-form');
                var file = form.find('input[name="hn_uploader_element"]');

                if (!file.val()) {
                    alert(expert_form.avatar_empty);
                    return false;
                }

                // Create FormData from file input
                var formData = new FormData();
                // CRITICAL: Backend expects $_FILES['hn_uploader'], not 'hn_uploader_element'
                formData.append('hn_uploader', file[0].files[0]);
                formData.append('parent_id', form.find('input[name="parent_id"]').val());
                
                var nonce = '<?php echo wp_create_nonce('hn_upload_avatar'); ?>';
                var uploadUrl = '<?php echo home_url(); ?>' + '?upload_file_nonce=' + encodeURIComponent(nonce);
                
                $.ajax({
                    url: uploadUrl,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        parent.find('.alert').html('').hide();
                        btn.attr('disabled', 'disabled').text('wird hochgeladen...');
                    },
                    success: function (data) {
                        btn.removeAttr('disabled').text('<?php _e("Hochladen", "psjb") ?>');
                        console.log('Avatar Response:', data);
                        
                        // Check if response is a valid image URL
                        if (data && (data.indexOf('http') === 0 || data.indexOf('/') === 0)) {
                            // Update Avatar Image
                            var avatarDiv = form.closest('.expert-avatar');
                            avatarDiv.find('.panel-body').html('<img src="' + data.trim() + '" style="width: 100%; height: auto;">');
                            // Reset Form
                            file.val('');
                            parent.slideUp();
                        } else {
                            parent.find('.alert').html('Fehler: ' + (data || 'Unbekannter Fehler')).show();
                        }
                    },
                    error: function(xhr, status, error) {
                        btn.removeAttr('disabled').text('<?php _e("Hochladen", "psjb") ?>');
                        console.log('Avatar Error:', status, error, xhr.responseText);
                        parent.find('.alert').html('Upload fehlgeschlagen: ' + (error || 'Bitte versuche es später erneut')).show();
                    }
                });
                
                return false;
            });
            
            // Cancel Button
            $('body').on('click', '.cancel-avatar-upload', function () {
                $(this).closest('.avatar-upload-form').slideUp();
                $(this).closest('.file-uploader-form').find('input[name="hn_uploader_element"]').val('');
            });
        });
    </script>
<?php endif; ?>