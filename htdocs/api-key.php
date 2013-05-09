<?php

/**
 * The API key registration page.
 *
 * PHP version 5
 *
 * @author		Waldo Jaquith <waldo at jaquith.org>
 * @copyright	2010-2012 Waldo Jaquith
 * @license		http://www.gnu.org/licenses/gpl.html GPL 3
 * @version		0.6
 * @link		http://www.statedecoded.com/
 * @since		0.6
*/

/*
 * Include the PHP declarations that drive this page.
 */
require '../includes/page-head.inc.php';

/*
 * Fire up our templating engine.
 */
$template = new Page;

/*
 * Define some page elements.
 */
$template->field->browser_title = 'Register for an API Key';
$template->field->page_title = 'Register for an API Key';

/*
 * Provide some custom CSS for this form.
 */
$template->field->inline_css = '
	<style>
		#required-note {
			font-size: .85em;
			margin-top: 2em;
		}
		.required {
			color: #f00;
		}
		#api-registration label {
			display: block;
			margin-top: 1em;
		}
		#api-registration input[type=text] {
			width: 35em;
		}
		#api-registration input[type=submit] {
			display: block;
			clear: left;
			margin-top: 1em;
		}
	</style>';

/*
 * Create an instance of the API class.
 */
$api = new API();

/*
 * Define the sidebar.
 */
$sidebar = '
	<section>
		<h1>Nota Bene</h1>
		<p>'.SITE_TITLE.' is not your database. Cache accordingly.</p>
		
		<p>Consider whether <a href="/downloads/">a bulk download</a> might be more appropriate
		for your purposes.</p>
	</section>';

/*
 * If the form on this page is being submitted, process the submitted data.
 */
if (isset($_POST['form_data']))
{

	/*
	 * Pass the submitted form data to the API class, as an object rather than as an array.
	 */
	$api->form = (object) $_POST['form_data'];
	
	/*
	 * If this form hasn't been completed properly, display the errors and re-display the form.
	 */
	if ($api->validate_form() === false)
	{
		$body .= '<p class="error">Error: '.$api->form_errors.'</p>';
		$body .= $api->display_form();
	}
	
	/*
	 * But if the form has been filled out correctly, then proceed with the registration process.
	 */
	else
	{
		
		/*
		 * Register this key.
		 */
		try
		{
			$api->register_key();
		}
		catch (Exception $e)
		{
			$body = '<p class="error">Error: ' . $e->getMessage() . '</p>';
		}
		
		$body .= '<p>You have been sent an e-mail to verify your e-mail address. Please click the
					link in that e-mail to activate your API key.</p>';
	}
	
}

/*
 *
 */
elseif (isset($_GET['secret']))
{
	/*
	 * If this isn't a five-character string, bail -- something's not right.
	 */
	if (strlen($_GET['secret']) != 5)
	{
		$body .= '<h2>Error</h2>
			<p>Invalid API key.</p>';
	}
	else
	{
		$api->secret = $_GET['secret'];
		$api->activate_key();
		$body .= '<h2>API Key Activated</h2>
				
				<p>Your API key has been activated. You may now make requests from the API. Your
				key is:</p>
				
				<p><code>'.$api->key.'</code></p>';
	}
}

/* If this page is being loaded normally (that is, without submitting data), then display the registration
 * form.
 */
else
{
	$body = $api->display_form();
}

/*
 * Put the shorthand $body variable into its proper place.
 */
$template->field->body = $body;
unset($body);

/**
 * 	Add social share to sidebar
 */	
$sidebar .= '
<section>
<h1>Tell Your Friends</h1>
<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style ">
<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
<a class="addthis_button_tweet"></a>
<a class="addthis_button_pinterest_pinit"></a>
<a class="addthis_counter addthis_pill_style"></a>
</div>
<script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-518a87af289b1ef3"></script>
<!-- AddThis Button END -->
</section>
';

/*
 * Put the shorthand $sidebar variable into its proper place.
 */
$template->field->sidebar = $sidebar;
unset($sidebar);

/*
 * Parse the template, which is a shortcut for a few steps that culminate in sending the content to
 * the browser.
 */
$template->parse();
