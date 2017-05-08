<?php
namespace Acme\OtherExamplesBundle\Payum\FooBarGateway\Action;

use Payum\Core\Action\ActionInterface;
use Payum\Core\Request\GetStatusInterface;

class StatusAction implements ActionInterface
{
    /**
     * @param GetStatusInterface $request
     */
    public function execute($request)
    {
        $model = $request->getModel();

        if (false == isset($model['status'])) {
            $request->markNew();

            return;
        }

        if (isset($model['status']) && 'captured' == $model['status']) {
            $request->markCaptured();

            return;
        }

        if (isset($model['status']) && 'error' == $model['status']) {
            $request->markFailed();

            return;
        }

        $request->markUnknown();
    }

    public function supports($request)
    {
        return
            $request instanceof GetStatusInterface &&
            $request->getModel() instanceof \ArrayAccess
        ;
    }
}