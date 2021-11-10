<?php 

namespace App\Service;

class Monitoring
{
    public function monitoring()
    {
        $file='https://obook.fr';
        $file_headers= @get_headers($file);
        if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
            $siteobook = false;
            $textsiteobook='Le site est hors ligne';
        }
        else {
            $siteobook = true;
            $textsiteobook='Le site est en ligne';
        };
        $ip='37.187.123.180';
        $ping = exec("ping -n 1 $ip");
        if(mb_ereg("perte 100%", $ping)) {
            $servobook= false;
            $textservobook='Le serveur du site est hors ligne';
        }
        else
        {
          $servobook= true;
          $textservobook='Le serveur du site est en ligne';
        };

        $BDD='https://obook.julien-vital.dev/api/doc';
        $file_headersBDD= @get_headers($BDD);
        if(!$file_headersBDD || $file_headersBDD[0] == 'HTTP/1.1 404 Not Found') {
            $bddobook = false;
            $textbddobook='Le serveur de la bdd est hors ligne';
        }
        else {
            $bddobook = true;
            $textbddobook='Le serveur de la bdd est en ligne';
        };

        

        return $monitoring=[
            [
                'ResultatMonitoring'=>$siteobook,
                'Text'=>$textsiteobook
            ],
            [
                'ResultatMonitoring'=>$servobook,
                'Text'=>$textservobook
            ],
            [
                'ResultatMonitoring'=>$bddobook,
                'Text'=>$textbddobook
            ],    
        ];
    }
}
?>