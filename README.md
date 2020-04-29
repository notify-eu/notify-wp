# Notify WordPress Plugin


The Notify WordPress Plugin allows you to send SMS, mail and push notifications from one integrated platform. The Notify platform makes it possible to use many underlying message services & types via one simple API, which saves a considerable amount of time in terms of integration, development and central management of content and reporting. Work better, faster, smarter!

A <a href="https://notify.eu">Notify</a> account is required to make use of this plugin and the Notify service.
Please register at https://app.notify.eu/register to make an account.

<a href="https://notify.eu/privacy-policy/">Notify Privacy policy</a>

## How to Install

### From the WordPress Plugin Directory

The Official Notify WordPress Plugin can be found here: https://wordpress.org/plugins/notify/

### From this repository

Go to the [releases](https://github.com/notify-eu/notify-wp/releases) section of the repository and download the most recent release.

Then, from your WordPress administration panel, go to `Plugins > Add New` and click the `Upload Plugin` button at the top of the page.

## How to Use

From your WordPress administration panel go to `Plugins > Installed Plugins` and scroll down until you find `Notify`. You will need to activate it first, then click on `Settings` to configure it.

### Configuration

#### Client ID

You will need a client ID which you can obtain from you settings in Notify dashboard

#### Secret

You will need a secret key which you can obtain from you settings in Notify dashboard

#### Transport

Can be used to send notifications to a default transport

#### Language	

Can be used to send notifications in a default language

#### Endpoint	

Can be used when you want to overwrite the endpoint Notify is calling. (f.e. different url for Staging/production).
If you leave this field empty, the plugin will call Notify production endpoint.

#### To Name	

Can be used to send notifications to a default email address (name)

#### To Email	

Can be used to send notifications to a default email address

#### Override "To" Details	

If enabled, all notifications will be sent to the above "To Name" and "To Address", regardless of values set by your code.

### Usage

do_action( 'notify_send', 'welcomeTemplate', array('to' => array(array('name' => 'John Doe', 'email' => 'john@acme.com')), 'cc' => array(array('name' => 'John Doe', 'email' => 'john@acme.com'))), 'nl', 'SMTP', array('username' => 'John'));

- Action notify_send takes 5 arguments:
    - template (mandatory)
    - recipients ('to' field is mandatory)
    - language (f.e. nl / fr / en)
    - transport (f.e. SMTP)
    - params (extra array of params you want to use in template)
    
When an error occurs or some param is missing, an entry will be inserted in debug.log when WP_DEBUG_LOG: true
