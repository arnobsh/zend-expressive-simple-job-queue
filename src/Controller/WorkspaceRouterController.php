<?php
/**
 * Created by PhpStorm.
 * User: abdullah.s
 * Date: 2/7/2019
 * Time: 2:05 PM
 */

namespace WorkspaceJobRouter\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class WorkspaceRouterController extends AbstractActionController
{
    public function __construct()
    {

    }


    public function testAction(){
        $testArr = ["id","test"];
        echo json_encode($testArr, JSON_PRETTY_PRINT);
        return 1;
    }
}