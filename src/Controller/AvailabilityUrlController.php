<?php

namespace App\Controller;

use App\Service\getAllUrlInDomain;
use App\Service\PhpScraperLink;
use App\Service\ProcessGetUrl;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AvailabilityUrlController extends AbstractController
{


    /**
     * @Route("/availability", name="app_availability")
     */
    public function index(getAllUrlInDomain $getAllUrlInDomain, ProcessGetUrl $processGetUrl, PhpScraperLink $phpScraperLink): Response
    {
        $domain = "arthurimmo.com";

        // PhpScraper with status code 
        // 12sec -> privanciel.com
        // 1min/504 gateway Time out->  arthurimmo.com

        $listLink = $phpScraperLink->testingPHPTesting($domain); // time out with arthurimmo 
        dd($listLink); 



        // process with command (lynx cli)
        //$processGetUrl->testingProcess(); // process not run for the moment 



        // scrapping with httpclient 
        // privanciel.com : 8,19 seconde 
        // arhutimmo.com -> 1min/504 gateway Time out->  arthurimmo.com 
        //$listLink = $getAllUrlInDomain->testingURLArray($domain); 
        //dd($listLink);

        
        return $this->render('availability/index.html.twig', [
            
        ]);
    }

}
