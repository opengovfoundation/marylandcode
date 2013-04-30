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
$template->field->browser_title = 'About Maryland Decoded';
$template->field->page_title = 'About';

$body = '
<h2>Introduction</h2>
<p>Maryland Decoded is a non-profit, non-governmental, non-partisan implementation of <a href="http://www.statedecoded.com" target="_blank">The State Decoded</a> brought to you by the folks at the <a href="http://opengovfoundation.org">OpenGov Foundation</a>. The State Decoded is a free, open source project that provides a platform to display state-level legal information in a friendly, accessible, modern fashion. Maryland is the third state to deploy the software, with more coming soon.</p>
<h2>Alpha Testing</h2>
<p>Maryland Decoded is currently in public alpha, which is to say that the site is under active development, with known shortcomings, but it has reached a point where it would benefit from being used by the general public (who one hopes will likewise benefit from it.) While every effort is made to ensure that the data provided on Maryland Decoded is accurate and up-to-date, it would be gravely unwise to rely on it for any matter of importance while it is in this beta testing phase.</p>
<p>Many more features are under development, including calculations of the importance of given laws, inclusion of attorney generals’ opinions, Supreme Court of Maryland rulings, extensive explanatory text, social media integration, significant navigation enhancements, a vastly expanded built-in glossary of legal terms, scholarly article citations, and much more.</p>
<h2>Data Sources</h2>
<p>The information that makes up Maryland Decoded comes entirely from public sources. All of the sections of the code are straight from the <a href="http://dls.state.md.us/" target="_blank">Maryland Department of Legislative Services</a>, who provided XML of the Code (via <a href="http://dropbox.com" target="_blank">DropBox</a>). Any included legislative data is scraped from the Maryland State Legislature website.  Term definitions are from within the state code itself. Throughout the site, links are provided to original data sources, whenever possible.</p>
<h2>API</h2>
<p>The site has a RESTful, JSON-based API. <a href="http://marylandcode.org/api-key/">Register for an API key</a> and <a href="https://github.com/statedecoded/statedecoded/wiki/API-Documentation">read the documentation</a> for details.</p>
<h2>Thanks</h2>
<p>Maryland Decoded wouldn’t be possible without the contributions and years of work by <a href="http://waldo.jaquith.org/">Waldo Jaquith</a>, and the many dozens of people who participated in private alpha and beta testing of <a href="http://vacode.org/about/">Virginia Decoded</a>, the first <a href="http://www.statedecoded.com/">State Decoded</a> site, over the course of a year and a half, beginning in 2010. Specific thanks must be extended the good people of the Maryland Department of Legislative Services. This platform on which this site is based, <a href="http://www.statedecoded.com/">The State Decoded</a>, was expanded to function beyond Virginia thanks to a generous grant by the <a href="http://knightfoundation.org/">John S. and James L. Knight Foundation</a>.</p>
<h2>Colophon</h2>
<p>Hosted on <a href="http://www.centos.org/">CentOS</a>, driven by <a href="http://httpd.apache.org/">Apache</a>, <a href="http://www.mysql.com/">MySQL</a>, and <a href="http://www.php.net/">PHP</a>. Hosting by Rackspace. Search by <a href="http://lucene.apache.org/solr/">Solr</a>. Comments by <a href="http://disqus.com/">Disqus</a> and Madison.</p>
<h2>Disclaimer</h2>
<p>This is not an official copy of the Code of Maryland. It is in no way authorized by the State of Maryland. No information that is found on Maryland Decoded constitutes legal advice on any subject matter. Do not take action (or fail to take action) on a legal matter without consulting proper legal counsel. The contents of this website are provided as-is, with no warranty of any kind, including merchantability, non-infringement, or fitness for a particular purpose. This website is not your lawyer, and neither is the OpenGov Foundation.</p>
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
