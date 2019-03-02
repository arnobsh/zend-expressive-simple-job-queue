<?php
/**
 * Created by PhpStorm.
 * User: arnobsh@gmail.com
 * Date: 1/7/2019
 * Time: 9:55 AM
 */

namespace WorkspaceJobRouter\Service;


use WorkspaceJobRouter\Service\JobService1;
use WorkspaceJobRouter\Service\JobService2;
use WorkspaceJobRouter\Service\JobService3;
use WorkspaceJobRouter\Service\ProcessQueueService;

class WorkspaceRouterService {

    private $workspaceQueue;
    private $processQueue;
    private $deadletterQueueFile;
    private $workspaceConfig;

    public function __construct($deadletterQueueFile,$workspaceConfig) {
        $this->processQueue =new ProcessQueueService();
        $this->deadletterQueueFile = $deadletterQueueFile;
        $this->workspaceConfig = $workspaceConfig;
        $this->workspaceQueue = WorkspaceQueueService::Instance();
    }

    public function route ($workspaceDetails = '') {

        if(empty($workspaceDetails)) {
            throw new \Exception('Workspace is empty');
        } else {
            try {
              switch ($workspaceDetails["WorkspaceName"])
                    {
                        case 'JobService1':
                            $classname = JobService1::class;
                            $classname::processService($workspaceDetails);
                            $this->workspaceQueue->enqueue($workspaceDetails);
                            break;
                        case 'JobService2':
                            $classname = JobService2::class;
                            $classname::processService($workspaceDetails);
                            $this->workspaceQueue->enqueue($workspaceDetails);
                            break;
                        case 'JobService3':
                            $classname = JobService3::class;
                            $classname::processService($workspaceDetails);
                            $this->workspaceQueue->enqueue($workspaceDetails);
                            break;
                        default:
                            $this->processDeadLetterQueue($workspaceDetails);
                            break;
                    }


            } catch (\Exception $e) {
                throw new \Exception('Workspace is not found.');
            }
        }
    }

    public function processDeadLetterQueue($dataToWrite)
    {
        $this->processQueue->setFileLocation($this->deadletterQueueFile);
        $this->processQueue->writeResponseToFile($dataToWrite);
    }
}