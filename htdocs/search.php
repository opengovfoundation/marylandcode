<?php
	apc_clear_cache();

	require $_SERVER['DOCUMENT_ROOT'].'/../includes/page-head.inc.php';
	
	require_once('vendor/SolrPhpClient/Apache/Solr/Service.php');
	
	$solr = new Apache_Solr_Service(
		'localhost',
		'8983',
		'/solr/statedecoded'
	);

	$query = $_GET['q'];
	
	if(isset($_GET['p'])){
		$page = $_GET['p'] - 1;
		$start = $page * 10;
		$end = $start + 9;
		$pager_prev = '<span class="pager-disabled pager-prev">&lt;</span>';
	}
	else{
		$start = 0;
		$end = 9;
		$pager_prev = '<a href="" rel="prevstart" class="pager-prev">&lt;</a>';
	}
		
	try{
		$results = $solr->search($query, $start, $end, array('wt'=>'json'));
		
		$response = $results->response;
		$docs = $response->docs;
	}catch(Exception $e){
		die($e->getMessage());
	}

	$pages = ceil($response->numFound / 10);
	$pages = $pages > 10 ? 10 : $pages;
	
	$template = new Page;
	$template->field->browser_title = 'Search Maryland Decoded';
	$template->field->page_title = 'Search';
	
	$body = '
		<div id="result">
			<div id="navigation">
				<ul id="pager">
					<li>' . $pager_prev . '</li>';

	for($i = 0; $i < $pages; $i++){
		$body .= '<li><a href="/search/?q="' . $query . '&p=' . $i . '" rel="prevstart">' . $i . '</a></li>';
	}				
					
	$body .=	'</ul>
				<div id="pager-header">
					<span id="pagination">1-10 of ' . $response->numFound . '</span>
					for
					<strong>
						<span id="curr_search">' . $query . '</span>
						<span id="suggestions"></span>
					</strong>
				</div>
			</div>
		</div>
		<div id="docs">
	';
	
	foreach($docs as $doc){
		$body .= '
			<div>
				<h2>
					<span class="hl1">' . $query . '</span>
					<span><a href="/' . $doc->section . '/">(' . $doc->section . ')</a></span>
				</h2>
				<p>' . $doc->text . '</p>
			</div>
		';
	}
	
	$body .= "</docs>";
	
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
	
	$template->field->body = $body;
	unset($body);
	
	$template->field->sidebar = $sidebar;
	unset($sidebar);
	
	
	$template->parse();