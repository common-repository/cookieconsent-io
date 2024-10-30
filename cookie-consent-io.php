<?php
/**
 * Plugin Name: CookieConsent.io
 * Plugin URI: https://www.cookieconsent.io
 * Description: Wordpress plugin for easy integration of the CookieConsent.io cookie consent.
 * Version: 1.0
 * Author: Abovo Media
 **/

/**
 * Render CookieConsent.io description
 *
 * @return string
 */
function render_cookie_consent_io_description() {

    $html = '<div><script id="cookie-consent-io-cookie-data-inline-info">
  
    function showCookieInfo(scriptElement, cookieConsent) {
        scriptElement.parentNode.appendChild(cookieConsent.getCookieInformation());
    }

    var scriptElement = document.getElementById(\'cookie-consent-io-cookie-data-inline-info\');
    if(typeof window.cookieConsent === \'undefined\') {
       document.addEventListener(\'CookieConsentInitialize\', function(event) {
          showCookieInfo(scriptElement, window.cookieConsent);
       });
    }
    else {
         showCookieInfo(scriptElement, window.cookieConsent); 
    }
   </script></div>';

    return apply_filters('render_cookie_consent_io_description', $html);
}

/**
 * Render CookieConsent.io cookie table
 *
 * @return string
 */
function render_cookie_consent_io_cookie_table() {

    $html = '<div><script id="cookie-consent-io-cookie-data-inline-table">
     
       function showCookieTable(scriptElement, cookieConsent) {
           scriptElement.parentNode.appendChild(cookieConsent.getCookieTable());
       }
  
       var scriptElement = document.getElementById(\'cookie-consent-io-cookie-data-inline-table\');
       if(typeof window.cookieConsent === \'undefined\') {
       
           document.addEventListener(\'CookieConsentInitialize\', function(event) {
                showCookieTable(scriptElement, window.cookieConsent);
            });
       }
       else {
          showCookieTable(scriptElement, window.cookieConsent);
      }

   </script></div>';

    return apply_filters('render_cookie_consent_io_table', $html);
}

/**
 * Render CookieConsent.io settings link
 *
 * @param array $attributes
 * @param string $content
 * @return string
 */
function render_cookie_consent_io_settings($attributes, $content) {
    $type = 'link';
    extract(shortcode_atts(array('type' => 'link'), $attributes));

    if($type == 'button') {
        $html = '<button onclick="cookieConsent.showCookieConsentSettings();">' .   do_shortcode($content) . '</button>';
    } else {
        $html = '<a href="javascript:cookieConsent.showCookieConsentSettings();">' .   do_shortcode($content) . '</a>';
    }

    return apply_filters('render_cookie_consent_io_settings', $html, $type);
}

/**
 * CookieConsent.io settings page
 */
function cookie_consent_io_settings_page()
{
    add_management_page(
        'options-general.php',
        'CookieConsent.io',
        'manage_options',
        'cookie-consent-io-settings',
        'cookie_consent_io_settings_example_html'
    );
}

/**
 * Show CookieConsent.io short code examples
 */
function cookie_consent_io_settings_example_html() {

    if (!current_user_can('manage_options')) {
        return;
    }

    $logo =  plugin_dir_url(dirname(__FILE__) . '/images/cookie-consent-io-logo.png') . 'cookie-consent-io-logo.png';

    ?>

<div class="wrap">

    <a href="https://cookieconsent.io" target="_blank"><img src="<?php echo $logo; ?>" width="334" height="140" alt="CookieConsent.io" /></a>

    <p>We truly appreciate your business and are grateful for the trust you have placed in CookieConsent.io.
    We were privileged to have the opportunity to serve you by managing the online privacy of your clients,
    and we greatly value your business.</p>
    <p>This guide provides instructions on how to use the CookieConsent.io WordPress plugin. Please make sure
    you have installed the Google Tag Manager tag provided by the CookieConsent.io Sales representative. A detailed
    guide on how to install and configure CookieConsent.io is available on our
    <a href="https://cookieconsent.io" target="_blank">website</a>.
    </p>
    <p>After installing the WordPress plugin and the Google Tag Manager tag you can insert shortcodes for the
    injection of the legal text, cookie summary table and settings link.</p>

    <h3>Show legal text</h3>
    <input type="text" id="cookie-consent-io-description" value="[cookie-consent-io-description]" />
    <button onclick="copyText('cookie-consent-io-description')">Copy</button>

    <h3>Show discovered cookie table</h3>
    <input type="text" id="cookie-consent-io-table" value="[cookie-consent-io-table]" />
    <button onclick="copyText('cookie-consent-io-table')">Copy</button>

    <h3>Show cookie settings (link)</h3>
    <input type="text" id="cookie-consent-io-settings-link" value='[cookie-consent-io-settings type="link"]Show CookieConsent.io settings[/cookie-consent-io-settings]' />
    <button onclick="copyText('cookie-consent-io-settings-link')">Copy</button>

    <h3>Show cookie settings (button)</h3>
    <input type="text" id="cookie-consent-io-settings-button" value='[cookie-consent-io-settings type="button"]Show CookieConsent.io settings[/cookie-consent-io-settings]' />
    <button onclick="copyText('cookie-consent-io-settings-button')">Copy</button>

    <h3>Filters</h3>
    <p>The following filters are available:</p>

    <ul>
        <li>- render_cookie_consent_io_description</li>
        <li>- render_cookie_consent_io_table</li>
        <li>- render_cookie_consent_io_settings</li>
    </ul>

    <h3>Support</h3>
    <p>Need help? Connect with us and we will gladly assist you. Please send an e-mail to <a href="mailto:support@cookieconsent.io">support@cookieconsent.io</a>.</p>

    <p></p>

    <script type="text/javascript">
        function copyText(id) {
            var copyText = document.getElementById(id);
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            document.execCommand("copy");
        }
    </script>

</div>
    <?php
}

add_shortcode('cookie-consent-io-description', 'render_cookie_consent_io_description');
add_shortcode('cookie-consent-io-table', 'render_cookie_consent_io_cookie_table');
add_shortcode('cookie-consent-io-settings', 'render_cookie_consent_io_settings');

add_action('admin_menu', 'cookie_consent_io_settings_page');
