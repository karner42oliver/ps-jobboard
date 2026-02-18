<?php
/**
 * Unified Jobboard Dashboard
 * Main hub for managing jobs and experts
 */
?>

<div class="wrap je-unified-dashboard">
	<h1><?php _e( 'Jobboard Management', 'psjb' ); ?></h1>
	
	<div class="je-dashboard-header">
		<div class="je-dashboard-stats">
			<?php
			// Get stats
			$job_count = wp_count_posts( 'jbp_job' );
			$expert_count = wp_count_posts( 'jbp_pro' );
			$published_jobs = $job_count->publish ?? 0;
			$published_experts = $expert_count->publish ?? 0;
			?>
			<div class="stat-card">
				<h3><?php echo absint( $published_jobs ); ?></h3>
				<p><?php _e( 'Active Jobs', 'psjb' ); ?></p>
				<a href="<?php echo admin_url( 'edit.php?post_type=jbp_job' ); ?>" class="button">
					<?php _e( 'View All', 'psjb' ); ?>
				</a>
			</div>
			
			<div class="stat-card">
				<h3><?php echo absint( $published_experts ); ?></h3>
				<p><?php _e( 'Registered Experts', 'psjb' ); ?></p>
				<a href="<?php echo admin_url( 'edit.php?post_type=jbp_pro' ); ?>" class="button">
					<?php _e( 'View All', 'psjb' ); ?>
				</a>
			</div>

			<div class="stat-card">
				<h3><?php echo esc_html( je()->version ); ?></h3>
				<p><?php _e( 'Plugin Version', 'psjb' ); ?></p>
				<a href="<?php echo admin_url( 'admin.php?page=je-jobboard-settings' ); ?>" class="button">
					<?php _e( 'Settings', 'psjb' ); ?>
				</a>
			</div>
		</div>
	</div>

	<div class="je-dashboard-content">
		<div class="je-quick-actions">
			<h2><?php _e( 'Quick Actions', 'psjb' ); ?></h2>
			<div class="action-buttons">
				<a href="<?php echo admin_url( 'post-new.php?post_type=jbp_job' ); ?>" class="button button-primary">
					<?php _e( '➕ New Job', 'psjb' ); ?>
				</a>
				<a href="<?php echo admin_url( 'post-new.php?post_type=jbp_pro' ); ?>" class="button button-primary">
					<?php _e( '➕ New Expert', 'psjb' ); ?>
				</a>
				<a href="<?php echo admin_url( 'admin.php?page=je-jobboard-settings' ); ?>" class="button">
					<?php _e( '⚙️ Settings', 'psjb' ); ?>
				</a>
			</div>
		</div>

		<div class="je-dashboard-grid">
			<div class="je-panel">
				<h3><?php _e( 'System Status', 'psjb' ); ?></h3>
				<table class="widefat">
					<tr>
						<td><?php _e( 'Plugin:', 'psjb' ); ?></td>
						<td><span class="badge badge-success"><?php _e( 'Active', 'psjb' ); ?></span></td>
					</tr>
					<tr>
						<td><?php _e( 'Pages Settings:', 'psjb' ); ?></td>
						<td><a href="<?php echo admin_url( 'admin.php?page=je-jobboard-settings&tab=pages' ); ?>" class="link-button">
							<?php _e( 'Configure', 'psjb' ); ?>
						</a></td>
					</tr>
					<tr>
						<td><?php _e( 'Email Templates:', 'psjb' ); ?></td>
						<td><a href="<?php echo admin_url( 'admin.php?page=je-jobboard-settings&tab=email' ); ?>" class="link-button">
							<?php _e( 'Edit', 'psjb' ); ?>
						</a></td>
					</tr>
				</table>
			</div>

			<div class="je-panel">
				<h3><?php _e( 'Getting Started', 'psjb' ); ?></h3>
				<ul class="getting-started-list">
					<li>
						<strong><?php _e( '1. Configure pages:', 'psjb' ); ?></strong> 
						<a href="<?php echo admin_url( 'admin.php?page=je-jobboard-settings&tab=pages' ); ?>">
							<?php _e( 'Set up your job and expert listing pages', 'psjb' ); ?>
						</a>
					</li>
					<li>
						<strong><?php _e( '2. Configure email:', 'psjb' ); ?></strong> 
						<a href="<?php echo admin_url( 'admin.php?page=je-jobboard-settings&tab=email' ); ?>">
							<?php _e( 'Customize notification emails', 'psjb' ); ?>
						</a>
					</li>
					<li>
						<strong><?php _e( '3. Create first job:', 'psjb' ); ?></strong> 
						<a href="<?php echo admin_url( 'post-new.php?post_type=jbp_job' ); ?>">
							<?php _e( 'Post a new job', 'psjb' ); ?>
						</a>
					</li>
					<li>
						<strong><?php _e( '4. Add experts:', 'psjb' ); ?></strong> 
						<a href="<?php echo admin_url( 'edit.php?post_type=jbp_pro' ); ?>">
							<?php _e( 'Register new experts', 'psjb' ); ?>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>

