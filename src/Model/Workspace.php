<?php
/**
 * Created by PhpStorm.
 * User: arnob.s
 * Date: 1/7/2019
 * Time: 9:55 AM
 */

namespace WorkspaceJobRouter\Model;


class Workspace
{
    public $WorkspaceId;
    public $WorkspaceName;
    public $JobMetadata;

    /**
     * constructor.
     * @param $WorkspaceId
     * @param $WorkspaceName
     * @param $JobMetadata
     */
    public function __construct($WorkspaceId, $WorkspaceName, $JobMetadata)
    {
        $this->WorkspaceId = $WorkspaceId;
        $this->WorkspaceName = $WorkspaceName;
        $this->JobMetadata = $JobMetadata;
    }

    /**
     * @return mixed
     */
    public function getWorkspaceId()
    {
        return $this->WorkspaceId;
    }

    /**
     * @param mixed $WorkspaceId
     */
    public function setWorkspaceId($WorkspaceId)
    {
        $this->WorkspaceId = $WorkspaceId;
    }

    /**
     * @return mixed
     */
    public function getWorkspaceName()
    {
        return $this->WorkspaceName;
    }

    /**
     * @param mixed $WorkspaceName
     */
    public function setWorkspaceName($WorkspaceName)
    {
        $this->WorkspaceName = $WorkspaceName;
    }

    /**
     * @return mixed
     */
    public function getJobMetadata()
    {
        return $this->JobMetadata;
    }

    /**
     * @param mixed $JobMetadata
     */
    public function setJobMetadata($JobMetadata)
    {
        $this->JobMetadata = $JobMetadata;
    }
}