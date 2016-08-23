<?
/**********************************************************************
Content for VoyagerWebsites
template.php
2015-10-14 11:38AM ET
Christopher P. Burton
**********************************************************************
Utility functions for rendering script, stylesheet & meta objects
**********************************************************************/

function templateInit(){
	$addScript = array();
	$addJavaScript = array();
	$addStyleSheet = array();
	$addStyle = array();
	$addMeta = array();
	$addBreadcrumbs = array();
	global $addScript, $addJavaScript, $addStyleSheet, $addStyle, $addMeta, $addBreadcrumbs;
}

global $addScript, $addJavaScript, $addStyleSheet, $addStyle, $addMeta, $addBreadcrumbs;

function templateAddJavaScript($resource){
	$addJavaScript['script'] = $resource;
	return $addJavaScript;
}

function templateAddScript($resource){
	$addScript['script'] = $resource;
	return $addScript;
}

function templateAddStyleSheet($resource){
	$addStyleSheet['style'] = $resource;
	return $addStyleSheet;
}

function templateAddStyle($resource){
	$addStyle['style'] = $resource;
	return $addStyle;
}

function templateAddMeta($name,$value,$type='standard'){
	$addMeta['name'] = $name;
	$addMeta['value'] = $value;
	$addMeta['type'] = $type;
	return $addStyle;
}

function templateAddBreadcrumbs($url,$label){
	$addBreadcrumbs['url'] = $url;
	$addBreadcrumbs['label'] = $label;
	return $addBreadcrumbs;
}

function templateRenderMeta($addMeta){
	if(!empty($addMeta)){
		$count = count($addMeta);
		for($i=0; $i<$count; $i++){
			if($addMeta[$i]['type'] == 'http-equiv'){
				echo "    <meta http-equiv=\"".$addMeta[$i]['name']."\" content=\"".$addMeta[$i]['value']."\" />\n";
			}elseif($addMeta[$i]['type'] == 'standard'){
				echo "    <meta name=\"".$addMeta[$i]['name']."\" content=\"".str_replace('"', "'", $addMeta[$i]['value'])."\" />\n";
			}
		}		
	}
}

function templateRenderJavaScript($addJavaScript){
	if(!empty($addJavaScript)){
		$count = count($addJavaScript);
		$last = $count-1;
		for($i=0; $i<$count; $i++){
			//if($i == 0){
				echo "    <script type=\"text/javascript\">\n";
				echo "    //<![CDATA[\n";
			//}
			echo "      ".$addJavaScript[$i]['script']."\n";
			//if($i == $last){
				echo "    //]]>\n";
				echo "    </script>\n";
			//}
		}
	}
}

function templateRenderScript($addScript){
	if(!empty($addScript)){
		$count = count($addScript);
		for($i=0; $i<$count; $i++){
			echo "    <script type=\"text/javascript\" src=\"".$addScript[$i]['script']."\"></script>\n";
		}
	}
}

function templateRenderStyle($addStyle){
	if(!empty($addStyle)){
		$count = count($addStyle);
		$last = $count-1;
		for($i=0; $i<$count; $i++){
			if($i == 0){
				echo "    <style type=\"text/css\" media=\"screen\">\n";
				echo "    /*<![CDATA[*/\n";
			}
			echo "      ".$addStyle[$i]['style']."\n";
			if($i == $last){
				echo "    /*]]>*/\n";
				echo "    </style>\n";
			}
		}
	}
}

function templateRenderStyleSheet($addStyleSheet){
	if(!empty($addStyleSheet)){
		$count = count($addStyleSheet);
		for($i=0; $i<$count; $i++){
			echo "    <link rel=\"stylesheet\" type=\"text/css\" href=\"".$addStyleSheet[$i]['style']."\" />\n";
		}
	}
}