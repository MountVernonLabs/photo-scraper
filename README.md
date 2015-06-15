# photo-scraper
The aim of this tool is to scrape publicly available photo sites and capture photos geotagged within a certain radius to record for research and historical archive purposes.

Currently the tool will allow you to scrape photos publicly stored on Flickr but we plan on extending it to other photo sharing platforms in the future.

## Installing
These scripts are designed to run in the PHP command line with write access into the folders to save the photos.  

1. Clone the repository to your machine
2. Edit config-sample.php and specify your API keys, latitude, longitude and radius then rename the file to config.php
3. There is no step 3

## Running

### Flickr
* Navigate to the flickr sub folder in your terminal
* In the terminal type > php scrape.php
* A sub folder will be created called img and the script will start to download all avaialble photos
* The script runs up to 50 pages (Flickr limit)
* You can run the script as many times as you want and it will continue to append to this folder
* If the images already exist the script will not re-download the files

