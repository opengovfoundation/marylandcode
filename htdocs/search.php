<?php
	apc_clear_cache();

	require $_SERVER['DOCUMENT_ROOT'].'/../includes/page-head.inc.php';

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
		$ch = curl_init("http://localhost:8983/solr/statedecoded/select?q=$query&wt=json");
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		curl_close($ch);
		
		$json = json_decode($output);
		$response = $json->response;
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