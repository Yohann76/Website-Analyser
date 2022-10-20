<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\ScopingHttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class getAllUrlInDomain
{

    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }


    public function testingURLArray($domain) {

        // create final array (2 dimension) for result 
        $arrayResultStatusCode = []; 


        $ListLinkInHTML = $this->getContentsDomainAndDanalyzeURL($domain);

        // for each url in tab testing with checkStatusURL() function and create array two element 
        foreach ($ListLinkInHTML as $value) {
            $valueStatusCode = $this->checkStatusURL($value); // 200 in array 
            // push in $arrayResultStatusCode -> value -> $valueStatusCode
            array_push($arrayResultStatusCode, array($value=>$valueStatusCode ));
        }

        dd($arrayResultStatusCode); 
    
    }


    public function getContentsDomainAndDanalyzeURL($domain)
    {
        // use Client HTTP component 

        $domainWithHTTPS = "https://".$domain ; 

        $response = $this->client->request(
            'GET',
            $domainWithHTTPS
        );
        $statusCode = $response->getStatusCode();


        if ($statusCode == 200 ) {
            // create tab for have link 
            $ListLinkInHTML = [] ;

            $html = $response->getContent();
            # Get URL on content with regex 
            preg_match_all('/<a[^>]+href="([^"]+)/i', $html, $urls);
            # display tab without filter 
    
                // for each url, add tab 
                foreach ($urls[1] as $value) {
                    // if value does'nt exist in return tab 
                    if(!in_array($value, $ListLinkInHTML)){

                        if (preg_match("|^(http(s)?:)?\/\/|i", $value)) {
                            // push value in tab if not exist 
                            // is http, push 
                            if(!in_array($value, $ListLinkInHTML)){
                                array_push($ListLinkInHTML,$value);
                            }
                        }
                        else {
                            // not http 
                            // add with domain 
                            $valueWithHTTPS = "https://".$domain.$value ; 

                            // push value in tab if not exist 
                            if(!in_array($valueWithHTTPS, $ListLinkInHTML)){
                                array_push($ListLinkInHTML,$valueWithHTTPS);
                            }
                        }
                    }
                }

            // dump($ListLinkInHTML);

            return $ListLinkInHTML;
        }
        else {
            return ; 
        }
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