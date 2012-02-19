<?php
	include '../src/gwtdata.php';
	try {
		$email = "username@gmail.com";
		$passwd = "******";

		$gdata = new GWTdata();
		if($gdata->LogIn($email, $passwd) === true)
		{
			$sites = $gdata->GetSites();
			foreach($sites as $site)
			{
				$gdata->DownloadCSV($site, "./csv");
			}

			$files = $gdata->GetDownloadedFiles();
			foreach($files as $file)
			{
				print "Saved $file<br>";
			}
		}
	} catch (Exception $e) {
		die($e->getMessage());
	}
?>