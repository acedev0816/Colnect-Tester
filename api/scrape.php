<?php
include_once "util.php";

/** Get scraped data */
function scrapeData($url, $element)
{
  // Parsing url seperately and if it is not valide return error message
  $url = parseUrl($url);

  if ($url["msg"] !== "success") {
    return $url;
  }

  // Check Request URL
  $recent_result = getRecentResult($url["domain"], $url["path"], $element);
  $scrapeData = null;

  if ($recent_result) { // if the request is same 
    $scrapeData = $recent_result;
  } else { // Scrape data
    $scrapeData = getData($url, $element);
  }

  // Save scraped data, when scraping is success
  if ($scrapeData["msg"] === "success") {
    $savedData = saveData($url, $element, $scrapeData);
  } else {
    return $scrapeData;
  }

  // Get statistic data when the saving is successs
  if ($savedData["msg"] === "success") {
    $staData["averageTime"] = getAverageFetchTime($savedData["staData"]["domainId"]);
    $staData["urlCount"] = getUrlCountFromDomain($savedData["staData"]["domainId"]);
    $staData["elementCount"] = getElementCount($savedData["staData"]["elementId"]);
    $staData["elementDomain"] = getElementCountFromDomain($savedData["staData"]["domainId"], $savedData["staData"]["elementId"]);

    $result = array("msg" => "success", "scrapeData" => $savedData["data"], "staData" => $staData);
  } else {
    $result["msg"] = $savedData["msg"];
  }

  return $result;
}

/** Check Resquest URl so that the request is valid */
function getRecentResult($domain, $url, $element)
{
  //check if url exists
  $query = "SELECT url.id as url_id FROM url LEFT JOIN domain ON url.domain_id=domain.id 
    WHERE url.path='".$url."' AND domain.name='".$domain."'";
  $row = Database::$connection->query($query)->fetch_assoc();

  if ($row) //if url exists, search for recent requests
  {
    $url_id = $row['url_id'];
    $query = "SELECT * FROM requests LEFT JOIN element ON requests.element_id=element.id WHERE url_id=".$url_id." AND element.name='".$element."' AND requests.time >= DATE_SUB(NOW(), INTERVAL 5 MINUTE)ORDER BY requests.time DESC LIMIT 1 ";
    $row = Database::$connection->query($query)->fetch_assoc();
    if ($row) {
      $result = array("time" => $row['time'], "duration" => $row['duration'], "count" => $row['count'], "msg" => "success");
      return $result;
    }
  }
  return null;
}

// Get url content 
function getUrlContent($url)
{
  $parts = parse_url($url);
  $host = $parts['host'];
  $ch = curl_init();
  $header = array(
    'GET /1575051 HTTP/1.1',
    "Host: {$host}",
    // 'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
    // 'Accept-Language:en-US,en;q=0.8',
    // 'Cache-Control:max-age=0',
    // 'Connection:keep-alive',
    // 'Host:adfoc.us',
    'User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36',
  );

  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
  curl_setopt($ch, CURLOPT_COOKIESESSION, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

  $result = curl_exec($ch);
  curl_close($ch);
  return $result;
}

/** Scrape data */
function getData($url, $element)
{
  $timestamp = microtime(true);
  $html = getUrlContent("https://" . $url["domain"] . "/" . $url["path"]); // Scrape url
  // var_dump("https://" . $url["domain"] . "/" . $url["path"]);
  // var_dump($url["domain"]);
  // var_dump($url["path"]);
  if (!$html) {
    $result["msg"] = "Invalid URL.";
    return $result;
  }

  // var_dump($html);

  $time = date('Y-m-d H:i:s');
  $timestamp = intval((microtime(true) - $timestamp) * 1000);
  
  try{
    $doc = new DOMDocument;
    libxml_use_internal_errors(true);
    $doc->loadHTML($html);
    libxml_clear_errors();
    
    $xpath = new DOMXPath($doc);
    
    $elements = $xpath->query("//" . $element);
    
    // If there is no element, return error message, else return data
    if (!$elements || $elements->length === 0) {
      $result["msg"] = "No such element that you find.";
      return $result;
    } else {
      $count = $elements->length;
      $result = array("time" => $time, "duration" => $timestamp, "count" => $count, "msg" => "success");
    }
  } catch (Exception $e){
    $result["msg"] = "No such element that you find.";
  }
  return $result;
}

/** Save Response data */
function saveData($url, $element, $scrapeData)
{
  // If there is no saved element, save it and return id
  $query = "SELECT id FROM element WHERE name='".$element."' LIMIT 1";
  $result = Database::$connection->query($query);

  if ($result->num_rows === 0) {
    $query = "INSERT INTO element (name) VALUES ('".$element."')";
    $result = Database::$connection->query($query);
    $elementId = Database::$connection->insert_id;
  } else {
    $elementId = $result->fetch_assoc()["id"];
  }

  // If there is no saved domain, save it and return id
  $domain = $url['domain'];
  $query = "SELECT id FROM domain WHERE name='".$domain."' LIMIT 1";
  $result = Database::$connection->query($query);

  if ($result->num_rows === 0) {
    $query = "INSERT INTO domain (name) VALUES ('".$domain."')";
    $result = Database::$connection->query($query);
    $domainId = Database::$connection->insert_id;
  } else {
    $domainId = $result->fetch_assoc()["id"];
  }

  // If there is no saved url, save it and return id
  $path = $url["path"];
  $query = "SELECT id FROM url WHERE path='".$path."' AND domain_id=".$domainId." LIMIT 1";
  $result = Database::$connection->query($query);

  if ($result->num_rows === 0) {
    $query = "INSERT INTO url (path, domain_id) VALUES ('".$path."',".$domainId.")";
    $result = Database::$connection->query($query);
    $urlId = Database::$connection->insert_id;
  } else {
    $urlId = $result->fetch_assoc()["id"];
  }

  // Save response data and if there is any error return error message
  $t = $scrapeData["time"];
  $duration = $scrapeData["duration"];
  $count = $scrapeData["count"];
  $query = "INSERT INTO requests (url_id, element_id, time, duration, count) VALUES (".$urlId.",".$elementId.",'".$t."',".$duration.",".$count.")";
  $result = Database::$connection->query($query);
  $requestId = Database::$connection->insert_id;

  if ($requestId) {
    $data = array("domain" => $url["domain"], "path" => $url["path"], "time" => $scrapeData["time"], "duration" => $scrapeData["duration"], "element" => $element, "count" => $scrapeData["count"]);
    $staData = array("domainId" => $domainId, "elementId" => $elementId);
    $result = array("msg" => "success", "data" => $data, "staData" => $staData);
  } else {
    $result = array("msg" => "Something went wrong when saving response data.");
  }

  return $result;
}