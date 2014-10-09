<?php
namespace Api\V1\Rpc\Ping;

use Zend\Mvc\Controller\AbstractActionController;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\ContentNegotiation\ViewModel;

class PingController extends AbstractActionController
{
    public function pingAction()
    {
//        $authorization = $this->getServiceLocator()->get('authorization');
//        $authentication = $this->getServiceLocator()->get('authentication');
//        $identity = $authentication->getIdentity();
//
//        if(!$authorization->isGranted($identity, 'test')) {
//            return new ApiProblemResponse(new ApiProblem(401, 'You are not authorized'));
//        }

        return new ViewModel(array(
            'ack' => time()
        ));
    }
}
