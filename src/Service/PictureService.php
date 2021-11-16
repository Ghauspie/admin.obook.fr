<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;

class PictureService
{   
    public function PictureService($logo) : string
    {
        $originalFilename = pathinfo($logo->getClientOriginalName(), PATHINFO_FILENAME);
        $newFilename = "https://obook.julien-vital.dev/upload/".$logo.'-'.uniqid().'.'.$logo->guessExtension();

        try {
            $newFilename->move('upload',$newFilename
            );
        } catch (FileException $e) {
            //TODO
        
        }
        return $newFilename;
    
    }
}