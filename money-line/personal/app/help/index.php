<?

require_once '../../includes.php';
require_once PERSONAL_MODEL_PATH.'user.php';

use Moneyline\Common\Model\SysInfo;
use Moneyline\Personal\Consts;
use Moneyline\Personal\DataKeys;
use Moneyline\Personal\Model\User;
use Moneyline\Personal\SecureWebPageController;

class index extends SecureWebPageController {

    protected $moduleId = 15; // HELP

    protected function _config() {
        $locale = User::getLocaleCode();
        $this->autoAppendView = $locale.'/{view}.view.php';


    }

}


?>