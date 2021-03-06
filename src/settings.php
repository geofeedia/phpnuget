<?php
require_once(__DIR__."/root.php");

define('__MAXUPLOAD_BYTES__',10*1024*1024*1024);
define('__PACKAGEHASH__',"SHA512"); //Or SHA256
define('__UPLOAD_DIR__', "C:\\Development\\Kendar\\PhpNuget\\src\\data\\packages");
define('__DATABASE_DIR__', "C:\\Development\\Kendar\\PhpNuget\\src\\data\\db");
define('__SITE_ROOT__', "/phpnuget/");
define('__RESULTS_PER_PAGE__', 20);
define('__ADMINID__',"admin");
define('__ADMINPASSWORD__',"admin");
define('__ADMINMAIL__',"nuget@127.0.0.1");
define('__PWDREGEX__',"/^.{8,40}$/");
define('__PWDDESC__',"Min len 8, max len 40");

//If false "Register" is disabled. Users would be only allowed to be registered by
//the admin
define('__ALLOWUSERADD__',false);

define('__ALLOWPACKAGESDELETE__',false);
define('__ALLOWPACKAGEUPDATE__', true);

//If true users are allowed to add a package only if the firstly added it
//or if theyr user id is inside the "owners" field of the package
define('__LIMITUSERSPACKAGES__',true);

require_once(__ROOT__."/inc/internalsettings.php");
?>