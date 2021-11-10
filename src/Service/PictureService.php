<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class PictureService
{   
    private $urlbase= "https://obook.julien-vital.dev/upload/";
    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function pictureConvert($picture): string
    {
        $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $newFilename = "https://obook.julien-vital.dev/upload/".$safeFilename.'-'.uniqid().'.'.$picture->guessExtension();

        try {
            $picture->move('upload',$newFilename
            );
        } catch (FileException $e) {
            //TODO
        }
        return $newFilename;
    }
    public function generateUser(): string
    {
        return "https://obook.julien-vital.dev/upload/picture".rand(1,8).".png";
    }
}