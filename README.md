# Colnect Project (https://colnecttest.000webhostapp.com/)
## Technical issues solved
### Issue with fetching html content from url
    - If we use simple php function file_get_content, we cant control headers and request is not accepted in most of sites
    - When we use curl_exec, need to put appropriate content to header
        . If we put too much in header content, it works on local host, but when it goes to hosting, occurs "header too large" error
        . If we put too less in header content, request is not accpeted. For example colnect.com :)
        . Sites built with SPA (react, vue, angular) Frameworks (which is not using SSR, eg https://leadgibbon.com) responses with 301(Permanently Moved) status code.
          This issue is fixed by adding "curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);"
### Issue with mysql query
    - This project used mysqli->execute_query function for queries, which is supported on php version 8+.
       The hosting provider(000webhost.com) provides php version 7 (for free versions), so changed all queries into mysqli->query format(which was a time-consuimg work :( ))
## Pages
### Home
    Here you can check url and get element count results. And also statistic information related to that domain and element.
### Statistics
    Here you can see statistic information.
    You can select domain or url from the list and see statistic information related with that.
## Coding Style(Nameing)
### -DB
    table, field name: snake_case
### -Frontend
    function, variable name: camelCase
    Keep responsive design 
### -Backend
    function, variable name: camelCase
    query: reserved words UPPER CASE

### -Ajax Communication
    parameter name: camelCase
    data format: x-www-form-urlencoded
    method: POST

## Project structure & Development principle
### - Backend: 
    api root: api/root.php
    routing information: index.php
    constants and settings information: config/*.php
    api request data format: 
        .api -> api name to call (defined in constants.php)
        .relevant input params
    api response data format:
        .data -> output data for response(status == 0) or error(status == 1)
        .status -> 0(success) 1(fail)  Like unix system call response
    api names: config/constants.php

### - Frontend
    page structure: header.php + {custom_body} + footer.php
    main layout: flex-grid system

### !Do not use mixture of php and html for data sharing, all data should be  fetched using ajax call
### All input should be checked for validation for both FE and BE
### UI should adapt all devices (Responsive)

# For deployment
### - db settings: config/constant.php, db/test.sql
### - .htaccess ettings
    all GET requests are redirected to index.php
    rewrite engine ON
    allow all overrides ON

## Please check code carefully and kindly hit me issues, @Colnect Team! :)
