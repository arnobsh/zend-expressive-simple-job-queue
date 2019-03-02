<?php
namespace WorkspaceJobRouter\Service;


use WorkspaceJobRouter\Model\Workspace;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class WorkspaceTest extends TestCase
{

    public static function  setUpBeforeClass()
    {

    }

    public function setUp()
    {



    }

    public function testCreateWorkspace()
    {
        $actualResult = $this->queue->createWorkspace("Notepad");
        $this->assertEquals("Notepad",$actualResult->getName());
    }


}