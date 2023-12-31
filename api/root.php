<?php
require_once "../config/constant.php";
require_once "./scrape.php";
require_once "./statistic.php";

/*
Return data format:
  data: response data 
  status: 1 => error, 0 => success (like unix status)
*/
if (isset($_POST['api'])) {
  $api = $_POST["api"];
  $data = array(); // Response data
  
  switch ($api) {
    case SCRAPE_URL: // Scrape url api
      $data = scrapeData($_POST["url"], $_POST["element"]);
      break;
    case GET_DOMAIN_LIST:
      $data = getDomainList();
      break;
    case GET_ELEMENT_LIST:
      $data = getElementList();
      break;
    case GET_AVERAGE_FETCH_TIME:
      $data = getAverageFetchTime($_POST["domainId"]);
      break;
    case GET_URL_COUNT_FROM_DOMAIN:
      $data = getUrlCountFromDomain($_POST["domainId"]);
      break;
    case GET_ELEMENT_COUNT:
      $data = getElementCount($_POST["elementId"]);
      break;
    case GET_ELEMENT_COUNT_FROM_DOMAIN:
      $data = getElementCountFromDomain($_POST["domainId"], $_POST["elementId"]);
  }
  echo json_encode(array("status" => 0, "data" => $data));
} else { // Invalid api request
  echo json_encode(array("status" => 1, "data" => "Something wrong!"));
}
?>