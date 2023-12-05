<?php
/**
 * Function Name
 *
 * Function description
 *
 * @access	public
 * @param	type	name
 * @return	type	
 */
 
if (! function_exists('valid_url'))
{
	function valid_url($str)
	{
		$url = filter_var($str,FILTER_VALIDATE_URL);
		$valid_url = preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z_-]*(?:[A-Z0-9][A-Z0-9]*)+):?(\d+)?\/?/i',$url);
		return (bool) $valid_url;
	}
}

if (! function_exists('url_thumb'))
{
	function url_thumb($str)
	{
		$str = html_entity_decode($str);
		$offset    = strpos($str,'<img');
		$start     = strpos($str,'src=',$offset);
		$end       = strpos($str,">",($start+5));
		$first_img = str_replace("'", '"', substr($str,($start+5),($end-$start-5)));
		$end_img   = strpos($first_img,'"');
		return substr($first_img,0,$end_img);
	}
}

