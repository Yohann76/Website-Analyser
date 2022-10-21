<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\ScopingHttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

/*
* Use \spekulatius\phpscraper
* need https link 
* return array with link 
*/
class PhpScraperLink
{

    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function testingPHPTesting($domain) {

        // create final array (2 dimension) for result 
        $arrayResultStatusCode = []; 


        $ListLinkInHTML = $this->getUrlWithDomain($domain);

        // for each url in tab testing with checkStatusURL() function and create array two element 
        foreach ($ListLinkInHTML as $value) {
            $valueStatusCode = $this->checkStatusURL($value); // 200 in array 
            // push in $arrayResultStatusCode -> value -> $valueStatusCode
            array_push($arrayResultStatusCode, array($value=>$valueStatusCode ));
        }

        //dd($arrayResultStatusCode);  // time out with arthur immo 
        return $arrayResultStatusCode ; 
    
    }


    public function getUrlWithDomain($domain) {
        // https://phpscraper.de/?fbclid=IwAR0LU19BChCrx1eFzYAk_3SkaE66Vma3TWjoNkOKqCP34-peGcMm5JTQqrY
        // https://phpscraper.de/examples/scrape-links.html#simple-link-list
        $web = new \spekulatius\phpscraper;
        $web->go('https://'.$domain);
        // Print the number of links.
        // count($web->links) ;
        $arrayResult = []; 
        // Loop through the links
        foreach ($web->links as $link) {
            // echo " - " . $link . "\n";
            if(!in_array($link , $arrayResult)){
                array_push($arrayResult,$link);
            }
        }
        return $arrayResult ; 
    }

    private function checkStatusURL($urls) {
        // use Client HTTP component 
        $response = $this->client->request(
            'GET',
            $urls
        );
        $statusCode = $response->getStatusCode();
        return $statusCode; 
    }




}