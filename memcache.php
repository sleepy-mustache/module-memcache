<?php
namespace Module\Memcache;

/**
 * Caches the page
 * @return void
 * @internal
 */
function cache_page() {
	$port = 11211;
	$cacheExpires = 30; //seconds

	$url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$page = ob_get_contents();
	$memcache = new \Memcache;
	$memcache->connect('localhost', $port) or die ("Memcache: Could not connect");

	if (!$get_result = $memcache->get($url)) {
		$get_result = $memcache->set($url, $page, 0, $cacheExpires) or
		die("Failed to save data at the server");
	}

	ob_end_flush();
}

/**
 * Show a cached page, if it exists
 * @return void
 * @internal
 */
function show_cached_page() {
	$port = 11211;
	$url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	$memcache = new \Memcache;
	$memcache->connect('localhost', $port) or die ("Memcache: Could not connect");

	if ($get_result = $memcache->get($url)) {
		header('Memcached: true');
		echo $get_result;
		die();
	}

	ob_start();
}

if (ENV !== "LIVE") {
	\Sleepy\Hook::doAction('sleepy_preprocess',  '\Module\Memcache\show_cached_page');
	\Sleepy\Hook::doAction('sleepy_postprocess', '\Module\Memcache\cache_page');
}

