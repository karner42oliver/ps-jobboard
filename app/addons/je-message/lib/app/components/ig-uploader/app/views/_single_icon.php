<?php
$colors = array(
    'igu-blue',
    'igu-pink',
    'igu-dark-blue',
    'igu-green',
    'igu-black',
    'igu-yellow',
    'igu-purple',
    'igu-grey',
    'igu-green-alt',
    'igu-red',
    'igu-marine',
);
$color = $colors[array_rand($colors)];

$file_url = '';
if ( ! empty( $model->file ) ) {
    if ( filter_var( $model->file, FILTER_VALIDATE_INT ) ) {
        $file_url = wp_get_attachment_url( $model->file );
    } else {
        $file_url = $model->file;
    }
}

$file_type = $file_url ? wp_check_filetype( $file_url ) : array();
$mime_type = ! empty( $file_type['type'] ) ? $file_type['type'] : '';
$is_image = ( strpos( $mime_type, 'image/' ) === 0 );
?>
<div class="igu-media-file-land igu-media-icon" style="margin-right: 1%;width: 32.3%;padding: 0" id="igu-media-file-<?php echo $model->id ?>">
    <div class="well well-sm">
        <div class="row no-margin">
            <div class="col-md-12 col-sm-12 col-xs-12 no-padding">
                <div class="igu-media-file-thumbnail hidden-xs hidden-sm <?php echo $color ?>">
                    <?php if ( $is_image && $file_url ): ?>
                        <img src="<?php echo esc_url( $file_url ); ?>" alt="" style="max-width:100%;height:auto;display:block;" />
                    <?php else: ?>
                        <?php echo $model->mime_to_icon() ?>
                    <?php endif; ?>
                </div>
                <div class="igu-media-file-meta">
                    <h5><?php echo ig_uploader()->trim_text($model->name, 17) ?></h5>

                    <p class="text-muted small"><?php echo get_the_date(null, $model->id) ?></p>

                    <?php if ( ! empty( $model->content ) ): ?>
                        <p class="text-muted small"><?php echo esc_html( $model->content ); ?></p>
                    <?php endif; ?>

                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="igu-media-info hide">
        <a href="#igu-modal-<?php echo $model->id ?>"><i class="fa fa-search-plus fa-2x"></i></a>
    </div>
</div>