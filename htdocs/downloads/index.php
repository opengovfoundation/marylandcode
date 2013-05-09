<?php

/**
 * The "About" page, explaining this State Decoded website.
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

# Include the PHP declarations that drive this page.
require $_SERVER['DOCUMENT_ROOT'].'/../includes/page-head.inc.php';

# Fire up our templating engine.
$template = new Page;

# Define some page elements.
$template->field->browser_title = 'Bulk Downloads';
$template->field->page_title = 'Bulk Downloads';

$body = '
<ul>
<li><a href="/downloads/code.json.zip">code.json.zip</a></li>
<li><a href="/downloads/dictionary.json.zip">dictionary.json.zip</a></li>
</ul>
';


$sidebar = 
'
<h1>Contact</h1>
<section>
<ul>
<li>
<a href="http://twitter.com/foundopengov" target="_blank">Follow OpenGov on Twitter</a>
</li>
<li>
<a href="mailto:sayhello@opengovfoundation.org">Email OpenGov\'s Seamus Kraft &amp; Chris Birk</a>
</li>
</ul>
</section>
';

# Put the shorthand $body variable into its proper place.
$template->field->body = $body;
unset($body);

# Put the shorthand $sidebar variable into its proper place.
$template->field->sidebar = $sidebar;
unset($sidebar);

# Parse the template, which is a shortcut for a few steps that culminate in sending the content
# to the browser.
$template->parse();
