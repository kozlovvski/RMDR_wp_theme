<?php

/**
 * Set up a WP-Admin page for managing turning on and off theme features.
 */
function gutenberg_starter_theme_add_options_page()
{
	add_theme_page(
		'Theme Options',
		'Theme Options',
		'manage_options',
		'rmdr_wp_theme-options',
		'gutenberg_starter_theme_options_page'
	);

	// Call register settings function
	add_action('admin_init', 'gutenberg_starter_theme_options');
}
add_action('admin_menu', 'gutenberg_starter_theme_add_options_page');


/**
 * Register settings for the WP-Admin page.
 */
function gutenberg_starter_theme_options()
{
	register_setting('rmdr_wp_theme-options', 'rmdr_wp_theme-align-wide', array('default' => 1));
	register_setting('rmdr_wp_theme-options', 'rmdr_wp_theme-wp-block-styles', array('default' => 1));
	register_setting('rmdr_wp_theme-options', 'rmdr_wp_theme-editor-color-palette', array('default' => 1));
	register_setting('rmdr_wp_theme-options', 'rmdr_wp_theme-dark-mode');
	register_setting('rmdr_wp_theme-options', 'rmdr_wp_theme-responsive-embeds', array('default' => 1));
}


/**
 * Build the WP-Admin settings page.
 */
function gutenberg_starter_theme_options_page()
{ ?>
	<div class="wrap">
		<h1><?php _e('Gutenberg Starter Theme Options', 'rmdr_wp_theme'); ?></h1>
		<form method="post" action="options.php">
			<?php settings_fields('rmdr_wp_theme-options'); ?>
			<?php do_settings_sections('rmdr_wp_theme-options'); ?>

			<table class="form-table">
				<tr valign="top">
					<td>
						<label>
							<input name="rmdr_wp_theme-align-wide" type="checkbox" value="1" <?php checked('1', get_option('rmdr_wp_theme-align-wide')); ?> />
							<?php _e('Enable wide and full alignments.', 'rmdr_wp_theme'); ?>
							(<a href="https://developer.wordpress.org/block-editor/developers/themes/theme-support/#wide-alignment"><code>align-wide</code></a>)
						</label>
					</td>
				</tr>
				<tr valign="top">
					<td>
						<label>
							<input name="rmdr_wp_theme-editor-color-palette" type="checkbox" value="1" <?php checked('1', get_option('rmdr_wp_theme-editor-color-palette')); ?> />
							<?php _e('Enable a custom theme color palette.', 'rmdr_wp_theme'); ?>
							(<a href="https://developer.wordpress.org/block-editor/developers/themes/theme-support/#block-color-palettes"><code>editor-color-palette</code></a>)
						</label>
					</td>
				</tr>
				<tr valign="top">
					<td>
						<label>
							<input name="rmdr_wp_theme-wp-block-styles" type="checkbox" value="1" <?php checked('1', get_option('rmdr_wp_theme-wp-block-styles')); ?> />
							<?php _e('Enable core block styles on the front end.', 'rmdr_wp_theme'); ?>
							(<a href="https://developer.wordpress.org/block-editor/developers/themes/theme-support/#default-block-styles"><code>wp-block-styles</code></a>)
						</label>
					</td>
				</tr>
				<tr valign="top">
					<td>
						<label>
							<input name="rmdr_wp_theme-responsive-embeds" type="checkbox" value="1" <?php checked('1', get_option('rmdr_wp_theme-responsive-embeds')); ?> />
							<?php _e('Enable responsive embedded content.', 'rmdr_wp_theme'); ?>
							(<a href="https://developer.wordpress.org/block-editor/developers/themes/theme-support/#responsive-embedded-content"><code>responsive-embeds</code></a>)
						</label>
					</td>
				</tr>
			</table>

			<?php submit_button(); ?>
		</form>
	</div>
<?php }


/**
 * Enable alignwide and alignfull support if the rmdr_wp_theme-align-wide setting is active.
 */
function gutenberg_starter_theme_enable_align_wide()
{

	if (get_option('rmdr_wp_theme-align-wide', 1) == 1) {

		// Add support for full and wide align images.
		add_theme_support('align-wide');
	}
}
add_action('after_setup_theme', 'gutenberg_starter_theme_enable_align_wide');


/**
 * Enable custom theme colors if the rmdr_wp_theme-editor-color-palette setting is active.
 */
function gutenberg_starter_theme_enable_editor_color_palette()
{
	if (get_option('rmdr_wp_theme-editor-color-palette', 1) == 1) {

		// Add support for a custom color scheme.
		add_theme_support('editor-color-palette', array(
			array(
				'name'  => __('RMDR Blue', 'rmdr_wp_theme'),
				'slug'  => 'rmdr-blue',
				'color' => '#00007f',
			),
			array(
				'name'  => __('RMDR Green', 'rmdr_wp_theme'),
				'slug'  => 'rmdr-green',
				'color' => '#008001',
			),
			array(
				'name'  => __('RMDR Light Gray', 'rmdr_wp_theme'),
				'slug'  => 'rmdr-light-gray',
				'color' => '#f2f2f2',
			),
			array(
				'name'  => __('RMDR Dark Gray', 'rmdr_wp_theme'),
				'slug'  => 'rmdr-dark-gray',
				'color' => '#3f3f3f',
			),
		));
	}
}
add_action('after_setup_theme', 'gutenberg_starter_theme_enable_editor_color_palette');


add_theme_support('editor-styles');
add_editor_style('style-editor.css');



/**
 * Enable dark mode on the front end if rmdr_wp_theme-dark-mode setting is active.
 */
function gutenberg_starter_theme_enable_dark_mode_frontend_styles()
{
	if (get_option('rmdr_wp_theme-dark-mode') == 1) {
		wp_enqueue_style('rmdr_wp_themedark-style', get_template_directory_uri() . '/css/dark-mode.css');
	}
}
add_action('wp_enqueue_scripts', 'gutenberg_starter_theme_enable_dark_mode_frontend_styles');

/**
 * Enable core block styles support if the rmdr_wp_theme-wp-block-styles setting is active.
 */
function gutenberg_starter_theme_enable_wp_block_styles()
{

	if (get_option('rmdr_wp_theme-wp-block-styles', 1) == 1) {

		// Adding support for core block visual styles.
		add_theme_support('wp-block-styles');
	}
}
add_action('after_setup_theme', 'gutenberg_starter_theme_enable_wp_block_styles');


/**
 * Enable responsive embedded content if the rmdr_wp_theme-responsive-embeds setting is active.
 */
function gutenberg_starter_theme_enable_responsive_embeds()
{

	if (get_option('rmdr_wp_theme-responsive-embeds', 1) == 1) {

		// Adding support for responsive embedded content.
		add_theme_support('responsive-embeds');
	}
}
add_action('after_setup_theme', 'gutenberg_starter_theme_enable_responsive_embeds');
