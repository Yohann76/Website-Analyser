<?php

namespace App\Controller;

use App\Service\getAllUrlInDomain;
use App\Service\PhpScraperLink;
use App\Service\ProcessGetUrl;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{


    /**
     * @Route("/", name="app_home")
     */
    public function index(getAllUrlInDomain $getAllUrlInDomain, ProcessGetUrl $processGetUrl, PhpScraperLink $phpScraperLink): Response
    {

        $domain = "privanciel.com";

        // $listLink = $phpScraperLink->getUrlWithDomain($domain);
        $listLink = $phpScraperLink->testingPHPTesting($domain); // time out with arthurimmo 


        

        dd($listLink); 

        //$processGetUrl->testingProcess(); // process not run for the moment 

        // scrapping with httpclient : is so long 
        // $getAllUrlInDomain->getContentsDomain($domain); 
        // $getAllUrlInDomain->testingURLArray($domain); 
      

        
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

}
