<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\ScopingHttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ProcessGetUrl
{

    // need linux environment -> docker environement 
    public function testingProcess() {

    // https://www.docenligne.com/documentation/lister-les-urls-dun-site-web-avec-wget.html
    // command : wget --no-verbose --recursive --spider --force-html --level=1000 --no-directories --reject=jpg,jpeg,png,gif,js,css,PNG,JPG www.docenligne.com 2>&1 | sort | uniq | grep -oe 'http://[^ ]*' > resultat2.txt -n

        $process = new Process(['ls', '-lsa']);
        $process->run();
        
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        
        echo $process->getOutput();
    
    }



}