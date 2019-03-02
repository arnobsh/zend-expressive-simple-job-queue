<?php
/**
 * Created by PhpStorm.
 * User: arnob.s
 * Date: 1/7/2019
 * Time: 9:55 AM
 */

namespace WorkspaceJobRouter\Service;

use WorkspaceJobRouter\Model\Workspace;

/**
 * Singleton class
 *
 */
final class WorkspaceQueueService
{
    private $workspace;

    /**
     * Call this method to get singleton
     *
     * @return WorkspaceQueueService
     */
    public static function Instance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new WorkspaceQueueService();
        }
        return $inst;
    }

    public function isEmpty()
    {
        if(sizeof($this->workspace)<=0)
            return true;
        return false;
    }

    public function getSize()
    {
        return sizeof($this->workspace);
    }

    public function peek()
    {
        if($this->isEmpty())
            return null;
        return $this->workspace[$this->getSize()-1];
    }

    public function enqueue($newWorkspace)
    {
        array_push($this->workspace,$newWorkspace);
    }

    public function dequeue()
    {
        if($this->isEmpty())
            return null;
        $workspace = array_shift($this->workspace);
        return $workspace;
    }

    /**
     * Private constructor so nobody else can instantiate it
     *
     */
    private function __construct()
    {
        $this->workspace = array();
    }

    public function setWorkspace($workspaceData)
    {
        $workspace = new Workspace($workspaceData["WorkspaceId"],$workspaceData["WorkspaceName"],$workspaceData["JobMetadata"]);
        array_push($this->workspace,$workspace);
    }

    public function getWorkspace()
    {
        return $this->workspace;
    }
}