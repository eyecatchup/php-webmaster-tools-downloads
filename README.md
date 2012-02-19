# GWTdata: Download website data from Google Webmaster Tools as CSV

## Introduction

This project provides an easy way to automate downloading of data tables from Google Webmaster Tools.


## Usage

This document explains how to automate the file download process from Google Webmaster Tools by showing examples for using the php class GWTdata.

### Get started

To get started, the steps are as follows:

 - Download the php file gwtdata.php.
 - Create a folder and add the gwtdata.php script to it.

### Example 1 - `DownloadCSV()`

In the same folder where you added the gwtdata.php, create and run the following PHP script.
You'll need to replace the example values for "email" and "password" with valid login details for your Google Account and for "website" with a valid URL for a site registered in your GWT account.

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
?>
```

This will download and save 8 CSV files to your hard disk:

`./TOP_PAGES-www.domain.com-Ymd-H:i:s.csv`
`./TOP_QUERIES-www.domain.com-Ymd-H:i:s.csv`
`./CRAWL_ERRORS-www.domain.com-Ymd-H:i:s.csv`
`./CONTENT_ERRORS-www.domain.com-Ymd-H:i:s.csv`
`./CONTENT_KEYWORDS-www.domain.com-Ymd-H:i:s.csv`
`./INTERNAL_LINKS-www.domain.com-Ymd-H:i:s.csv`
`./EXTERNAL_LINKS-www.domain.com-Ymd-H:i:s.csv`
`./SOCIAL_ACTIVITY-www.domain.com-Ymd-H:i:s.csv`

For an example how to limit the download to top search queries, or top pages etc. only, take a look at example 4.

By default, the files will be saved to the same folder where you added the gwtdata.php (and run the script). However the `DownloadCSV()` method has a second optional parameter to adjust the savepath - see inline comments in gwtdata.php and/or 2nd example.