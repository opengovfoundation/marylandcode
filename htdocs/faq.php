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
$template->field->browser_title = 'FAQ';
$template->field->page_title = 'Geek-Speak Glossary &amp; FAQ';

$body = '
<p>Maryland has a rich American history of democratic participation and citizen-led self-governance.  Open government is simply the next evolution.  Open, accessible, human-friendly and restriction-free information like MarylandCode.org makes it all possible.</p>
<h2>What the Heck Are “Open Government” and the OpenGov Foundation?</h2>
<p>We\'re a scrappy little non-profit, non-partisan outfit working to open government.  That means making it easier for people to access and use as much government information as possible.  We believe innovative technology can help deliver a government that listens, works for its citizen-users, and learns from them.  We are dedicated to putting better data and better tools in more hands.  Our goal is to make or adapt those tools to be easy to use, efficient, scalable and free.  Democracy means everyone should have chance to be a hands-on contributor.</p>
<p><a href="http://opengovfoundation.org/about-us/">Click here to learn more about Team OpenGov</a> and <a href="http://opengovfoundation.org/join-the-movement/">click here to get your hands dirty with us.</a></p>
<h2>What’s an API (Application Programming Interface)?</h2>
<p>According to <a href="http://www.wisegeek.com/what-is-an-api.htm">The Wise Geek</a>, an API is “a set of data structures, protocols, routines and tools for accessing a web-based software application. It provides all the building blocks for developing programs with ease.”  The MarylandCode.org API lets others plug into our data so they can build software programs and applications that interact (and stay updated) seamlessly. </p>
<p>&lt;&lt;&lt;<a href="http://www.makeuseof.com/tag/api-good-technology-explained/">Learn more about APIs&gt;&gt;&gt;</a></p>
<h2>What’s “Open Data”?</h2>
<p>A good working definition comes from the <a href="http://opendefinition.org/about/">Open Knowledge Foundation</a>: “Data that can be freely used, reused and redistributed by anyone - subject only, at most, to the requirement to attribute and share alike.”  We’re all living better because of it.  Will it rain tomorrow?  Every TV news forecast, weather app or website runs on open weather data at some level.  Lost?  That map in your pocket runs on open data from the Global Positioning System (GPS).  These - and an exploding constellation of products and services - are made possible by open data.  Imagine the possibilities if all government information came this way!</p>
<p>&lt;&lt;&lt;<a href="http://opendefinition.org/okd/">Learn more about open data</a>&gt;&gt;&gt;</p>
<h2>Are There Other Open Government & Open Data Advances I Should Know About?</h2>
<p>Yes.  President Barack Obama has recognized that the ability to freely access, reuse and redistribute public information - in the manner made possible by MarylandCode.org - is central to healthy socities and democracies in the 21st Century.  In his historic <a href="http://www.whitehouse.gov/open/documents/open-government-directive">December 2009 Open Government Directive</a>, the President instructed all federal agencies to publish their data: </p>
<blockquote>“...online in an open format that can be retrieved, downloaded, indexed, and searched by commonly used web search applications. An open format is one that is platform independent, machine readable, and made available to the public without restrictions that would impede the re-use of that information.”</blockquote>
<p>Open access advances aren’t limited to the federal government.  Right here in Maryland, smart and tech-savvy public servants have made good progress making both city and state public data truly public.  Highlights include:</p>
<ul>
	<li><a href="https://data.baltimorecity.gov/">OpenBaltimore</a> - spearheaded by Mayor Stephanie Rawlings-Blake and built off <a href="http://www.innovations.harvard.edu/awards.html?id=3638">the award-winning work of then-Mayor Martin O’Malley</a> - is “an effort that supports government transparency, openness and innovative uses that will help improve the lives of Baltimore residents, visitors and businesses through use of technology. OpenBaltimore will enable the local developer community to develop applications that will hopefully help the city solve problems,” according to their website.</li>
	<li>The Maryland Legislature now allows citizens to download limited, but regularly updated, amounts of legislative data in CSV files.  It’s a great start.  “The file includes information such as number, sponsor, title, legislative status, synopsis, committee assignments, legislative history, hearing dates, etc. for each piece of legislation introduced during the current legislative session,” <a href="http://mgaleg.maryland.gov/webmga/frm1st.aspx?tab=home">according to their new website</a>.</li>
	<li><a href="http://www.statestat.maryland.gov/">StateStat</a>, launched by Governor Martin O’Malley, embraces open data-driven governance and helps secure Maryland citizens’ right to know how their tax dollars are being spent.  StateStat is all about "openness and accountability," <a href="http://www.informationweek.com/government/information-management/data-analysis-drive-maryland-government/223800144?pgno=2">according to this interview with Governor O\'Malley</a>.  "Perhaps the greatest value of this model of governance is that it brings government closer to the people it exists to serve."</li>
</ul>
<h2>What’s XML (Extensible Markup Language) and A “Bulk XML Download”?</h2>
<p>XML is a document format that is both machine-readable and human-readable.  That means it contains baked-in structures that computers, software and apps can understand, without all the technical gobbledygook that makes most machine-readable documents unintelligible to people.  On MarylandCode.org, you’re reading XML (and so is your computer!).  Popular uses of XML are <a href="http://office.microsoft.com/en-us/">Microsoft Office</a>, <a href="https://www.apple.com/iwork/">Apple iWork</a>, <a href="http://www.libreoffice.org/">Libre Office</a> and <a href="http://www.whatisrss.com/">RSS</a>.</p>
<p>A “bulk XML download” is a way for software developers to obtain a full set of the XML documents in a given set all at once.  </p>
<p>&lt;&lt;&lt;<a href="http://www.inc.com/guides/2010/04/why-companies-should-use-xml.html">Learn more about XML</a>&gt;&gt;&gt;</p>
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
