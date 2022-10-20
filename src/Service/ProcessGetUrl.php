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
* For process, use Linx cli 
*/
class ProcessGetUrl
{

    // need linux environment -> docker environement 
    public function testingProcess() {

    // https://www.docenligne.com/documentation/lister-les-urls-dun-site-web-avec-wget.html
    // command : wget --no-verbose --recursive --spider --force-html --level=1000 --no-directories --reject=jpg,jpeg,png,gif,js,css,PNG,JPG www.docenligne.com 2>&1 | sort | uniq | grep -oe 'http://[^ ]*' > resultat2.txt -n

    // actually : /var/www/Website-Analyser/public
    // $process = new Process(['sh ./script/findExternalLink.sh']);
    $process = new Process(['apt install lynx -y']);
    $process->run();
    
    $process1 = new Process(['lynx -dump -listonly https://privanciel.com']);
    $process1->run();
    
    // executes after the command finishes
    if (!$process1->isSuccessful()) {
        throw new ProcessFailedException($process1);
    }
        
        echo $process1->getOutput();
    
    }



}