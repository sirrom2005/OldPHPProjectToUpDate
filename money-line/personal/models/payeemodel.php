<?php

namespace Moneyline\Personal\Model;

// models
require_once \PERSONAL_MODEL_PATH.'user.php';

// web services
require_once \COMMON_SERVICE_PATH.'PayeeManagementWS.php';

use Raxan;
use Moneyline\Personal\Shared;
use Moneyline\Personal\Model\User;

class PayeeModel extends \Moneyline\Common\DataModel
{

    public static function getPayees()
    {
        try
        {
            $payeeService = self::getWebService("PayeeManagementWS");
            $param = new \PayeeManagementWS\getPreAuthorizedPayees();
            //$param->customerNo = User::getCustomerId();
            $param->uid = User::getUniversalId();
            
            $rt = $payeeService->getPreAuthorizedPayees($param);

            return $rt->return->result;
        }
        catch(exception $e1)
        {
            return null;
        }
    }

    public static  function getPreAuthorizedPayeeDetails($payeeID)
    {
        try
        {
            $payeeService = self::getWebService("PayeeManagementWS");
            $param = new \PayeeManagementWS\getPreAuthorizedPayeeDetails();
            $param->payeeID = $payeeID;
            $param->tranTypeCode = "";
            $rt = $payeeService->getPreAuthorizedPayeeDetails($param);

            return $rt->return->result;
        }
        catch(exception $e1)
        {
            return null;
        }
    }
}
