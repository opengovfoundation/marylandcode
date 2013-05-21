<?php

/**
 * The site home page.
 *
 * Displays a list of the top-level structural units. May be customized to display introductory
 * text, sidebar content, etc.
 * 
 * PHP version 5
 *
 * @author		Waldo Jaquith <waldo at jaquith.org>
 * @copyright	2010-2013 Waldo Jaquith
 * @license		http://www.gnu.org/licenses/gpl.html GPL 3
 * @version		0.6
 * @link		http://www.statedecoded.com/
 * @since		0.1
 *
 */

/*
 * Include the PHP declarations that drive this page.
 */
require $_SERVER['DOCUMENT_ROOT'].'/../includes/page-head.inc.php';

/*
 * Fire up our templating engine.
 */
$template = new Page;

$template->field->browser_title = SITE_TITLE.': The '.LAWS_NAME.', for Humans.';

/*
 * Initialize the body variable.
 */
$body = '';

/*
 * Initialize the sidebar variable.
 */
$sidebar = '
<section>
<h1>Welcome</h1>
<p>MarylandCode.org provides the Maryland Code of Public Laws on one friendly website.  No copyright restrictions, a modern API and all of the niceties of modern website design. It’s like the expensive software lawyers use, but free and wonderful.</p>
<p>This is a public beta test of MarylandCode.org, which is to say that everything is under development. Things may be funny looking, broken, and generally under development right now.</p>
<p>Powered by <a href="http://www.statedecoded.com/">The State Decoded</a>.</p>
</section>
<section>
<h2 style="margin-top:1em;">Want your own State Decoded?</h2>
<input id="get_yours" type="button" value="Click Here"/>
</section>
';

/*
 * Get an object containing a listing of the fundamental units of the code.
 */
$struct = new Structure();
$structures = $struct->list_children();

$body .= '
	<article>
	<h1>'.ucwords($structures->{0}->label).'s of the '.LAWS_NAME.'</h1>
	<p>These are the fundamental units of the '.LAWS_NAME.'.  There are 79 articles, roughly divided up by topic.  Each article is divided into sections, 31,649 in total.</p>';
if ( !empty($structures) )
{
	$body .= '<dl class="level-1">';
	foreach ($structures as $structure)
	{
		$body .= '	<dt><a href="'.$structure->url.'">'.$structure->identifier.'</a></dt>
					<dd><a href="'.$structure->url.'">'.$structure->name.'</a></dd>';
	}
	$body .= '</dl>';
}
$body .= '</article>';

/*
 * Put the shorthand $body variable into its proper place.
 */
$template->field->body = $body;
unset($body);

/*
 * Put the shorthand $sidebar variable into its proper place.
 */
$template->field->sidebar = $sidebar;
unset($sidebar);

/*
 * Parse the template, which is a shortcut for a few steps that culminate in sending the content
 * to the browser.
 */
$template->parse();
