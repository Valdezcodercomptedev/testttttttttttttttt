<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\CompanyServices;
use Core\Auth\Auth;

require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'autoload.php';

class CompanyController
{
    /**
     * @var CompanyServices $services Contract models services
     */
    private $service;

    function __construct()
	{
		$this->service = new CompanyServices();
	}


    public function verified()
	{
        $auth_user = (new Auth())->getAuthUser();
        if(empty($auth_user) || $auth_user->getRole() != 'DIR'){
            return true;
            exit;
        }
        else{
            return false;
        }
       
	}
    /**
     * Index method
     * @return void
     */

    public function index()
	{
        
        if (isset($_POST['update_company'])) {
            $updated = $this->service->update($_POST);

            if ($updated) {
                $_SESSION['succes'] = "Les informations de l'entreprise ont été mise à jour avec succès.";
            }
        }

        // $_SESSION['title'] = 'Entreprise';

        $company = $this->service->getCompany();

        $GLOBALS['company'] = $company;
	}

    /**
     * Index method
     * @return void
     */
    public function view()
	{

        $company = $this->service->getCompany();

        $GLOBALS['company'] = $company;
	}
}