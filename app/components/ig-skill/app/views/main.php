<div class="panel panel-default">
    <div class="panel-heading">
        <strong><?php _e('Fähigkeiten', ig_skill()->domain) ?></strong>
        <button type="button"
                class="btn btn-primary btn-xs pull-right add-skill"><?php _e('Hinzufügen', ig_skill()->domain) ?>
            <i class="glyphicon glyphicon-plus"></i></button>
    </div>
    <div class="panel-body">
        <!-- Inline Formular Container -->
        <div class="skill-form-container" style="display:none; margin-bottom: 20px;"></div>
        
        <div class="jbp-skillbars">
            <?php
            foreach ($models as $model) {
                $this->render_partial('_icon', array(
                    'model' => $model
                ));
            }
            ?>
        </div>

        <div class="clearfix"></div>
    </div>
</div>
<script type="text/javascript">
    jQuery(function ($) {
        if ($.fn.tooltip != undefined) {
            function enable_tootip() {
                $('.edit-skill').tooltip({
                    position: {
                        my: "center bottom-15",
                        at: "center top"
                    },
                    tooltipClass: 'ig-container'
                });
            }

            enable_tootip();
        }
        
        var currentEditingSkill = null;
        
        // Formular inline laden (Hinzufügen)
        $('body').on('click', '.add-skill', function () {
            var container = $('.skill-form-container');
            var button = $(this);
            
            if (container.is(':visible')) {
                container.slideUp().html('');
                return;
            }
            
            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php?action=social_skill_form&_wpnonce='.wp_create_nonce('social_skill_form')) ?>',
                success: function(data) {
                    container.html(data).slideDown();
                    container.find('input[name="score"]').trigger('change');
                    currentEditingSkill = button;
                }
            });
        });
        
        // Formular inline laden (Bearbeiten)
        $('body').on('click', '.edit-skill', function () {
            var id = $(this).closest('div').parent().data('id');
            var container = $('.skill-form-container');
            var editButton = $(this);
            
            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php?action=social_skill_form&_wpnonce='.wp_create_nonce('social_skill_form')) ?>&parent_id=<?php echo $parent->id ?>&id=' + id,
                success: function(data) {
                    container.html(data).slideDown();
                    container.find('input[name="score"]').trigger('change');
                    container.find('select').trigger('change');
                    currentEditingSkill = editButton;
                }
            });
        });
        
        $('body').on('keyup', 'input[name="name"]', function () {
            var preview = $('.skill-preview');
            preview.find('.skill-name').text($(this).val());
        });

        $('body').on('change mousemove', 'input[name="score"]', function () {
            $('.skill-preview').find('.progress-bar').text($(this).val() + '%').css('width', $(this).val() + '%')
        });

        $('body').on('change', 'select[name="color"]', function () {
            //clear old class
            $(this).find('option').each(function () {
                $('.skill-preview').find('.progress-bar').removeClass('progress-bar-' + $(this).val());
            });
            $('.skill-preview').find('.progress-bar').addClass('progress-bar-' + $(this).val());
        })

        $('body').on('click', 'input[name="animated"]', function () {
            if ($(this).prop('checked') == true) {
                $('.skill-preview').find('.progress-bar').addClass('progress-bar-striped active');
            } else {
                $('.skill-preview').find('.progress-bar').removeClass('progress-bar-striped active');
            }
        });

        $('body').on('click', '.hn-save-skill', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $('.skill-form-container .ig-skill-form').trigger('ig-skill-submit');
        });

        $('body').on('ig-skill-submit', '.ig-skill-form', function (e) {
            
            var form = $(this);
            var parent = $('.skill-add-form').parent();
            var input = $('#<?php echo $element ?>');
            var container = $('.skill-form-container');
            
            $.ajax({
                type: 'POST',
                url: '<?php echo admin_url('admin-ajax.php') ?>',
                data: {
                    action: 'jbp_skill_add',
                    _nonce: '<?php echo wp_create_nonce('jbp_skill_add') ?>',
                    parent_id: '<?php echo $parent->id ?>',
                    name: form.find('input[name="name"]').val(),
                    value: form.find('input[name="score"]').val(),
                    css: $('.skill-preview').find('.progress-bar').attr('class')
                },
                beforeSend: function () {
                    parent.find('.ig-overlay').removeClass('hide');
                    parent.find('.alert').addClass('hide');
                },
                success: function (data) {
                    parent.find('.ig-overlay').addClass('hide');
                    data = $.parseJSON(data);
                    if (data.status == 0) {
                        parent.find('.alert').html(data.errors).removeClass('hide');
                    } else {
                        if (currentEditingSkill.hasClass('add-skill')) {
                            var element = $(data.html);
                            $('.jbp-skillbars').prepend(data.html).find('p').remove();
                            enable_tootip();
                            input.val(input.val() + ',' + element.data('id'));
                        } else {
                            var element = $(data.html);
                            var key = element.data('id');
                            input.val(input.val().replace(currentEditingSkill.parent().data('id'), key));
                            currentEditingSkill.parent().replaceWith(element);
                        }
                        container.slideUp().html('');
                        currentEditingSkill = null;
                    }
                }
            })
            return false;
        })
        
        $('body').on('click', '.hn-cancel-skill', function () {
            $('.skill-form-container').slideUp().html('');
            currentEditingSkill = null;
        });
        
        $('body').on('click', '.hn-delete-skill', function () {
            var input = $('#<?php echo $element ?>');
            input.val(input.val().replace(currentEditingSkill.parent().data('id'), ''));
            currentEditingSkill.parent().remove();
            $('.skill-form-container').slideUp().html('');
            currentEditingSkill = null;
        })

    })
</script>
