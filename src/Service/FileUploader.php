<?php

namespace App\Service;

use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class FileUploader
{

     /**
     * 
     * @var ParameterBagInterface
     */
    private $pb;

    public function __construct( ParameterBagInterface $pb)

    {
        $this->pb = $pb;
    }

    public function upload(UploadedFile $file)
    {
        
        $filename= md5(uniqid()) . '.' . $file->guessClientExtension();
            
            try{
            $file->move(
                //TODO: get target directory
                $this->pb->get('image_dir'),
                $filename 
            );
        }catch(FileException $e){
            $e->error_log;
        }

        return $filename;
    }

}
