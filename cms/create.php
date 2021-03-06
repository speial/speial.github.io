#!/usr/bin/php

<?php

$f='index';

$dirs = array_filter(glob('../2*'), 'is_dir');

foreach ($dirs as $dir)
{
	echo "Processing: $dir ";
	$new_page=createPage($dir,$f);
	if (isset($new_page['info']))
	{
		echo ($new_page['info']);
		if (isset($new_page['fatal_error'])) die("\nSTOPPING\n");
	}
	else
	{
		$old_page=@file_get_contents("$dir/$f.html");
		if ($new_page['page']===$old_page)
		{
			echo "No difference";
		}
		else
		{
			file_put_contents("$dir/$f.html",$new_page);
			if (!$old_page) echo "CREATED";
			else            echo "UPDATED";
		}
	}
	echo "\n";
}

echo "Update successful\n";

// -----------------------------------------------------------------------------
// Functions
// -----------------------------------------------------------------------------


function createPage($d,$f)
{
	if (!file_exists("$d/$f.json")) return ['info'=>'no index.json'];
	$tPage=file_get_contents('templates/page.html');
	$json=file_get_contents("$d/$f.json");
	$content=json_decode($json,true);
	$error=json_last_error();
	if ($error) return ['info'=>'JSON Error','fatal_error'=>1];

	$content['path']=substr($d,2);

	$entries='';
	foreach ($content['entries'] as $entry)
	{
		$tEntry=file_get_contents('templates/entry.html');
		replace($tEntry,$entry);
		$entries.=$tEntry;
	}
	$content['entries']=$entries;
	replace($tPage,$content);
	return ['page'=>$tPage];
}

function replace(&$content,$replacements)
{
	foreach($replacements as $key=>$val)
	{
		if ($key=='image') $val=getFileTemplate($key,$val);
		if (gettype($val)!='string') continue;
		$content=str_ireplace('{'.$key.'}',$val,$content);
	}
}

function getFileTemplate($key,$val)
{
	if ($val=='') return '';
	$t=file_get_contents('templates/image.html');
	$t=str_ireplace('{'.$key.'}',$val,$t);
	return $t;
}	
