<?php

namespace App\Service;

use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    /**
     * 
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)

    {
        $this->container= $container;
    }

    public function upload(UploadedFile $file)
    {
        
        $filename= md5(uniqid()) . '.' . $file->guessClientExtension();
            
            try{
            $file->move(
                //TODO: get target directory
                $this->container->get('image_dir'),
                $filename 
            );
        }catch(FileException $e){
            $e->error_log;
        }

        return $filename;
    }

}
