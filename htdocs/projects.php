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
$template->field->browser_title = 'Maryland Decoded Projects';
$template->field->page_title = 'Projects and Updates';

$template->field->javascript_files = '<script src="/js/disqus.embed.js"></script>';

$body = '
<p>We\'re opening up the Maryland Code of Public Laws to everyone as human readable and machine consumable.  What\'s next?  Share your ideas for awesome Maryland Code projects or apps in the comments below.  As your ideas become realities, we\'ll post the projects - and updates about this website\'s growth - right here.</p>
<p>Here\'s what we have lined up already: </p>
<ul id="future-projects">
	<li>
		Cross-Linking Related Laws <span class="small-status">(Posted May 2013 - <strong>in progress</strong>)</span>
		<p>Laws that reference other laws will include links to the referenced laws</p>
	</li>
	<li>
		Creating Section Titles <span class="small-status">(Posted May 2013 - <strong>in progress</strong>)</span>
		<p>Create relevant section titles from user-submitted suggestions</p>
	</li>
	<li>
		Add keyword cloud to sidebar for prominently used keywords <span class="small-status">(Posted May 2013 - <strong>in progress</strong>)</span>
		<p>The cloud will link frequently used keywords to a search of the keyword</p>
	</li>
</ul>
';


/*
 * 	Add Disqus comments
 */
$body .= '<div id="disqus_thread"></div>';
$body .= '<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>';
$body .= '<a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>';


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
