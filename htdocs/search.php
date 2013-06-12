<?php
	require $_SERVER['DOCUMENT_ROOT'].'/../includes/page-head.inc.php';

	/*
	 * 	Redirect old search results
	 */
	if(preg_match('@search@', $_SERVER['REQUEST_URI'])){
		$location = '/term/' . str_replace(' ', '-',$_GET['q']) . '/';  
		echo $location;
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: $location");
	}
	
	$query = $_GET['q'];
	$query_readable = rtrim(str_replace('-', ' ', $query), '/');
	
		
	if(isset($_GET['p'])){
		$page = $_GET['p'];
		$start = ($page - 1) * 10;
	}
	else{
		$start = 0;
	}	
		
	try{
		$url = "http://localhost:8983/solr/statedecoded/select?q=$query&wt=json&start=$start";
		$ch = curl_init($url);
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
	$start_page = $page - 5 > 0 ? $page - 5 : 0;

	if(isset($_GET['p'])){
		$pager_prev_page = ($page - 1) > 1 ? '?p=' . ($page - 1) : '';
		$pager_prev = '<a href="/term/' . $query . '/' . $pager_prev_page . '" rel="prevstart" class="pager-prev">&lt;</a>';
		if($page == $pages - 1){
			$pager_next = '<span class="pager-disabled pager-next">&gt;</span>';
		}else{
			$pager_next = '<a href="/term/' . $query . '/?p=' . ($page + 1) . '" rel="next" class="pager-next">&gt;</a>';
		}
	}else{
		$pager_prev = '<span class="pager-disabled pager-prev">&lt;</span>';
		if($pages > 1){
			$pager_next = '<a href="/term/' . $query . '/?p=2" rel="next" class="pager-next">&gt;</a>';
		}else{
			$pager_next = '<span class="pager-disabled pager-next">&gt;</span>';
		}
	}

	
	
	$template = new Page;
	$template->field->browser_title = ucwords($query_readable) . ' Laws';
	$template->field->page_title = ucwords($query_readable) . ' Laws';
	
	$body = '
		<div id="result">
			<div id="navigation">
				<ul id="pager">
					<li>' . $pager_prev . '</li>';

	for($i = $start_page; $i < $start_page + 10 && $i < $pages; $i++){
		if($i == ($page - 1)){//Disable the current page link
			$body .= '<li><span class="pager-disabled">' . ($i + 1) . '</span></li>';
		}
		elseif($i == 0 && !isset($page)){//If this is the first page
			$body .= '<li><span class="pager-disabled">' . ($i + 1) . '</span></li>';
		}elseif($i == 0){//Don't append &p query for first page
			$body .= '<li><a href="/term/' . $query . '/" rel="prevstart">' . ($i + 1) . '</a></li>';
		}else{//Create other page links
			$body .= '<li><a href="/term/' . $query . '/?p=' . ($i + 1) . '" rel="prevstart">' . ($i + 1) . '</a></li>';
		}
	}		
	
	$body .= '<li>' . $pager_next . '</li>';		
					
	$body .=	'</ul>
				<div id="pager-header">
					<span id="pagination">' . ($start + 1) . '-' . ($start + 10) . ' of ' . $response->numFound . '</span>
					for
					<strong>
						<span id="curr_search">' . $query_readable . '</span>
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
					<span class="hl1">' . $query_readable . '</span>
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