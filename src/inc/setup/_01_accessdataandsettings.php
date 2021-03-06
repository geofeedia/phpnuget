<?php
if(!defined('__INSETUP__')){
	die("Error");
}


function quick_dev_insights_phpinfo() {
	ob_start();
	//phpinfo(11);
	phpinfo(-1);
	$phpinfo = array('phpinfo' => array());

	if(preg_match_all('#(?:<h2>(?:<a name=".*?">)?(.*?)(?:</a>)?</h2>)|(?:<tr(?: class=".*?")?><t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>(?:<t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>(?:<t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>)?)?</tr>)#s', 
			ob_get_clean(), $matches, PREG_SET_ORDER)){
		foreach($matches as $match){
			if(strlen($match[1])){
				$phpinfo[$match[1]] = array();
			}elseif(isset($match[3])){
				$keys1 = array_keys($phpinfo);
				$phpinfo[end($keys1)][$match[2]] = isset($match[4]) ? array($match[3], $match[4]) : $match[3];
			}else{
				$keys1 = array_keys($phpinfo);
				$phpinfo[end($keys1)][] = $match[2];     
			   
			}
		}
	}
	return $phpinfo;
}

$apache = false;
$phpCgiExe = "";
if(DIRECTORY_SEPARATOR!== '/'){
	$pi = quick_dev_insights_phpinfo();
	if(isset($pi["Apache Environment"])){
		$apache = true;
	}
}

if(!$apache){
	$phpCgiExe = "C:\\Program Files (x86)\\PHP\\v5.3\\php-cgi.exe";
}
$serverType = $apache==true?"apache":"iis";
$applicationRoot = rtrim(dirname(dirname(dirname(__FILE__))),DIRECTORY_SEPARATOR);
$dataRoot = rtrim(dirname(dirname(dirname(__FILE__))),DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR."data".DIRECTORY_SEPARATOR."db";
$packagesRoot = rtrim(dirname(dirname(dirname(__FILE__))),DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR."data".DIRECTORY_SEPARATOR."packages";
?>
<html>
	<head>
	</head>
	<body>
		<h4>First initialization</h4>
		<!--This must be made first. To initialize all the data structures.<br>
		If you intend to import the users these values <u>must be corresponding to your old administrative account.</u><br><br>-->
		<form method="POST" action="setup.php">
			<input type="hidden" id="dosetup" name="dosetup" value="importUsers"/>
			<input type="hidden" id="applicationRoot" name="applicationRoot" value="<?php echo $applicationRoot; ?>" readonly/>
			<input type="hidden" id="servertype" name="servertype" value="<?php echo $serverType; ?>"/>
			<table border=0>
				<tr><td>Admin UserId:</td><td><input type="text" id="login" name="login" value="admin"/></td></tr>
				<tr><td>Admin Password:</td><td><input type="password" id="password" name="password" value="password"/></td></tr>
				<tr><td>Password Regex:</td><td><input type="text" id="passwordRegex" name="passwordRegex" value="/^.{8,40}$/"/></td></tr>
				<tr><td>Password Description:</td><td><input size="100" type="text" id="passwordDesc" name="passwordDesc" value="Min len 8, max len 40"/></td></tr>
				
				<tr><td>Admin Email:</td><td><input type="text" id="email" name="email" value="nuget@<?php echo $_SERVER["SERVER_NAME"]; ?>"/></td></tr>
				<tr><td>Application Path:</td><td><input size="100" type="text" id="applicationPath" name="applicationPath" value="<?php echo $applicationPath;?>"/></td></tr>
				<tr><td>Data Root:</td><td><input size="100" type="text" id="dataRoot" name="dataRoot" value="<?php echo $dataRoot;?>"/></td></tr>
				<tr><td>Packages Root:</td><td><input size="100" type="text" id="packagesRoot" name="packagesRoot" value="<?php echo $packagesRoot;?>"/></td></tr>
				<tr><td>php-cgi.exe (for IIS):</td><td><input size="100" type="text" id="phpCgi" name="phpCgi" value="<?php echo $phpCgiExe;?>"/></td></tr>
				<tr><td>Allow package Update via upload:</td><td>
					<input type="checkbox" id="packageUpdate" name="packageUpdate" /></td></tr>
				<tr><td>Allow package Delete:</td><td>
					<input type="checkbox" id="packageDelete" name="packageDelete" /></td></tr>
			</table>
			<input type="submit" value="Install!"></input>
		</form>
	</body>
</html>