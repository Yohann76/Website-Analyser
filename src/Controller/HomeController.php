<?php

namespace App\Controller;

use App\Service\getAllUrlInDomain;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{


    /**
     * @Route("/", name="app_home")
     */
    public function index(getAllUrlInDomain $getAllUrlInDomain): Response
    {

        $domain = "privanciel.com";

        //$getAllUrlInDomain->getContentsDomain($domain); 
        $getAllUrlInDomain->testingURLArray($domain); 
      

        /*
        $a = $getAllUrlInDomain->testingURLArray($domain);
        dd($a);
        */
        
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

}
