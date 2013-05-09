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
$template->field->browser_title = 'Infographic';
$template->field->page_title = 'What Can MarylandCode.org Do?';

$body = '
<iframe src="/html/infographic.html" width="960" height="1243" frameborder="0"></iframe>
';


$sidebar = 
'

<section>
<h1>Contact</h1>
<ul>
<li>
<a href="http://twitter.com/foundopengov" target="_blank">Follow OpenGov on Twitter</a>
</li>
<li>
<a href="mailto:sayhello@opengovfoundation.org">Email OpenGov\'s Seamus Kraft &amp; Chris Birk</a>
</li>
</ul>
</section>
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

# Put the shorthand $body variable into its proper place.
$template->field->body = $body;
unset($body);

# Put the shorthand $sidebar variable into its proper place.
$template->field->sidebar = $sidebar;
unset($sidebar);

# Parse the template, which is a shortcut for a few steps that culminate in sending the content
# to the browser.
$template->parse();
