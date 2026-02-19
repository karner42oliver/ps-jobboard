<div class="ig-container">
    <?php
    //empty modal for fields work only
    if (!isset($model)) {
        $model = new IG_Uploader_Model();
    }
    ?>
    <div class="igu-upload-form" style="min-width:60%;max-width:304px;">
    <?php if ($model->exist) { ?>
        <input type="hidden" name="id" value="<?php echo $model->id; ?>">
    <?php } ?>
    <div style="margin-bottom: 0" class="form-group <?php echo $model->has_error("file") ? "has-error" : null ?>">
        <label><?php _e("Datei auswählen", ig_uploader()->domain) ?></label>
        <input type="file" name="portfolio_file" class="form-control portfolio-file-input" style="margin-bottom: 10px;">
        <input type="hidden" name="file" id="attachment" value="<?php echo $model->exist && $model->file ? $model->file : ''; ?>">
        <?php if ($model->exist && $model->file) : ?>
            <span
                class="help-block m-b-none"><?php _e("Datei angehängt, neue Datei hochladen ersetzt die aktuelle Datei.", ig_uploader()->domain) ?></span>
        <?php endif; ?>
        <span class="help-block m-b-none error-file"></span>

        <div class="clearfix"></div>
    </div>
    <div style="margin-bottom: 0" class="form-group <?php echo $model->has_error("url") ? "has-error" : null ?>">
        <label class="control-label hidden-xs hidden-sm"><?php _e("Url", ig_uploader()->domain) ?></label>
        <input type="text" name="url" class="form-control input-sm" placeholder="<?php _e("Url", ig_uploader()->domain) ?>" value="<?php echo $model->exist ? $model->url : ''; ?>">
        <span class="help-block m-b-none error-url"></span>

        <div class="clearfix"></div>
    </div>
    <div style="margin-bottom: 0" class="form-group <?php echo $model->has_error("title") ? "has-error" : null ?>">
        <label class="control-label hidden-xs hidden-sm"><?php _e("Titel", ig_uploader()->domain) ?></label>
        <input type="text" name="title" class="form-control input-sm" placeholder="<?php _e("Titel", ig_uploader()->domain) ?>" value="<?php echo $model->exist ? $model->name : ''; ?>">
        <span class="help-block m-b-none error-title"></span>

        <div class="clearfix"></div>
    </div>
    <div style="margin-bottom: 0" class="form-group <?php echo $model->has_error("content") ? "has-error" : null ?>">
        <label class="control-label hidden-xs hidden-sm"><?php _e("Beschreibung", ig_uploader()->domain) ?></label>
        <textarea name="content" class="form-control input-sm" style="height:80px" placeholder="<?php _e("Beschreibung", ig_uploader()->domain) ?>"><?php echo $model->exist ? $model->content : ''; ?></textarea>
        <span class="help-block m-b-none error-content"></span>

        <div class="clearfix"></div>
    </div>
    <?php echo wp_nonce_field('igu_uploading') ?>
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-default btn-sm igu-close-uploader"
                    type="button"><?php _e("Abbrechen", ig_uploader()->domain) ?></button>
            <button class="btn btn-primary btn-sm igu-submit-uploader" type="button"><?php _e("Übermitteln", ig_uploader()->domain) ?></button>
        </div>
        <div class="clearfix"></div>
    </div>
    </div> <!-- close igu-upload-form div -->