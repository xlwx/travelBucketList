<?
/**********************************************************************
init.php
**********************************************************************/
error_reporting(-1);
ini_set('display_errors', 'Off');
/**********************************************************************
No Direct Access
Defined constant must exist... or else!
NOTE -> define 'CTW' on page(s) calling this script
**********************************************************************/
if(!defined('TRO_BUCKETLIST')){
	header("HTTP/1.0 403 Forbidden");
	exit();
}
/**********************************************************************
Defined Contants
Declaration of defined directory contants that will be used.
**********************************************************************/
define('BASE_DIR', __DIR__);
define('ASSET_DIR', BASE_DIR.'/assets');
define('CSS_DIR', BASE_DIR.'/css');
define('IMAGE_DIR', BASE_DIR.'/images');
define('INCLUDES_DIR', BASE_DIR.'/includes');
define('AJAX_DIR', INCLUDES_DIR.'/ajax');
define('CLASS_DIR', INCLUDES_DIR.'/classes');
define('FUNCTION_DIR', INCLUDES_DIR.'/functions');
define('LANG_DIR', INCLUDES_DIR.'/languages');
define('JS_DIR', BASE_DIR.'/js');
define('TEMPLATE_DIR', BASE_DIR.'/templates');
define('TEMP_DIR', BASE_DIR.'/temp');
define('VAULT_DIR', BASE_DIR.'/vault');
define('USER_DIR', BASE_DIR.'/user');
define('GOAL_DIR', BASE_DIR.'/goal');
/**********************************************************************
Protocol and path to URL conversion
Declaration of defined URL contants that will be used.
**********************************************************************/
$protocol  = empty($_SERVER['HTTPS']) ? 'http' : 'https';
define('PROTOCOL', $protocol);
function getPath($path){
	$url = "http".(!empty($_SERVER['HTTPS'])?"s":"")."://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	$dirs = explode('/', trim(preg_replace('/\/+/', '/', $path), '/'));
	foreach($dirs as $key => $value){
		if(empty($value)){
			unset($dirs[$key]);
		}
	}
	$parsedUrl = parse_url($url);
	$pathUrl = explode('/', trim($parsedUrl['path'], '/'));
	foreach($pathUrl as $key => $value){
		if(empty($value)){
			unset($pathUrl[$key]);
		}
	}
	$count = count($pathUrl);
	foreach($dirs as $key => $dir){
		if($dir === '..'){
			if($count > 0){
				array_pop($pathUrl);
			}else{
				throw new Exception('Wrong Path');
			}
		}elseif($dir !== '.'){
			if(preg_match('/^(\w|\d|\.| |_|-)+$/', $dir)){
				$pathUrl[] = $dir;
				++$count;
			}else{
				throw new Exception('Not Allowed Char');
			}
		}
	}
	return $parsedUrl['scheme'].'://'.$parsedUrl['host'].'/';
//    return '//'.$parsedUrl['host'].'/';
}
define('BASE_URL', getPath(BASE_DIR));
//echo BASE_URL;
define('ASSET_URL', BASE_URL.'assets');
define('CSS_URL', BASE_URL.'css');
define('IMAGE_URL', BASE_URL.'images');
define('INCLUDES_URL', BASE_URL.'includes');
define('AJAX_URL', INCLUDES_URL.'/ajax');
define('CLASS_URL', INCLUDES_URL.'/classes');
define('FUNCTION_URL', INCLUDES_URL.'/functions');
define('LANG_URL', INCLUDES_URL.'/languages');
define('JS_URL', BASE_URL.'js');
define('TEMPLATE_URL', BASE_URL.'templates');
define('TEMP_URL', BASE_URL.'temp');
define('VAULT_URL', BASE_URL.'vault');
define('USER_URL', BASE_URL.'user');
define('GOAL_URL', BASE_URL.'goal');

/**********************************************************************
Database Related
**********************************************************************/
define('DB_NAME', 'bucketList');
define('DB_HOST', 'localhost');
define('DB_USER', 'troDev');
define('DB_PASS', '7d3yrq^Rwi2~Pgu');
define('DB_PORT', '');

/**********************************************************************
Session Related
**********************************************************************/
//define('SESSION_LIFETIME', 3600);

/**********************************************************************
Include language libraries
**********************************************************************/
//include(LANG_DIR.'/definitions.php');
//include(LANG_DIR.'/');
//include(LANG_DIR.'/');
//include(LANG_DIR.'/');
//include(LANG_DIR.'/');

/**********************************************************************
Include class libraries
**********************************************************************/
require(CLASS_DIR.'/pdoDatabase.php');
//include(CLASS_DIR.'/PasswordHash.php');
/**********************************************************************
Include function libraries
**********************************************************************/
include(FUNCTION_DIR.'/common.php');
include(FUNCTION_DIR.'/template.php');
include(FUNCTION_DIR.'/imageUpload.php');
include(FUNCTION_DIR.'/dbexecute.php');
//include(INCLUDE_DIR.'/');
//include(INCLUDE_DIR.'/');



/**********************************************************************
Initialize our template variables as a function
**********************************************************************/
//templateInit();
/**********************************************************************
Now we're off and running...
**********************************************************************/
