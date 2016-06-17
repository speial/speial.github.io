#!/usr/bin/php

<?php

$f='index';

$dirs = array_filter(glob('../2*'), 'is_dir');

$dir=$dirs[4];

// print_r($dirs); die();

$page=createPage($dir,$f);
file_put_contents("$dir/$f.html",$page);

echo json_last_error();

function createPage($d,$f)
{
	$tPage=file_get_contents('page.html');
	$json=file_get_contents("$d/$f.json");
	$content=json_decode($json,true);

	$content['path']=substr($d,2);

	$entries='';
	foreach ($content['entries'] as $entry)
	{
		$tEntry=file_get_contents('entry.html');
		replace($tEntry,$entry);
		$entries.=$tEntry;
	}
	$content['entries']=$entries;
	replace($tPage,$content);
	return $tPage;
}

function replace(&$content,$replacements)
{
	foreach($replacements as $key=>$val)
	{
		if (gettype($val)!='string') continue;
		$content=str_ireplace('{'.$key.'}',$val,$content);
	}
}
