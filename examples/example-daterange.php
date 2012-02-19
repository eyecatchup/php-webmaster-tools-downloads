<?php
	include '../src/gwtdata.php';
	try {
		$email = "username@gmail.com";
		$passwd = "******";

		# Dates must be in valid ISO 8601 format.
		$daterange = array("2012-01-10", "2012-01-12");

		$gdata = new GWTdata();
		if($gdata->LogIn($email, $passwd) === true)
		{
			$sites = $gdata->GetSites();
			foreach($sites as $site)
			{
				$gdata->SetDaterange($daterange);
				$gdata->DownloadCSV($site);
			}
		}
	} catch (Exception $e) {
		die($e->getMessage());
	}
?>