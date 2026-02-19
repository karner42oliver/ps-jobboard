<?php
/**
 * Unified Jobboard Dashboard
 * Main hub for managing jobs and experts
 */
?>

<div class="wrap je-unified-dashboard">
	<h1><?php _e( 'Jobboard Verwaltung', 'psjb' ); ?></h1>
	
	<div class="je-dashboard-header">
		<div class="je-dashboard-stats">
			<?php
			// Get stats from cache or generate fresh
			$cache_key = 'jbp_dashboard_stats';
			$stats = get_transient( $cache_key );
			
			if ( false === $stats ) {
				$job_count = wp_count_posts( 'jbp_job' );
				$expert_count = wp_count_posts( 'jbp_pro' );
				$stats = array(
					'published_jobs' => $job_count->publish ?? 0,
					'published_experts' => $expert_count->publish ?? 0,
				);
				// Cache for 5 minutes
				set_transient( $cache_key, $stats, 5 * MINUTE_IN_SECONDS );
			}
			$published_jobs = $stats['published_jobs'];
			$published_experts = $stats['published_experts'];
			?>
			<div class="stat-card">
				<h3><?php echo absint( $published_jobs ); ?></h3>
				<p><?php _e( 'Aktive Jobs', 'psjb' ); ?></p>
				<a href="<?php echo admin_url( 'edit.php?post_type=jbp_job' ); ?>" class="button">
					<?php _e( 'Alle anzeigen', 'psjb' ); ?>
				</a>
			</div>
			
			<div class="stat-card">
				<h3><?php echo absint( $published_experts ); ?></h3>
				<p><?php _e( 'Registrierte Experten', 'psjb' ); ?></p>
				<a href="<?php echo admin_url( 'edit.php?post_type=jbp_pro' ); ?>" class="button">
					<?php _e( 'Alle anzeigen', 'psjb' ); ?>
				</a>
			</div>

			<div class="stat-card">
				<h3><?php echo esc_html( je()->version ); ?></h3>
				<p><?php _e( 'Plugin-Version', 'psjb' ); ?></p>
				<a href="<?php echo admin_url( 'admin.php?page=je-jobboard-settings' ); ?>" class="button">
					<?php _e( 'Einstellungen', 'psjb' ); ?>
				</a>
			</div>
		</div>
	</div>

	<div class="je-dashboard-content">
		<div class="je-quick-actions">
			<h2><?php _e( 'Schnellaktionen', 'psjb' ); ?></h2>
			<div class="action-buttons">
				<a href="<?php echo admin_url( 'post-new.php?post_type=jbp_job' ); ?>" class="button button-primary">
					<?php _e( '➕ Neuer Job', 'psjb' ); ?>
				</a>
				<a href="<?php echo admin_url( 'post-new.php?post_type=jbp_pro' ); ?>" class="button button-primary">
					<?php _e( '➕ Neuer Experte', 'psjb' ); ?>
				</a>
				<a href="<?php echo admin_url( 'admin.php?page=je-jobboard-settings' ); ?>" class="button">
					<?php _e( '⚙️ Einstellungen', 'psjb' ); ?>
				</a>
			</div>
		</div>

		<div class="je-dashboard-grid">
			<div class="je-panel">
				<h3><?php _e( 'Systemstatus', 'psjb' ); ?></h3>
				<table class="widefat">
					<tr>
						<td><?php _e( 'Plugin:', 'psjb' ); ?></td>
						<td><span class="badge badge-success"><?php _e( 'Aktiv', 'psjb' ); ?></span></td>
					</tr>
				</table>
			</div>

			<div class="je-panel">
				<h3><?php _e( 'Erste Schritte', 'psjb' ); ?></h3>
				<ul class="getting-started-list">
					<li>
						<strong><?php _e( '1. Erstelle deinen ersten Job:', 'psjb' ); ?></strong> 
						<a href="<?php echo admin_url( 'post-new.php?post_type=jbp_job' ); ?>">
							<?php _e( 'Veröffentliche einen neuen Job', 'psjb' ); ?>
						</a>
					</li>
					<li>
						<strong><?php _e( '2. Füge Experten hinzu:', 'psjb' ); ?></strong> 
						<a href="<?php echo admin_url( 'edit.php?post_type=jbp_pro' ); ?>">
							<?php _e( 'Registriere neue Experten', 'psjb' ); ?>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>

