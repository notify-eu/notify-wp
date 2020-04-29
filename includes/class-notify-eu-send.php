<?php
/**
 * The file that defines the send plugin class
 *
 * @link       https://notify.eu
 * @since      1.0.0
 *
 * @package    Notify-eu
 * @subpackage Notify-eu/includes
 */

/**
 * The send plugin class.
 *
 * @since      1.0.0
 * @package    Notify-eu
 * @subpackage Notify-eu/includes
 * @author     Notify <info@notify.eu>
 */
class Notify_Eu_Send {

	/**
	 * The ID of this plugin.
	 *
	 * @since        1.0.0
	 * @access        private
	 * @var        string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since        1.0.0
	 * @access        private
	 * @var        string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version The version of this plugin.
	 * @since        1.0.0
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Endpoint url of the Notify service
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $endpoint_url
	 */
	private $endpoint_url;

	/**
	 * Notify message object
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      Notify_Eu_Message    $message
	 */
	private $message;

    /**
     * The options name to be used in this plugin
     *
     * @since    1.0.0
     * @access    private
     * @var    string $option_name Option name of this plugin
     */
    private $option_name = 'notify_eu';


	/**
	 * Production API endpoint Notify service
	 *
	 * @since    1.0.0
	 * @access   const
	 * @var      string    API_ENDPOINT
	 */
	const API_ENDPOINT = 'https://api.notify.eu/notification/send';

	/**
	 * Sends notification to Notify service
	 *
	 * @param string $template
	 * @param array  $recipients
	 * @param string $language
	 * @param string $transport
	 * @param array  $params
	 * @return bool|mixed|WP_Error
	 */
	public function send_notification( $template, $recipients, $language = '', $transport = '', $params = null ) {
		// Compact the input, apply the filters, and extract them back out
		$options = get_option( $this->option_name );

		if ( ! $options ) {
			return new WP_Error( $this->plugin_name, 'missing notify options' );
		}

		$this->message = new Notify_Eu_Message();
		$this->message->setClientId( $options['client'] );
		$this->message->setSecret( $options['secret'] );
		$this->message->setTransport( $options['transport'] );
		$this->message->setLanguage( isset( $language ) ? $language : $options['language'] );
		$this->message->setNotificationType( $template );

		if ( $transport ) {
			$this->message->setTransport( $transport );
		}
		if ( $language ) {
			$this->message->setLanguage( $language );
		}
		if ( is_array( $params ) && ! empty( $params ) ) {
			$this->message->setParams( $params );
		}

		if ( isset( $options['override'] ) && $options['override'] == 1 && !empty($options['to_email'])) {
			$this->message->addRecipient( $options['to_name'], $options['to_email'] );
		} elseif ( is_array( $recipients ) && ! empty( $recipients ) ) {
			if ( isset( $recipients['to'] ) ) {
				foreach ( $recipients['to'] as $recipient ) {
					$this->message->addRecipient( $recipient['name'], $recipient['email'] );
				}
			}

			if ( isset( $recipients['cc'] ) ) {
				foreach ( $recipients['cc'] as $recipient ) {
					$this->message->addCc( $recipient['name'], $recipient['email'] );
				}
			}

			if ( isset( $recipients['bcc'] ) ) {
				foreach ( $recipients['bcc'] as $recipient ) {
					$this->message->addBcc( $recipient['name'], $recipient['email'] );
				}
			}
		}

        $validation = $this->validate_message();
		if ( is_wp_error( $validation ) ) {
			$this->log_error( $validation );
			return false;
		}

		$this->endpoint_url = isset( $options['endpoint'] ) && ! empty( $options['endpoint'] ) ? $options['endpoint'] : self::API_ENDPOINT;
		$response           = wp_remote_post(
			$this->endpoint_url,
			array(
				'body' => wp_json_encode( $this->message ),
			)
		);

		if ( is_wp_error( $response ) ) {
			$this->log_error( $response );
			return false;
		}

		$response_code = wp_remote_retrieve_response_code( $response );
		$response_body = json_decode( wp_remote_retrieve_body( $response ) );

		// Notify API should * always * return a `success` field, even when
		// $response_code != 200, so a lack of `success` indicates something
		// is broken.
		if ( (int) $response_code !== 200 && ! isset( $response_body->success ) ) {
			// Store response code and HTTP response message in last error.
			$response_message = wp_remote_retrieve_response_message( $response );
			$errmsg           = "$response_code - $response_message";
			$error            = new WP_Error( $this->plugin_name, $errmsg );
			$this->log_error( $error );
			return false;
		}

		return $response_body;
	}

	/**
	 * @param Wp_Error $error
	 */
	private function log_error( $error ) {
		$message = $error->get_error_message();
		$code    = $error->get_error_code();
		error_log( $code . ': ' . $message );
	}

	/**
	 * Validates the Notify message
	 *
	 * @return bool|WP_Error
	 */
	private function validate_message() {
		$error = new WP_Error();
		if ( empty( $this->message->getClientId() ) || empty( $this->message->getSecret() ) ) {
			$error->add( $this->plugin_name, 'missing clientId/secretKey' );
		}
		if ( empty( $this->message->getNotificationType() ) ) {
			$error->add( $this->plugin_name, 'missing template' );
		}
		if ( empty( $this->message->getTransport() ) ) {
			$error->add( $this->plugin_name, 'missing transport' );
		}
		if ( empty( $this->message->getLanguage() ) ) {
			$error->add( $this->plugin_name, 'missing language' );
		}
		if ( empty( $this->message->getTo() ) ) {
			$error->add( $this->plugin_name, 'missing recipient' );
		}

		if ( $error->has_errors() ) {
			return $error;
		}

		return true;
	}
}
