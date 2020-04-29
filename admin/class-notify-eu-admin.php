<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://notify.eu
 * @since      1.0.0
 *
 * @package    Notify-eu
 * @subpackage Notify-eu/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Notify-eu
 * @subpackage Notify-eu/admin
 * @author     Notify <info@notify.eu>
 */
class Notify_Eu_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The options name to be used in this plugin
	 *
	 * @since    1.0.0
	 * @access    private
	 * @var    string $option_name Option name of this plugin
	 */
	private $option_name = 'notify_eu';

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version The version of this plugin.
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Notify_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Notify_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style(
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'css/notify-eu-admin.css',
			array(),
			$this->version,
			'all'
		);

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Notify_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Notify_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		/*wp_enqueue_script(
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'js/notify-eu-admin.js',
			array( 'jquery' ),
			$this->version,
			false
		);*/

	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */

	public function add_plugin_admin_menu() {

		/*
		 * Add a settings page for this plugin to the Settings menu.
		 *
		 * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
		 *
		 *        Administration Menus: http://codex.wordpress.org/Administration_Menus
		 *
		 */
		add_options_page(
			'Notify Setup',
			'Notify',
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_plugin_setup_page' )
		);
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */

	public function add_action_links( $links ) {
		/*
		*  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
		*/
		$settings_link = array(
			'<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __(
				'Settings',
				$this->plugin_name
			) . '</a>',
		);

		return array_merge( $settings_link, $links );

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */

	public function display_plugin_setup_page() {
		include_once 'partials/notify-eu-admin-display.php';
	}

	/**
	 * Register all related settings of this plugin
	 *
	 * @since  1.0.0
	 */
	public function register_setting() {

		add_settings_section(
			$this->option_name . '_general',
			__( 'Configuration', $this->plugin_name ),
			array( $this, $this->option_name . '_general_cb' ),
			$this->plugin_name
		);

		add_settings_field(
			$this->option_name . '_client',
			__( 'Client ID *', $this->plugin_name ),
			array( $this, $this->option_name . '_client_text' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_client' )
		);

		add_settings_field(
			$this->option_name . '_secret',
			__( 'Secret key *', $this->plugin_name ),
			array( $this, $this->option_name . '_secret_text' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_secret' )
		);

		add_settings_field(
			$this->option_name . '_transport',
			__( 'Transport', $this->plugin_name ),
			array( $this, $this->option_name . '_transport_text' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_transport' )
		);

		add_settings_field(
			$this->option_name . '_language',
			__( 'Language', $this->plugin_name ),
			array( $this, $this->option_name . '_language_text' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_language' )
		);

		add_settings_field(
			$this->option_name . '_endpoint',
			__( 'Notify endpoint', $this->plugin_name ),
			array( $this, $this->option_name . '_endpoint_text' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_endpoint' )
		);

		add_settings_field(
			$this->option_name . '_to_name',
			__( 'To Name', $this->plugin_name ),
			array( $this, $this->option_name . '_to_name_text' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_to_name' )
		);

		add_settings_field(
			$this->option_name . '_to_email',
			__( 'To Email', $this->plugin_name ),
			array( $this, $this->option_name . '_to_email_text' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_to_email' )
		);

		add_settings_field(
			$this->option_name . '_override',
			__( 'Override "To" Details', $this->plugin_name ),
			array( $this, $this->option_name . '_override_select' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_override' )
		);
		register_setting( $this->plugin_name, $this->option_name, array( $this, 'validate' ) );
	}

	/**
	 * Render the text for the general section
	 *
	 * @since  1.0.0
	 */
	public function notify_eu_general_cb() {

	}

	/**
	 * Render the endpoint field
	 *
	 * @since  1.0.0
	 */
	public function notify_eu_endpoint_text() {
		$options = get_option( $this->option_name );
		echo '<input type="text" name="' . $this->option_name . '[endpoint]" id="' . $this->option_name . '_endpoint' . '" value="' . ( isset( $options['endpoint'] ) ? esc_attr( $options['endpoint'] ) : '' ) . '"> '
		?>
		<p class="description">
			<?php
			_e(
				'Can be used when you want to overwrite the endpoint Notify is calling. (f.e. different url for Staging/production).<br/> If you leave this field empty, the plugin will call Notify production endpoint.',
                $this->plugin_name
			);
			?>
		</p>
		<?php
	}

	/**
	 * Render the client field
	 *
	 * @since  1.0.0
	 */
	public function notify_eu_client_text() {
		$options = get_option( $this->option_name );
		echo '<input type="text" name="' . $this->option_name . '[client]" id="' . $this->option_name . '_client' . '" value="' . ( isset( $options['client'] ) ? esc_attr( $options['client'] ) : '' ) . '"> '
		?>
		<p class="description">
			<?php
			_e( 'Can be found in your Notify Settings page -> Credentials', $this->plugin_name );
			?>
		</p>
		<?php
	}

	/**
	 * Render the secret field
	 *
	 * @since  1.0.0
	 */
	public function notify_eu_secret_text() {
		$options = get_option( $this->option_name );
		echo '<input type="text" name="' . $this->option_name . '[secret]" id="' . $this->option_name . '_secret' . '" value="' . ( isset( $options['secret'] ) ? esc_attr( $options['secret'] ) : '' ) . '"> '
		?>
		<p class="description">
			<?php
			_e( 'Can be found in your Notify Settings page -> Credentials', $this->plugin_name );
			?>
		</p>
		<?php
	}


	/**
	 * Render the transport field
	 *
	 * @since  1.0.0
	 */
	public function notify_eu_transport_text() {
		$options = get_option( $this->option_name );
		echo '<input type="text" name="' . $this->option_name . '[transport]" placeholder="SMTP" id="' . $this->option_name . '_transport' . '" value="' . ( isset( $options['transport'] ) ? esc_attr( $options['transport'] ) : '' ) . '"> '
		?>
		<p class="description">
			<?php
			_e( 'Can be used to send notifications to a default transport', $this->plugin_name );
			?>
		</p>
		<?php
	}

	/**
	 * Render the language field
	 *
	 * @since  1.0.0
	 */
	public function notify_eu_language_text() {
		$options = get_option( $this->option_name );
		echo '<input type="text" name="' . $this->option_name . '[language]" placeholder="nl" id="' . $this->option_name . '_language' . '" value="' . ( isset( $options['language'] ) ? esc_attr( $options['language'] ) : '' ) . '"> '
		?>
		<p class="description">
			<?php
			_e( 'Can be used to send notifications in a default language', $this->plugin_name );
			?>
		</p>
		<?php
	}

	/**
	 * Render the from name field
	 *
	 * @since  1.0.0
	 */
	public function notify_eu_to_name_text() {
		$options = get_option( $this->option_name );
		echo '<input type="text" name="' . $this->option_name . '[to_name]" placeholder="John Doe" id="' . $this->option_name . '_to_name' . '" value="' . ( isset( $options['to_name'] ) ? esc_attr( $options['to_name'] ) : '' ) . '"> '
		?>
		<p class="description">
			<?php
			_e( 'Can be used to send notifications to a default email address', $this->plugin_name );
			?>
		</p>
		<?php
	}

	/**
	 * Render the from email field
	 *
	 * @since  1.0.0
	 */
	public function notify_eu_to_email_text() {
		$options = get_option( $this->option_name );
		echo '<input type="text" name="' . $this->option_name . '[to_email]" placeholder="wordpress@mydomain.com" id="' . $this->option_name . '_to_email' . '" value="' . ( isset( $options['to_email'] ) ? esc_attr( $options['to_email'] ) : '' ) . '"> '
		?>
		<p class="description">
			<?php
			_e( 'Can be used to send notifications to a default email address', $this->plugin_name );
			?>
		</p>
		<?php
	}

	/**
	 * Render the override select field
	 *
	 * @since  1.0.0
	 */
	public function notify_eu_override_select() {
		$options = get_option( $this->option_name );
		?>
		<select name="<?php echo $this->option_name . '[override]'; ?>">
			<option value="0"
			<?php
			selected(
				'0',
				( isset( $options['override'] ) ? $options['override'] : '' )
			)
			?>
				><?php _e( 'No', $this->plugin_name ); ?></option>
			<option value="1"
			<?php
			selected(
				'1',
				( isset( $options['override'] ) ? $options['override'] : '' )
			)
			?>
				><?php _e( 'Yes', $this->plugin_name ); ?></option>
		</select>
		<p class="description">
			<?php
			_e(
				'If enabled, all notifications will be sent to the above "To Name" and "To Address", regardless of values set by your code.',
                $this->plugin_name
			);
			?>
		</p>
		<?php
	}

	/**
	 * Sanitize fields before being saved to database
	 *
	 * @return array
	 * @since  1.0.0
	 */
	public function validate( $input ) {
		$options = get_option( $this->option_name );
		if ( isset( $input['endpoint'] ) && ! empty( $input['endpoint'] ) ) {
			$validated = sanitize_text_field( $input['endpoint'] );
			if ( $validated !== $input['endpoint'] ) {
				$errors[] = __( 'Endpoint was invalid', $this->plugin_name );
			}
		}

		if ( isset( $input['client'] ) && ! empty( $input['client'] ) ) {
			$validated = sanitize_text_field( $input['client'] );
			if ( $validated !== $input['client'] ) {
				$errors[] = __( 'Client ID was invalid', $this->plugin_name );
			}
		}

		if ( isset( $input['secret'] ) && ! empty( $input['secret'] ) ) {
			$validated = sanitize_text_field( $input['secret'] );
			if ( $validated !== $input['secret'] ) {
				$errors[] = __( 'Secret key was invalid', $this->plugin_name );
			}
		}

		if ( isset( $input['transport'] ) && ! empty( $input['transport'] ) ) {
			$validated = sanitize_text_field( $input['transport'] );
			if ( $validated !== $input['transport'] ) {
				$errors[] = __( 'Transport was invalid', $this->plugin_name );
			}
		}

		if ( isset( $input['language'] ) && ! empty( $input['language'] ) ) {
			$validated = sanitize_text_field( $input['language'] );
			if ( $validated !== $input['language'] ) {
				$errors[] = __( 'Language was invalid', $this->plugin_name );
			}
		}

		if ( isset( $input['to_email'] ) && ! empty( $input['to_email'] ) ) {
			$validated = sanitize_email( $input['to_email'] );
			if ( $validated !== $input['to_email'] ) {
				$errors[] = __( 'To email was invalid', $this->plugin_name );
			}
		}

		if ( isset( $input['to_name'] ) && ! empty( $input['to_name'] ) ) {
			$validated = sanitize_text_field( $input['to_name'] );
			if ( $validated !== $input['to_name'] ) {
				$errors[] = __( 'To name was invalid', $this->plugin_name );
			}
		}

		if ( isset( $errors ) && ! empty( $errors ) ) {
			foreach ( $errors as $key => $error ) {
				add_settings_error( $this->plugin_name, 'notify-updated-fail', $error, 'error' );
			}

			return $options;
		}

		return $input;
	}

}
