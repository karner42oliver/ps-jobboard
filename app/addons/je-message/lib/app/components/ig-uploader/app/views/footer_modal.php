<div class="ig-container">
    <?php foreach ($models as $model): ?>
        <div class="modal" id="igu-modal-<?php echo $model->id ?>">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><?php echo $model->name ?></h4>
                    </div>
                    <div class="modal-body sample-pop" style="max-height:450px;overflow-y:scroll">
                        <?php
                        $file = $model->file;
                        //check does this file exist

                        $file_url = '';
                        if ( $file ) {
                            if ( filter_var( $file, FILTER_VALIDATE_INT ) ) {
                                $file_url = wp_get_attachment_url( $file );
                            } else {
                                $file_url = $file;
                            }
                        }
                        $file_type = $file_url ? wp_check_filetype( $file_url ) : array();
                        $mime_type = ! empty( $file_type['type'] ) ? $file_type['type'] : '';
                        $show_image = ( strpos( $mime_type, 'image/' ) === 0 );

                        if ( $show_image && $file_url ) {
                            echo '<img src="' . esc_url( $file_url ) . '" style="max-width:100%;height:auto;display:block;" />';
                        } elseif ( $file_url ) {
                            //show meta
                            ?>
                            <ul class="list-group">
                                <li class="list-group-item upload-item">
                                    <i class="glyphicon glyphicon-floppy-disk"></i>
                                    <?php _e('Größe', je()->domain) ?>:
                                    <strong><?php
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
                                        echo $file_size ? $file_size : __("N/A", je()->domain);
                                        ?></strong>
                                </li>
                                <li class="list-group-item upload-item">
                                    <i class="glyphicon glyphicon-file"></i>
                                    <?php _e('Typ', je()->domain) ?>:
                                    <strong><?php echo $mime_type ? esc_html( $mime_type ) : __("N/A", je()->domain); ?></strong>
                                </li>
                            </ul>
                        <?php
                        } else {
                            ?>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <i class="glyphicon glyphicon-link"></i>
                                    <strong><?php _e('Link', je()->domain) ?></strong>:
                                    <?php echo $model->url ?>
                                </li>
                                <div class="clearfix"></div>
                            </ul>
                        <?php
                        }

                        if ( ! empty( $model->content ) ) {
                            echo '<p class="text-muted" style="margin-top:10px;">' . esc_html( $model->content ) . '</p>';
                        }
                        ?>
                    </div>
                    <div class="modal-footer">
                        <?php if ($model->url): ?>
                            <a class="btn btn-info" rel="nofollow"
                               href="<?php echo esc_attr($model->url) ?>" target="_blank">
                                <?php _e("Besuche Link", je()->domain) ?>
                            </a>
                        <?php endif; ?>
                        <?php if ($file_url): ?>
                            <a href="<?php echo esc_url( $file_url ); ?>" download
                               class="btn btn-info"><?php _e('Datei Download', je()->domain) ?></a>
                        <?php endif; ?>
                        <button type="button" class="btn btn-default attachment-close" data-dismiss="modal">Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<script type="text/javascript">
    jQuery(function ($) {
        $('.igu-media-info a').leanModal({
            closeButton: '.attachment-close',
            top: '1%',
            width: '90%'
        });
    })
</script>