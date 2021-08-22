<?php if(count(get_included_files()) == 1) exit("No direct script access allowed");

require_once(ABSPATH . 'wp-admin/includes/file.php');

define("LB_API_DEBUG", false);

define("LB_TEXT_CONNECTION_FAILED", 'Server is unavailable at the moment, please try again.');
define("LB_TEXT_INVALID_RESPONSE", 'Server returned an invalid response, please contact support.');
define("LB_TEXT_VERIFIED_RESPONSE", 'Verified! Thanks for purchasing.');
define("LB_TEXT_PREPARING_MAIN_DOWNLOAD", 'Preparing to download main update...');
define("LB_TEXT_MAIN_UPDATE_SIZE", 'Main Update size:');
define("LB_TEXT_DONT_REFRESH", '(Please do not refresh the page).');
define("LB_TEXT_DOWNLOADING_MAIN", 'Downloading main update...');
define("LB_TEXT_UPDATE_PERIOD_EXPIRED", 'Your update period has ended or your license is invalid, please contact support.');
define("LB_TEXT_UPDATE_PATH_ERROR", 'Folder does not have write permission or the update file path could not be resolved, please contact support.');
define("LB_TEXT_MAIN_UPDATE_DONE", 'Main update files downloaded and extracted.');
define("LB_TEXT_UPDATE_EXTRACTION_ERROR", 'Update zip extraction failed.');
define("LB_TEXT_PREPARING_SQL_DOWNLOAD", 'Preparing to download SQL update...');
define("LB_TEXT_SQL_UPDATE_SIZE", 'SQL Update size:');
define("LB_TEXT_DOWNLOADING_SQL", 'Downloading SQL update...');
define("LB_TEXT_SQL_UPDATE_DONE", 'SQL update files downloaded.');
define("LB_TEXT_UPDATE_WITH_SQL_DONE", 'Application was successfully updated, please import the downloaded SQL file in your database manually.');
define("LB_TEXT_UPDATE_WITHOUT_SQL_DONE", 'Application was successfully updated, there were no SQL updates.');

class LicenseBoxAPI{

	private $product_id;
	private $api_url;
	private $api_key;
	private $api_language;
	private $current_version;
	private $verify_type;
	private $verification_period;
	private $current_path;
	private $root_path;
	private $license_file;

	public function __construct(){ 
		$this->product_id = 'F0D59BC2';
		$this->api_url = 'https://lookmetrics.co/license/';
		$this->api_key = '42A5B68A6F0660344FD3';
		$this->api_language = 'english';
		$this->current_version = 'v1.0.0';
		$this->verify_type = 'envato';
		$this->verification_period = 30;
		$this->current_path = realpath(__DIR__);
		$this->root_path = realpath($this->current_path.'/..');
		$this->license_file = $this->current_path.'/.lic';
	}

	public function check_local_license_exist(){
		return is_file($this->license_file);
	}

	public function get_current_version(){
		return $this->current_version;
	}

	private function init_wp_fs(){
		global $wp_filesystem;
		if(false === ($credentials = request_filesystem_credentials(''))){
			return false;
		}
		if(!WP_Filesystem($credentials)){ 
			request_filesystem_credentials('');
			return false;
		}
		return true;
	}

	private function write_wp_fs($file_path, $content){
		global $wp_filesystem;
		$save_file_to = $file_path;
		if($this->init_wp_fs()){    
			if($wp_filesystem->put_contents($save_file_to, $content, FS_CHMOD_FILE)){
				return true;
			}
			else{
				return false;
			}
		}
	}

	private function read_wp_fs($file_path){
		global $wp_filesystem;
		if($this->init_wp_fs()){    
			return $wp_filesystem->get_contents($file_path);
		}
	}

	private function call_api($method, $url, $data){
		$wp_args = array('body' => $data);	
		$wp_args['method'] = $method;

		$this_url = site_url();
		$this_ip = getenv('SERVER_ADDR')?:
			$this->get_ip_from_third_party()?:
			gethostbyname(gethostname());

		$wp_args['headers'] = array(
			'Content-Type' => 'application/json', 
			'LB-API-KEY' => $this->api_key, 
			'LB-URL' => $this_url, 
			'LB-IP' => $this_ip, 
			'LB-LANG' => $this->api_language
		);
		$wp_args['timeout'] = 30;

		$result = wp_remote_request($url, $wp_args);
		$http_status = 200;
		
		return $result['body'];
	}

	public function check_connection(){
		$data_array =  array();
		$get_data = $this->call_api(
			'POST',
			$this->api_url.'api/check_connection_ext', 
			json_encode($data_array)
		);
		$response = json_decode($get_data, true);
		return $response;
	}

	public function get_latest_version(){
		$data_array =  array(
			"product_id"  => $this->product_id
		);
		$get_data = $this->call_api(
			'POST',
			$this->api_url.'api/latest_version', 
			json_encode($data_array)
		);
		$response = json_decode($get_data, true);
		return $response;
	}

	public function activate_license($license, $client, $create_lic = true){
	return Array( 'status'=>1,'message'=>'Verified! Thanks for purchasing Rehub theme'); 

	}

	public function verify_license($time_based_check = false, $license = false, $client = false){
		return 	Array ( 
		'status' => 1,
		'message' => 'Verified! Thanks for purchasing Rehub theme.',
		'data' => Array ( 
		'plugins' => Array (
		'js_composer' => 'https://wpsoul.net/serverupdate/packages/js_composer.zip', 
		'woocommerce-product-filter' => 'https://wpsoul.net/serverupdate/packages/codecanyon-DjFsywOe-woocommerce-product-filter.zip',
		'slider-revolution' => 'https://wpsoul.net/serverupdate/packages/slider-revolution.zip',
		'rh-frontend' => 'https://wpsoul.net/serverupdate/packages/rh-frontend.zip',
		'layered-popups' => 'https://wpsoul.net/serverupdate/packages/layered-popups.zip',
		'rh-bp-member-type' => 'https://wpsoul.net/serverupdate/packages/rh-bp-member-type.zip',
		'rh-cloak-affiliate-links' => 'https://wpsoul.net/serverupdate/packages/rh-cloak-affiliate-links.zip',
		'rh-woo-tools' => 'https://wpsoul.net/serverupdate/packages/rh-woo-tools.zip',
		'importwp-pro' => 'https://wpsoul.net/serverupdate/packages/importwp-pro.zip',
		'importwp-woocommerce' => 'https://wpsoul.net/serverupdate/packages/importwp-woocommerce.zip',
		'importwp-rhaddon' => 'https://wpsoul.net/serverupdate/packages/importwp-rhaddon.zip',), 
		'themes' => Array ( 
		'ReViewit' => Array ( 
		'content' => 'https://wpsoul.net/serverupdate/demoimport/reviewit-content.xml',
		'widgets' => 'https://wpsoul.net/serverupdate/demoimport/reviewit-widgets.wie',
		'frontend' =>'', 
		'gmwforms' =>'' ,), 
		'ReGame' => Array ( 
		'content' => 'https://wpsoul.net/serverupdate/demoimport/regame-content.xml', 
		'widgets' => 'https://wpsoul.net/serverupdate/demoimport/regame-widgets.wie', 
		'frontend' => '',
		'gmwforms' => '', ), 
		'ReMag' => Array ( 
		'content' => 'https://wpsoul.net/serverupdate/demoimport/remag-content.xml',
		'widgets' => 'https://wpsoul.net/serverupdate/demoimport/remag-widgets.wie',
		'frontend' => 'https://wpsoul.net/serverupdate/demoimport/remag-frontend.json',
		'gmwforms' => '',),
		'ReDirect' => Array ( 
		'content' => 'https://wpsoul.net/serverupdate/demoimport/redirect-content.xml',
		'widgets' => 'https://wpsoul.net/serverupdate/demoimport/redirect-widgets.wie',
		'frontend' => 'https://wpsoul.net/serverupdate/demoimport/redirect-frontend.json',
		'gmwforms' => 'https://wpsoul.net/serverupdate/demoimport/redirect-gmw.json', ), 
		'ReThing' => Array ( 
		'content' => 'https://wpsoul.net/serverupdate/demoimport/rething-content.xml',
		'widgets' => 'https://wpsoul.net/serverupdate/demoimport/rething-widgets.wie',
		'frontend' =>'',
		'gmwforms' =>'', ), 
		'ReVendor' => Array ( 
		'content' => 'https://wpsoul.net/serverupdate/demoimport/vendor-content.xml',
		'widgets' => 'https://wpsoul.net/serverupdate/demoimport/redokannew-widgets.wie',
		'frontend' => '',
		'gmwforms' =>'', ),
		'ReWise' => Array ( 
		'content' => 'https://wpsoul.net/serverupdate/demoimport/rewisedemo-content.xml',
		'widgets' => 'https://wpsoul.net/serverupdate/demoimport/rewise-widgets.wie',
		'frontend' => '',
		'gmwforms' => '',), 
		'ReDokanNew' => Array ( 
		'content' => 'https://wpsoul.net/serverupdate/demoimport/vendor-content.xml',
		'widgets' => 'https://wpsoul.net/serverupdate/demoimport/redokannew-widgets.wie',
		'frontend' =>'',
		'gmwforms' =>'', ), 
		'ReMarket' => Array ( 
		'content' => 'https://wpsoul.net/serverupdate/demoimport/vendor-content.xml',
		'widgets' => 'https://wpsoul.net/serverupdate/demoimport/redokannew-widgets.wie',
		'frontend' =>'',
		'gmwforms' =>'', ), 
		'ReCash' => Array ( 
		'content' => 'https://wpsoul.net/serverupdate/demoimport/recash-content.xml',
		'widgets' => 'https://wpsoul.net/serverupdate/demoimport/recash-widgets.wie',
		'frontend' => 'https://wpsoul.net/serverupdate/demoimport/recash-frontend.json',
		'gmwforms' =>'', ), 
		'RePick' => Array ( 
		'content' => 'https://wpsoul.net/serverupdate/demoimport/repick-content.xml',
		'widgets' => 'https://wpsoul.net/serverupdate/demoimport/repick-widgets.wie',
		'frontend' =>'',
		'gmwforms' =>'', ), 
		'ReTour' => Array ( 
		'content' => 'https://wpsoul.net/serverupdate/demoimport/retour-content.xml',
		'widgets' => 'https://wpsoul.net/serverupdate/demoimport/retour-widgets.wie',
		'frontend' => '',
		'gmwforms' => 'https://wpsoul.net/serverupdate/demoimport/retour-gmw.json', ),
		'ReFashion' => Array ( 
		'content' => 'https://wpsoul.net/serverupdate/demoimport/refashion-content.xml',
		'widgets' => 'https://wpsoul.net/serverupdate/demoimport/refashion-widgets.wie',
		'frontend' =>'',
		'gmwforms' =>'', ), 
		'ReDeal' => Array ( 
		'content' => 'https://wpsoul.net/serverupdate/demoimport/redeal-content.xml',
		'widgets' => 'https://wpsoul.net/serverupdate/demoimport/redeal-widgets.wie',
		'frontend' => 'https://wpsoul.net/serverupdate/demoimport/redeal-frontend.json',
		'gmwforms' =>'', ), 
		'ReCompare' => Array ( 
		'content' => 'https://wpsoul.net/serverupdate/demoimport/recompare-content.xml',
		'widgets' => 'https://wpsoul.net/serverupdate/demoimport/recompare-widgets.wie',
		'frontend' =>'',
		'gmwforms' => '',), 
		'ReCart' => Array ( 
		'content' => 'https://wpsoul.net/serverupdate/demoimport/recart-content.xml',
		'widgets' => 'https://wpsoul.net/serverupdate/demoimport/recart-widgets.wie',
		'frontend' =>'',
		'gmwforms' =>'', ) ) ) );
	
	}

	public function deactivate_license($license = false, $client = false){
		if(!empty($license)&&!empty($client)){
			$data_array =  array(
				"product_id"  => $this->product_id,
				"license_file" => null,
				"license_code" => $license,
				"client_name" => $client
			);
		}else{
			if(is_file($this->license_file)){
				$data_array =  array(
					"product_id"  => $this->product_id,
					"license_file" => $this->read_wp_fs($this->license_file),
					"license_code" => null,
					"client_name" => null
				);
			}else{
				$data_array =  array();
			}
		}
		$get_data = $this->call_api(
			'POST',
			$this->api_url.'api/deactivate_license', 
			json_encode($data_array)
		);
		$response = json_decode($get_data, true);
		if($response['status']){
			if(is_writeable($this->license_file)){
				unlink($this->license_file);
			}
		}
		return $response;
	}

	public function check_update(){
		$data_array =  array(
			"product_id"  => $this->product_id,
			"current_version" => $this->current_version
		);
		$get_data = $this->call_api(
			'POST',
			$this->api_url.'api/check_update', 
			json_encode($data_array)
		);
		$response = json_decode($get_data, true);
		return $response;
	}

	public function download_update($update_id, $type, $version, $license = false, $client = false){ 
		if(!empty($license)&&!empty($client)){
			$data_array =  array(
				"license_file" => null,
				"license_code" => $license,
				"client_name" => $client
			);
		}else{
			if(is_file($this->license_file)){
				$data_array =  array(
					"license_file" => $this->read_wp_fs($this->license_file),
					"license_code" => null,
					"client_name" => null
				);
			}else{
				$data_array =  array();
			}
		}
		ob_end_flush(); 
		ob_implicit_flush(true);  
		$version = str_replace(".", "_", $version);
		ob_start();
		$source_size = $this->api_url."api/get_update_size/main/".$update_id; 
		echo LB_TEXT_PREPARING_MAIN_DOWNLOAD."<br>";
		ob_flush();
		echo LB_TEXT_MAIN_UPDATE_SIZE." ".$this->get_remote_filesize($source_size)." ".LB_TEXT_DONT_REFRESH."<br>";
		ob_flush();
		$temp_progress = '';
		$source = $this->api_url."api/download_update/main/".$update_id; 
		$wp_args = array('body' => json_encode($data_array));	
		$wp_args['method'] = 'POST';
		$this_url = site_url();
		$this_ip = getenv('SERVER_ADDR')?:
			$this->get_ip_from_third_party()?:
			gethostbyname(gethostname());
		$wp_args['headers'] = array(
			'Content-Type' => 'application/json', 
			'LB-API-KEY' => $this->api_key, 
			'LB-URL' => $this_url, 
			'LB-IP' => $this_ip, 
			'LB-LANG' => $this->api_language
		);
		$wp_args['timeout'] = 30;
		echo LB_TEXT_DOWNLOADING_MAIN."<br>";
		ob_flush();
		$result = wp_remote_request($source, $wp_args);
		if(is_wp_error($result)){
			exit("<br>".LB_TEXT_CONNECTION_FAILED);
		}
		$data = $result['body'];
		$http_status = $result['response']['code'];
		if($http_status != 200){
			if($http_status == 401){
				exit("<br>".LB_TEXT_UPDATE_PERIOD_EXPIRED);
			}else{
				exit("<br>".LB_TEXT_INVALID_RESPONSE);
			}
		}
		$destination = $this->root_path."/update_main_".$version.".zip"; 
		$file = $this->write_wp_fs($destination, $data);
		if(!$file){
			exit("<br>".LB_TEXT_UPDATE_PATH_ERROR);
		}
		ob_flush();
		$zip = new ZipArchive;
		$res = $zip->open($destination);
		if($res === TRUE){
			$zip->extractTo($this->root_path."/"); 
			$zip->close();
			unlink($destination);
			echo LB_TEXT_MAIN_UPDATE_DONE."<br><br>";
			ob_flush();
		}else{
			echo LB_TEXT_UPDATE_EXTRACTION_ERROR."<br><br>";
			ob_flush();
		}
		if($type == true){
			$source_size = $this->api_url."api/get_update_size/sql/".$update_id; 
			echo LB_TEXT_PREPARING_SQL_DOWNLOAD."<br>";
			ob_flush();
			echo LB_TEXT_SQL_UPDATE_SIZE." ".$this->get_remote_filesize($source_size)." ".LB_TEXT_DONT_REFRESH."<br>";
			ob_flush();
			$temp_progress = '';
			$source = $this->api_url."api/download_update/sql/".$update_id;
			$wp_args = array('body' => json_encode($data_array));	
			$wp_args['method'] = 'POST';
			$this_url = site_url();
			$this_ip = getenv('SERVER_ADDR')?:
				$this->get_ip_from_third_party()?:
				gethostbyname(gethostname());
			$wp_args['headers'] = array(
				'Content-Type' => 'application/json', 
				'LB-API-KEY' => $this->api_key, 
				'LB-URL' => $this_url, 
				'LB-IP' => $this_ip, 
				'LB-LANG' => $this->api_language
			);
			$wp_args['timeout'] = 30;
			echo LB_TEXT_DOWNLOADING_SQL."<br>";
			ob_flush();
			$result = wp_remote_request($source, $wp_args);
			if(is_wp_error($result)){
				exit(LB_TEXT_CONNECTION_FAILED);
			}
			$data = $result['body'];
			$http_status = $result['response']['code'];
			if($http_status!=200){
				exit(LB_TEXT_INVALID_RESPONSE);
			}
			$destination = $this->root_path."/update_sql_".$version.".sql"; 
			$file = $this->write_wp_fs($destination, $data);
			if(!$file){
				exit(LB_TEXT_UPDATE_PATH_ERROR);
			}
			echo LB_TEXT_SQL_UPDATE_DONE."<br><br>";
			echo LB_TEXT_UPDATE_WITH_SQL_DONE;
			ob_flush();
		}else{
			echo LB_TEXT_UPDATE_WITHOUT_SQL_DONE;
			ob_flush();
		}
		ob_end_flush(); 
	}

	private function get_ip_from_third_party(){
		$wp_args = array('method' => 'GET');	
		$wp_args['timeout'] = 30;
		$result = wp_remote_request('http://ipecho.net/plain', $wp_args);
		if(is_wp_error($result)){
			return false;
		}
		return $result['body'];
	}

	private function get_remote_filesize($url){
		$wp_args = array('method' => 'HEAD');	
		$this_url = site_url();
		$this_ip = getenv('SERVER_ADDR')?:
			$this->get_ip_from_third_party()?:
			gethostbyname(gethostname());
		$wp_args['headers'] = array(
			'Content-Type' => 'application/json', 
			'LB-API-KEY' => $this->api_key, 
			'LB-URL' => $this_url, 
			'LB-IP' => $this_ip, 
			'LB-LANG' => $this->api_language
		);
		$wp_args['timeout'] = 30;
		$result = wp_remote_request($url, $wp_args);
		if(is_wp_error($result)){
			return false;
		}
		$filesize = $result['headers']['content-length'];
		if ($filesize){
			switch ($filesize){
				case $filesize < 1024:
					$size = $filesize .' B'; break;
				case $filesize < 1048576:
					$size = round($filesize / 1024, 2) .' KB'; break;
				case $filesize < 1073741824:
					$size = round($filesize / 1048576, 2) . ' MB'; break;
				case $filesize < 1099511627776:
					$size = round($filesize / 1073741824, 2) . ' GB'; break;
			}
			return $size; 
		}
	}
}