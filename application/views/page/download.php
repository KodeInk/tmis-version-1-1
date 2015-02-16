<?php 

if(!empty($area) && $area == 'download_csv')
{
	send_download_headers("file_".strtotime('now').".csv");
	echo array2csv($list);
	die();
}

?>