<?php
/**
 * Created by PhpStorm.
 * User: arnobsh@gmail.com
 * Date: 1/7/2019
 * Time: 9:55 AM
 */

namespace WorkspaceJobRouter\Service;

use WorkspaceJobRouter\Model\Workspace;

/**
 * Singleton class
 *
 */
class JobService2 implements WorkspaceRouter
{
    public  $jobDetails;

    private function __construct()
    {
        $this->jobDetails = array();
    }

    public static function processService($workspaceDetails)
    {
        $jobService = JobService2::Instance();
        $jobService->setJobData($workspaceDetails);
    }

    /**
     * Call this method to get singleton
     *
     * @return JobService1
     */
    public static function Instance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new JobService2();
        }
        return $inst;
    }

    public function validateData($jobData)
    {
        if(!isset($jobData) && empty($jobData))
            return false;
        if(!key_exists("JobMetadata",$jobData))
            return false;
        return true;
    }

    public function setJobData($jobData)
    {
        $isValidated = $this->validateData($jobData);
        if($isValidated) array_push($this->jobDetails,$jobData);
    }

    public function getJobData()
    {
        return $this->jobDetails;
    }
}