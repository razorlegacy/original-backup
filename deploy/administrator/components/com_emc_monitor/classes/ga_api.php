<?php
defined('_JEXEC') or die();

class analytics_api {
	public $auth;
	public $accounts;

	public function login($email, $password) {
		$ch = $this->curl_init("https://www.google.com/accounts/ClientLogin");
		curl_setopt($ch, CURLOPT_POST, true);
		
		$data = array(
			'accountType' => 'GOOGLE',
			'Email' => $email,
			'Passwd' => $password,
			'service' => 'analytics',
			'source' => ''
		);
		
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$output = curl_exec($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);
		
		$this->auth = '';
		if($info['http_code'] == 200) {
			preg_match('/Auth=(.*)/', $output, $matches);
			if(isset($matches[1])) {
				$this->auth = $matches[1];
			}
		}
		
		return $this->auth != '';
	}
	
	/**
	 * Calls an API function using the url passed in and returns either the XML returned from the
	 * call or false on failure
	 *
	 * @param string $url 
	 * @return string or boolean false
	 */
	public function call($url) {
		$headers = array("Authorization: GoogleLogin auth=$this->auth");
		
		$ch = $this->curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$output = curl_exec($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);
	
		// set return value to a default of false; it will be changed to the return string on success
		$return = false;
		
		if($info['http_code'] == 200) {
			$return = $output;
		}
		elseif($info['http_code'] == 400) {
			trigger_error('Badly formatted request to the Google Analytics API; check your profile id is in the format ga:12345, dates are correctly formatted and the dimensions and metrics are correct', E_USER_WARNING);
		}
		elseif($info['http_code'] == 401) {
			trigger_error('Unauthorized request to the Google Analytics API', E_USER_WARNING);
		}
		else {
			trigger_error("Unknown error when accessing the Google Analytics API, HTTP STATUS {$info['http_code']}", E_USER_WARNING);
		}
		return $return;
	}

	/**
	 * Calls the API using the parameters passed in and returns the data in an array.
	 *
	 * @param string $id The profile's id e.g. ga:7426158
	 * @param string $dimension The dimension(s) to use. If more than one dimension is used then
	 *   comma separate the values e.g. ga:pagePath or ga:browser,ga:browserVersion
	 * @param string $metric The metric(s) to use. If more than one metric is used then
	 *   comma separate the values e.g. ga:visits or ga:visits,ga:pageviews
	 * @param string $sort The sort order, one of the metrics fields. Use - in front of the name
	 *   to reverse sort it. The default is to do a -$metric sort.
	 * @param string $start The start date of the data to include in YYYY-MM-DD format. The default
	 *   is 1 month ago. It can also be set to "today" which gets data for today only (as much data
	 *   for the current day that Analytics can give you), "yesterday" which gets data for yesterday,
	 *   or "week" which gets the data for the week to yesterday.
	 * @param string $end The end date of the data to include in YYYY-MM-DD format. The default is
	 *   yesterday.
	 * @param integer $max_results The maximum number of results to retrieve. If the value is greater
	 *   than 1000 the API will still only return 1000.
	 * @param integer $start_index The index to start from. The first page is 1 (which is the defult)
	 *   and the second page, if getting 1000 results at a time, is 1001.
	 * @param string|analytics_filters $filters The string to pass as the filters parameter. Refer to:
	 *   http://code.google.com/apis/analytics/docs/gdata/gdataReference.html#filtering
	 *   If it's a string it's appended directly onto the url after '&filters='; if it's an analytics_filters
	 *   object then the ->filters property of the object is appended.
	 * @param boolean $debug If true will echo the url that is called when making a call to the 
	 *   analytics API. If run from the CLI will echo it along with a linebreak; otherwise will
	 *   put it in a <p> tag and end with a newline
	 * @return array Returns an array indexed by the first dimension (then second dimension, etc) with
	 *   a value for each metric.
	 */
	public function data($id, $dimension, $metric, $sort = false, $start = false, $end = false, $max_results = 10, $start_index = 1, $filters = false, $debug = false) {
	//---------------------------------------------------------------------------------------------
		
		if(!$sort) $sort = "-$metric";
		
		if($start == 'today') {
			$start = date('Y-m-d');
			$end = $start;
		}
		elseif($start == 'yesterday') {
			$start = date('Y-m-d', strtotime('yesterday'));
			$end = $start;
		}
		elseif($start == 'week') {
			$start = date('Y-m-d', strtotime('1 week ago'));
			$end = date('Y-m-d', strtotime('yesterday'));
		}
		else {
			if(!$start) $start = date('Y-m-d', strtotime('1 month ago'));
			if(!$end) $end = date('Y-m-d', strtotime('yesterday'));
		}
				
		$url = "https://www.google.com/analytics/feeds/data?ids=$id&dimensions=$dimension&metrics=$metric&sort=$sort&start-date=$start&end-date=$end&max-results=$max_results&start-index=$start_index";
		
		if($filters) {
			if(is_object($filters) && is_a($filters, 'analytics_filters') && $filters->filters) {
				$url .= "&filters=" . $filters->filters;
			}
			elseif(is_string($filters)) {
				$url .= "&filters=$filters";
			}
		}
		
		if($debug) {
			if(PHP_SAPI == 'cli') {
				echo "$url\n";
			}
			else {
				echo "<p>" . htmlentities($url) . "</p>\n";
			}
		}
		$xml = $this->call($url);

		if(!$xml) {
			return false;
		}

		$dom = new DOMDocument();
		$dom->loadXML($xml);

		$entries = $dom->getElementsByTagName('entry');
		
		$data = array();
		foreach($entries as $entry) {
		
			$index = array();
			foreach($entry->getElementsByTagName('dimension') as $mydimension) {
			//echo '*****'.$mydimension->ownerDocument->saveXML();
							$index[] = $mydimension->getAttribute('value');
			}
		
			// find out how many dimensions are present and have an array index for each dimension
			// if there are no dimensions then the indexes are just the metric names
			// if there's a single dimension the array will be $data['dimension1'] = ...
			// if there's two dimensions the array will be $data['dimension1']['dimension2'] = ...
			// if there's three dimensions the array will be $data['dimension1']['dimension2']['dimension3'] = ...
		
			switch(count($index)) {
		
				case 0:
					foreach($entry->getElementsByTagName('metric') as $metric) {
						$data[$metric->getAttribute('name')] = $metric->getAttribute('value');
					}
				break;
				
				case 1:
					foreach($entry->getElementsByTagName('metric') as $metric) {
						$data[$index[0]][$metric->getAttribute('name')] = $metric->getAttribute('value');
					}
				break;
			
				case 2:
					foreach($entry->getElementsByTagName('metric') as $metric) {
						$data[$index[0]][$index[1]][$metric->getAttribute('name')] = $metric->getAttribute('value');
					}
				break;
			
				case 3:
					foreach($entry->getElementsByTagName('metric') as $metric) {
						$data[$index[0]][$index[1]][$index[2]][$metric->getAttribute('name')] = $metric->getAttribute('value');
					}
				break;
		
			}
				
		}
		
		return $data;
		
	}

	protected function curl_init($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		if($this->auth) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: GoogleLogin auth=$this->auth"));
		}

		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		
		return $ch;
	}
		
}

/**
* Sets up a properly url encoded filter to pass to analytics_api::data
*/
class analytics_filters {
	public $filters;
	
	/**
	* Constructor, pass it the initial values for the filter
	* 
	* @param string $dimension_or_metric The dimension or metric to filter on e.g. ga:country or ga:browser
	* @param string $comparison The comparison type, == != > < >= <= == != =~ !~ =@ !@
	*   Refer to http://code.google.com/apis/analytics/docs/gdata/gdataReference.html#filtering
	* @param string $value The value to filter on
	*/
	public function __construct($dimension_or_metric, $comparison, $value) {
		$this->filters = $dimension_or_metric . urlencode($comparison.$value);
	}
	
	/**
	* Add an "and" condition to the filter
	* 
	* @param string $dimension_or_metric The dimension or metric to filter on e.g. ga:country or ga:browser
	* @param string $comparison The comparison type, == != > < >= <= == != =~ !~ =@ !@
	*   Refer to http://code.google.com/apis/analytics/docs/gdata/gdataReference.html#filtering
	* @param string $value The value to filter on
	*/
	public function add_and($dimension_or_metric, $comparison, $value) {
		$this->filters .= ';' . $dimension_or_metric . urlencode($comparison.$value);
	}
	
	/**
	* Add an "or" condition to the filter
	* 
	* @param string $dimension_or_metric The dimension or metric to filter on e.g. ga:country or ga:browser
	* @param string $comparison The comparison type, == != > < >= <= == != =~ !~ =@ !@
	*   Refer to http://code.google.com/apis/analytics/docs/gdata/gdataReference.html#filtering
	* @param string $value The value to filter on
	*/
	public function add_or($dimension_or_metric, $comparison, $value) {
		$this->filters .= ',' . $dimension_or_metric . urlencode($comparison.$value);
	}

}