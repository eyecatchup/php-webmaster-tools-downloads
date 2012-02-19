<?php
	include '../src/gwtdata.php';
	try {
		$email = "username@gmail.com";
		$passwd = "******";

		# If hardcoded, don't forget trailing slash!
		$website = "http://www.domain.com/";

		$gdata = new GWTdata();
		if($gdata->LogIn($email, $passwd) === true)
		{
			$gdata->DownloadCSV($website);
		}
	} catch (Exception $e) {
		die($e->getMessage());
	}
?>