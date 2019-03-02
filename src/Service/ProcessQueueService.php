<?php
/**
 * Created by PhpStorm.
 * User: arnob.s
 * Date: 1/7/2019
 * Time: 9:55 AM
 */

namespace WorkspaceJobRouter\Service;


class ProcessQueueService
{
    private $fileLocation;



    public function __construct()
    {

    }

    public function setFileLocation($fileLocation)
    {
        $this->fileLocation = $fileLocation;
    }

    public function getFileLocation()
    {
        return $this->fileLocation;
    }

    public function writeResponseToFile($dataToWrite)
    {
        $file = $this->getFileLocation();
        if(!is_file($file))
            $fh = fopen($file, 'a') or die("Can't create file");
        // Write the contents back to the file
        file_put_contents($file, json_encode($dataToWrite,JSON_PRETTY_PRINT));
    }
}