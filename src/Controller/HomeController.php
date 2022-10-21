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
    public function index(): Response
    {

        // process with command (lynx cli)
        //$processGetUrl->testingProcess(); // process not run for the moment 

        
        // scrapping with httpclient 
        // privanciel.com : 8,19 seconde 
        // arhutimmo.com -> 1min/504 gateway Time out->  arthurimmo.com 
        //$listLink = $getAllUrlInDomain->testingURLArray($domain); 
        //dd($listLink);

        
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

}
