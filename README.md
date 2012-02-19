# GWTdata: Download website data from Google Webmaster Tools as CSV.

## Introduction

This project provides an easy way to automate downloading of data tables from Google Webmaster Tools and tries to provide a PHP alternative to the Python script available here http://code.google.com/p/webmaster-tools-downloads/, for downloading CSV files from Google Webmaster Tools.

Unlike the python script (or a perfect clone), this solution does NOT require an extra client library or zend package be installed in order to run.
Also it has some advanced functionality.

### Features

Since the official download list (used by the python script) returns download URLs for 1.) Top Search Queries and 2.) Top Pages only, but via the web interface there're much more downloads available, i extended the GWTdata class, so you can now download website data for:

 - TOP_PAGES
 - TOP_QUERIES
 - CRAWL_ERRORS
 - CONTENT_ERRORS
 - CONTENT_KEYWORDS
 - INTERNAL_LINKS
 - EXTERNAL_LINKS
 - SOCIAL_ACTIVITY

## Usage

This document explains how to automate the file download process from Google Webmaster Tools by showing examples for using the php class GWTdata.

### Get started

To get started, the steps are as follows:

 - Download the php file gwtdata.php.
 - Create a folder and add the gwtdata.php script to it.

### Example 1 - `DownloadCSV()`

To download CSV data for a single domain name of choice, the steps are as follows:

 - In the same folder where you added the gwtdata.php, create and run the following PHP script.<br>_You'll need to replace the example values for "email" and "password" with valid login details for your Google Account and for "website" with a valid URL for a site registered in your GWT account._

```php
<?php
	include 'gwtdata.php';
	try {
		$email = "username@gmail.com";
		$password = "******";
		# If hardcoded, don't forget trailing slash!
		$website = "http://www.domain.com/";

		$gdata = new GWTdata();
		if($gdata->LogIn($email, $password) === true)
		{
			$gdata->DownloadCSV($website);
		}
	} catch (Exception $e) {
		die($e->getMessage());
	}
```

This will download and save 8 CSV files to your hard disk:

 - `./TOP_PAGES-www.domain.com-YYYYmmdd-H:i:s.csv`
 - `./TOP_QUERIES-www.domain.com-YYYYmmdd-H:i:s.csv`
 - `./CRAWL_ERRORS-www.domain.com-YYYYmmdd-H:i:s.csv`
 - `./CONTENT_ERRORS-www.domain.com-YYYYmmdd-H:i:s.csv`
 - `./CONTENT_KEYWORDS-www.domain.com-YYYYmmdd-H:i:s.csv`
 - `./INTERNAL_LINKS-www.domain.com-YYYYmmdd-H:i:s.csv`
 - `./EXTERNAL_LINKS-www.domain.com-YYYYmmdd-H:i:s.csv`
 - `./SOCIAL_ACTIVITY-www.domain.com-YYYYmmdd-H:i:s.csv`

For an example how to limit the download to top search queries, or top pages etc. _only_, take a look at example 4.

By default, the files will be saved to the same folder where you added the gwtdata.php (and run the script). However the `DownloadCSV()` method has a second optional parameter to adjust the savepath - see inline comments in gwtdata.php and/or 2nd example.

### Example 2 - `GetSites()`

To download CSV data for all domains that are registered in your Google Webmaster Tools Account and to save the downloaded files to an extra folder, the steps are as follows:

 - In the same folder where you added the gwtdata.php, create a folder named `csv`.
 - In the same folder where you added the gwtdata.php, create and run the following PHP script.<br>_You'll need to replace the example values for "email" and "password" with valid login details for your Google Account._

```php
<?php
	include 'gwtdata.php';
	try {
		$email = "username@gmail.com";
		$password = "******";

		$gdata = new GWTdata();
		if($gdata->LogIn($email, $password) === true)
		{
			$sites = $gdata->GetSites();
			foreach($sites as $site)
			{
				$gdata->DownloadCSV($site, "./csv");
			}
		}
	} catch (Exception $e) {
		die($e->getMessage());
	}
```

This will download 8 CSV files for each domain that is registered in your Google Webmaster Tools Account and save them to the csv folder.

### Example 3 - `GetDownloadedFiles()`

Same as example two, but using the `GetDownloadedFiles()` method to get feedback what files have been saved to your hard disk (returning absolute paths).

```php
<?php
	include 'gwtdata.php';
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
				print "Saved $file\n";
			}
		}
	} catch (Exception $e) {
		die($e->getMessage());
	}
```

### Example 4 - `SetTables()`

To download CSV data for a single domain name of choice and top search query data _only_, the steps are as follows:

 - In the same folder where you added the gwtdata.php, create and run the following PHP script.<br>_You'll need to replace the example values for "email" and "password" with valid login details for your Google Account and for "website" with a valid URL for a site registered in your GWT account._

```php
<?php
	include 'gwtdata.php';
	try {
		$email = "username@gmail.com";
		$password = "******";
		# If hardcoded, don't forget trailing slash!
		$website = "http://www.domain.com/";
		# Valid values are "TOP_PAGES", "TOP_QUERIES", "CRAWL_ERRORS",
		# "CONTENT_ERRORS", "CONTENT_KEYWORDS", "INTERNAL_LINKS",
		# "EXTERNAL_LINKS" and "SOCIAL_ACTIVITY".
		$tables = array("TOP_QUERIES");

		$gdata = new GWTdata();
		if($gdata->LogIn($email, $password) === true)
		{
			$gdata->SetTables($tables);
			$gdata->DownloadCSV($website);
		}
	} catch (Exception $e) {
		die($e->getMessage());
	}
```

This will download and save one file only: `./TOP_QUERIES-www.domain.com-Ymd-H:i:s.csv`

### Example 5 - `SetDaterange()`

To download CSV data for all domains that are registered in your Google Webmaster Tools Account and for a specific date range _only_, the steps are as follows:

 - In the same folder where you added the gwtdata.php, create and run the following PHP script.<br>_You'll need to replace the example values for "email" and "password" with valid login details for your Google Account._

```php
<?php
	include 'gwtdata.php';
	try {
		$email = "username@gmail.com";
		$password = "******";
		# Dates must be in valid ISO 8601 format.
		$daterange = array("2012-01-10", "2012-01-12");

		$gdata = new GWTdata();
		if($gdata->LogIn($email, $password) === true)
		{
			$gdata->SetDaterange($daterange);

			$sites = $gdata->GetSites();
			foreach($sites as $site)
			{
				$gdata->DownloadCSV($site);
			}
		}
	} catch (Exception $e) {
		die($e->getMessage());
	}
```

This will download 8 CSV files (see example #1) for each domain that is registered in your Google Webmaster Tools Account containing data for the specified date range.

### Example 6 - `SetLanguage()`

To download data for all domains that are registered in your Google Webmaster Tools Account  and top search query data _only_ and for a specific date range _only_ and you want to use a custom language for the CSV headline, the steps are as follows:

 - In the same folder where you added the gwtdata.php, create and run the following PHP script.<br>_You'll need to replace the example values for "email" and "password" with valid login details for your Google Account._

```php
<?php
	include 'gwtdata.php';
	try {
		$email = "eyecatchup@gmail.com";
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
```

This will download one CSV file for each domain that is registered in your Google Webmaster Tools Account containing top queries data for the specified date range and with a german headline.

That's it.