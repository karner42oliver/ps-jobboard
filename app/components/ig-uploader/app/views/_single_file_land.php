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

$file_size = '';
if ( $file_url ) {
	$uploads = wp_upload_dir();
	if ( strpos( $file_url, $uploads['baseurl'] ) === 0 ) {
		$relative = str_replace( $uploads['baseurl'], '', $file_url );
		$path = $uploads['basedir'] . $relative;
		if ( file_exists( $path ) ) {
			$file_size = size_format( filesize( $path ) );
		}
	}
}
?>
<div class="igu-media-file-land" id="igu-media-file-<?php echo $model->id ?>" data-id="<?php echo $model->id ?>">
    <div class="well well-sm">
        <div class="row no-margin">
            <div class="col-md-10 col-sm-10 col-xs-10 no-padding">
                <div class="igu-media-file-thumbnail hidden-xs hidden-sm <?php echo $color ?>">
                    <?php if ( $is_image && $file_url ): ?>
                        <img src="<?php echo esc_url( $file_url ); ?>" alt="" style="max-width:100%;height:auto;display:block;" />
                    <?php else: ?>
                        <?php echo $model->mime_to_icon() ?>
                    <?php endif; ?>
                </div>
                <div class="igu-media-file-meta">
                    <h5><?php echo wp_trim_words($model->name, 6) ?></h5>

                    <p class="text-muted small">
                        <?php echo get_the_date(null, $model->id) ?>
                        <?php if ( $mime_type ): ?>
                            <span> · <?php echo esc_html( $mime_type ); ?></span>
                        <?php endif; ?>
                        <?php if ( $file_size ): ?>
                            <span> · <?php echo esc_html( $file_size ); ?></span>
                        <?php endif; ?>
                    </p>
                    <?php if ( ! empty( $model->content ) ): ?>
                        <p class="text-muted small"><?php echo esc_html( $model->content ); ?></p>
                    <?php endif; ?>
                    <?php if ( ! empty( $model->url ) ): ?>
                        <p class="text-muted small"><a href="<?php echo esc_url( $model->url ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $model->url ); ?></a></p>
                    <?php endif; ?>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-2 no-padding">
                <div class="btn-group-vertical btn-group-xs pull-right" role="group">
                    <button data-id="<?php echo $model->id ?>"
                       data-target="#igu-uploader-form-<?php echo $model->id ?>" type="button"
                       class="igu-file-update btn btn-default btn-xs" data-anchor=".popover-anchor-<?php echo $model->id ?>">
                        <i class="fa fa-pencil"></i>
                    </button>
                    <button data-id="<?php echo $model->id ?>" type="button"
                       class="igu-file-delete btn btn-xs btn-danger">
                        <i class="glyphicon glyphicon-trash"></i>
                    </button>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>

</div>