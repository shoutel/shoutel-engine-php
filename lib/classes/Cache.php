<?php

class Cache {
	private $cacheContent = 'PD9waHAKCmNsYXNzICVzIHsKICAgIGZ1'.
							'bmN0aW9uIGNhY2hlRGF0YSgpCiAgICB7'.
							'CiAgICAgICAgJGNhY2hlX2RhdGEgPSB1'.
							'bnNlcmlhbGl6ZSgiJXMiKTsKCiAgICAg'.
							'ICAgcmV0dXJuICRjYWNoZV9kYXRhOwog'.
							'ICAgfQp9Cg==';

	private $class_head = '__ShtCache_';

	private function getCacheRealName($cacheName, $meta)
	{
		$class_head = $this->class_head;
		$orig = 'SCACHE_' . SECRET_CODE;

		$arr = array(
			'code' => $orig
		);

		$arr = array_merge($arr, $meta);

		$hash = hash("sha256", json_encode($arr));
		$cache_name = $class_head . $cacheName . '_' . $hash;

		return $cache_name;
	}

	public function setCache($cacheName, $data, $meta)
	{
		$target = str_replace('"', '\"', serialize($data));
		$name = $this->getCacheRealName($cacheName, $meta);
		$fp = fopen(DATA_ROOT . '/cache/sys/' . $name . '.php', 'w+');
		$content = sprintf(base64_decode($this->cacheContent), $name, $target);
		fwrite($fp, $content);
		fclose($fp);
	}

	public function getCache($cacheName, $meta, $ttl = 300)
	{
		$name = $this->getCacheRealName($cacheName, $meta);
		$file_name = DATA_ROOT . '/cache/sys/' . $name . '.php';
		if(!file_exists($file_name) || filemtime($file_name) + $ttl < time())
		{
			return null;
		}
		else
		{
			include($file_name);
			$obj = new $name();
			return $obj->cacheData();
		}
	}
}
