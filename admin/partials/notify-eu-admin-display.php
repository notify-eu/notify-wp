<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://notify.eu
 * @since      1.0.0
 *
 * @package    Notify
 * @subpackage Notify/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
	<span class="alignright">
		<a target="_blank" href="https://notify.eu/">
			<img src="<?php echo plugin_dir_url( __FILE__ ) . '../images/notify.svg'; ?>" alt="Notify" style="width:10em;"/>
		</a>
	</span>
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
	<p>
		<?php
		$url  = 'https://notify.eu';
		$link = sprintf(
			wp_kses(
				__( 'A <a href="%1$s" target="%2$s">Notify</a> account is required to use this plugin and the Notify service.', $this->plugin_name ),
				array(
					'a' => array(
						'href'   => array(),
						'target' => array(),
					),
				)
			),
			esc_url( $url ),
			'_blank'
		);
		echo $link;
		?>
	</p>

	<p>
		<?php
		$url  = 'https://app.notify.eu/register';
		$link = sprintf(
			wp_kses(
				__( 'If you need to register for an account, you can do so at <a href="%1$s" target="%2$s">Notify.eu</a>.', $this->plugin_name ),
				array(
					'a' => array(
						'href'   => array(),
						'target' => array(),
					),
				)
			),
			esc_url( $url ),
			'_blank'
		);
		echo $link;
		?>
	</p>
	<form action="options.php" method="post">
		<?php
		settings_fields( $this->plugin_name );
		do_settings_sections( $this->plugin_name );
		submit_button();
		?>
	</form>
</div>
