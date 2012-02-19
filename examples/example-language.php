<?php
	include '../src/gwtdata.php';
	try {
		$email = "username@gmail.com";
		$passwd = "******";

		# Language must be set as valid ISO 639-1 language code.
		$language = "de";

		# Dates must be in valid ISO 8601 format.
		$daterange = array("2012-01-01", "2012-01-02");

		# Valid values are "TOP_PAGES", "TOP_QUERIES", "CRAWL_ERRORS",
		# "CONTENT_ERRORS", "CONTENT_KEYWORDS", "INTERNAL_LINKS",
		# "EXTERNAL_LINKS" and "SOCIAL_ACTIVITY".
		$tables = array("TOP_QUERIES");

		$gdata = new GWTdata();
		if($gdata->LogIn($email, $passwd) === true)
		{
			$gdata->SetLanguage($language);
			$gdata->SetDaterange($daterange);
			$gdata->SetTables($tables);

			$sites = $gdata->GetSites();
			foreach($sites as $site)
			{
				$gdata->DownloadCSV($site);
			}
		}
	} catch (Exception $e) {
		die($e->getMessage());
	}
?>