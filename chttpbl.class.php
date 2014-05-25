<?php

/**
 * Cached http:BL PHP class
 * performs http:BL service check for IPv4 address (with caching)
 * for more information about http:BL service visit project's home page at
 * http://www.projecthoneypot.org
 *
 * @package chttpbl
 * @version 1.0.1.0
 * @author Rafal Toborek
 * @copyright Rafal Toborek
 * @link http://toborek.info
 * @link http://github.com/clash82/cachedHttpBl/
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */
class cachedHttpBl {
	private
		$_apikey,
		$_cache = array(),
		$_write_cache = false,
		$_enable_cache = false;

	public
		$type,
		$typemeaning,
		$typemeaning_description,
		$threat,
		$threat_description,
		$activity,
		$activity_description;

	/**
	 * script version
	 * @param string
	 */
	public $version = "1.0.1.0";

	/**
	 * operation error level
	 * @param int
	 */
	public $error = 0;

	/**
	 * operation error description
	 * @param string
	 */
	public $error_description;

	/**
	 * maximum cache lifetime in hours
	 * @param int
	 */
	public $cache_lifetime = 24;

	/**
	 * cache file
	 * @param string
	 */
	public $cache_file;

	/**
	 * sets API key for http:BL service
	 */
	public function setAPIKey($apikey)
	{
		$this->_apikey = $apikey;
	}

	/**
	 * unpack raw data received from server
	 * @param array $data
	 */
	private function _parse($data)
	{
		$this->type = $data["type"];

		// correct answer from server
		if ($data["type"] == "127") {
			$this->activity = $data["activity"];
			$this->activity_description = "last seen: ".$data["activity"]." day(s) ago";

			$this->threat = $data["threat"];
			if ($data["threat"] < 26)
				$this->threat_description = "100 [msg/day]";
			elseif ($data["threat"] > 25 & $result["threat"] < 51)
				$this->threat_description = "10,000 [msg/day]";
			else
				$this->threat_description = "1,000,000 [msg/day]";

			$this->typemeaning = $data["typemeaning"];
			switch ($data["typemeaning"]) {
				case 0:
					$this->typemeaning_description = "Search Engine";
				break;

				case 1:
					$this->typemeaning_description = "Suspicious";
				break;

				case 2:
					$this->typemeaning_description = "Harvester";
				break;

				case 4:
					$this->typemeaning_description = "Comment Spammer";
				break;

				case 5:
					$this->typemeaning_description = "Suspicious & Comment Spammer";
				break;

				case 6:
					$this->typemeaning_description = "Harvester & Comment Spammer";
				break;

				case 7:
					$this->typemeaning_description = "Suspicious & Harvester & Comment Spammer";
				break;
			}
			return true;
		} else {
			$this->type = "";
			$this->activity = "";
			$this->activity_description = "";
			$this->typemeaning = "";
			$this->typemeaning_description = "";
			$this->threat = "";
			$this->threat_description = "";
			return false;
		}
	}

	/**
	 * check single address
	 * @param string $ip IPv4 address
	 * @return bool operation result
	 */
	public function check($ip)
	{
		if (empty($this->_apikey)) {
			$this->error = 2;
			$this->error_description = "missing http:BL API key";
			return false;
		}

		if ($this->_enable_cache & array_key_exists($ip, $this->_cache))
			return $this->_parse($this->_cache[$ip]);
		else {
			$lookup = $this->_apikey.".".implode(".", array_reverse(explode(".", $ip))).".dnsbl.httpbl.org";
			$result = gethostbyname($lookup);
			if ($result != $lookup)
				$result = explode(".", $result);

				// correct answer from server is 127
				if ($result["0"] == 127) {

					// put results data to cache
					if ($this->_enable_cache) {
						if (!array_key_exists($ip, $this->_cache)) {
							$this->_cache[$ip] = array(
								"time" => time(),
								"type" => $result["0"],
								"threat" => $result["2"],
								"typemeaning" => $result["3"],
								"activity" => $result["1"]
							);
							$this->_write_cache = true;
						}
					}

					// unpack data
					$this->_parse(array(
						"type" => $result["0"],
						"activity" => $result["1"],
						"threat" => $result["2"],
						"typemeaning" => $result["3"]
					));

					$this->error = 0;
					$this->error_description = "";

					return true;
				}

				// incorrect IPv4 format or http:BL is currently down
				if ($this->_enable_cache) {
					if (empty($this->_cache[$ip]))
						$this->_cache[$ip] = array(
							"type" => "0",
							"time" => time()
						);

				$this->error = 1;
				$this->error_description = "this IP address is not listed on http:BL service database, you may ignore this error but firt of all check if you have valid http:BL API key and service is not currently offline";

				return false;
			}
		}
	}

	/**
	 * loads data from cache into array
	 */
	private function _loadCache()
	{
		$this->_cache = array();
		$cache_lifetime_timestamp = date("U", strtotime("-".$this->cache_lifetime." hours"));
		if (file_exists($this->cache_file)) {
			$a = file($this->cache_file, FILE_SKIP_EMPTY_LINES);
			foreach ($a as $v) {
				$data = explode(";", $v);

				// do not load outdated data
				if ($data["1"] >= $cache_lifetime_timestamp)
					if (empty($data["2"]))
						$this->_cache[long2ip($data["0"])] = array(
							"time" => trim($data["1"]),
							"type" => "0"
						);
					else
						$this->_cache[long2ip($data["0"])] = array(
							"time" => $data["1"],
							"type" => $data["2"],
							"threat" => $data["3"],
							"typemeaning" => $data["4"],
							"activity" => trim($data["5"])
						);
			}
		}
	}

	/**
	 * enable queries caching
	 * @param bool $status enable or disable
	 */
	public function enableCache($enable = true)
	{
		$this->_enable_cache = $enable;
		if ($enable)
			$this->_loadCache();
		else {
			$this->_cache = "";
			$this->_write_cache = false;
		}
	}

	/**
	 * purge cached data (delete cache file)
	 */
	public function clearCache()
	{
		if (file_exists($this->_cache_file))
			@unlink($this->_cache_file);
	}

	/**
	 * @param string $apikey http:BL API key
	 */
	public function __construct($apikey)
	{
		$this->_apikey = $apikey;
		$this->cache_file = getcwd()."/httpbl_cache.csv";
	}

	/**
	 * writes cache buffer to file on exit (if needed)
	 */
	public function __destruct()
	{
		if ($this->_write_cache) {
			$cache = "";
			foreach ($this->_cache as $ip => $data)
				if ($data["type"] == "127")
					$cache .= ip2long($ip).";".$data["time"].";".$data["type"].";".$data["threat"].";".$data["typemeaning"].";".$data["activity"]."\r\n";
				else
					$cache .= ip2long($ip).";".$data["time"]."\r\n";
			file_put_contents($this->cache_file, $cache);
		}
	}
}