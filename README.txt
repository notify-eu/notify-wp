=== Notify-eu ===
Tags: notify, notifications, aranealabs
Tested up to: 5.4
Requires PHP: 5.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Notify, a new messaging and notification platform for a user friendly and faster communication in B2B & B2C

== Description ==

Notify, a new messaging and notification platform for a user friendly and faster communication in B2B & B2C.
Create, send and manage all your messages you send to your recipients with one simple API. The Notify platform makes it possible to use many underlying message services & types via one simple API, which saves a considerable amount of time in terms of integration, development and central management of content and reporting. Work better, faster, smarter!

A Notify (https://notify.eu) account is required to make use of this plugin and the Notify service.
Please register at https://app.notify.eu/register to make an account.

Notify Privacy policy: https://notify.eu/privacy-policy/

== Installation ==

1. Upload the plugin to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Visit the settings page in the Admin at Settings -> Notify and configure the plugin with your account details
4. Place `<?php do_action( 'notify_send'); ?>` in your templates
5. Action notify_send takes 5 arguments:
    - template (mandatory)
    - recipients ('to' field is mandatory)
    - language (f.e. nl / fr / en)
    - transport (f.e. SMTP)
    - params (extra array of params you want to use in template)

6. Example: do_action( 'notify_send', 'welcomeTemplate', array('to' => array(array('name' => 'John Doe', 'email' => 'john@acme.com')), 'cc' => array(array('name' => 'John Doe', 'email' => 'john@acme.com'))), 'nl', 'SMTP', array('username' => 'John'));
7. When an error occurs or some param is missing, an entry will be inserted in debug.log when WP_DEBUG_LOG: true

== Screenshots ==

1. The Notify configuration screen used on the WordPress backend.