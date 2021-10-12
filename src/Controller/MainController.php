<?php

namespace App\Controller;

use App\Service\Monitoring;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="index_obook")
     */
    public function index(Monitoring $monitoring): Response
    {
/*         $file='https://obook.fr';
        $file_headers= @get_headers($file);
        if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
            $exists = false;
        }
        else {
            $exists = true;
        };
        $ip='37.187.123.180';
        $ping = exec("ping -n 1 $ip");
        if(mb_ereg("perte 100%", $ping)) {
              $pingIp= false;
        }
        else
            {
              $pingIp= true;
        };

            $BDD='https://julienv10.sg-host.com/api/doc';
            $file_headersBDD= @get_headers($BDD);
        if(!$file_headersBDD || $file_headersBDD[0] == 'HTTP/1.1 404 Not Found') {
            $existsBDD = false;
        }
        else {
            $existsBDD = true;
        }; */
        
        $monitoring=$monitoring->monitoring();
        return $this->render(
            'main/index.html.twig', [
            'controller_name' => 'MainController',
           /* 'existsurl'=> $exists,
            'ping'=>$pingIp,
            'pingBDD'=>$existsBDD,
            */'test'=>$monitoring,
            ]
        );
    }
}
