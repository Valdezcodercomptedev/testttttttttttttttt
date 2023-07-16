<?php
declare(strict_types=1);

namespace App\Controller;

require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Service\SupplierServices;
use Core\Utils\Session;
use Core\Auth\Auth;

/**
 * Employees Controller
 */
class SupplierController
{
	private $supplier;

	function __construct()
	{
		$this->supplier = new SupplierServices();
	}

	public function dashboard()
	{
		// Set page_title
		$auth_user = (new Auth())->getAuthUser();

		if (empty($auth_user)) {

			header('Location: ' . AuthController::UNAUTHORIZED_REDIRECT . '?redirect=' . $_SERVER['REQUEST_URI']);
			exit;
		}

		$stat = [];

		$nb_suppliers = $this->supplier->countAll();

		$stat['nb_suppliers'] = $nb_suppliers;

		$GLOBALS['stat'] = $stat; 
	}

	public function index()
	{

		$_SESSION['title'] = 'Fournisseurs';

		$suppliers = $this->supplier->getAll(true);

		$GLOBALS['suppliers'] = $suppliers;
	}

	public function add()
	{

		$_SESSION['title'] = 'Fournisseurs | Ajout';

		if (isset($_POST['add_supplier'])) {
			$supplier_id = $this->supplier->add($_POST);

			if ($supplier_id) {

                header("Location: " . VIEWS . "Suppliers");
			}
			$_SESSION['succes'] = "Fournisseur ajouté avec succès !";
		}

		// Check if form data is cached
		$formdata = Session::consume('__formdata__');
		if(!empty($formdata)) {
			$GLOBALS['form_data'] = json_decode($formdata, true);
		}
	}
	
	public function update()
	{
		$_SESSION['title'] = 'Fournisseurs | Mettre à jour';

		if (!isset($_GET['id'])) {
			header('Location: '.VIEWS . 'Suppliers');
			exit;
		}

		// check if the supplier exists
		$checkSupplier = $this->supplier->getById($_GET['id']);
		if(!$checkSupplier) {
			header('Location: '.VIEWS . 'Suppliers');
			exit;
		}

		if (isset($_POST['update_supplier'])) {
			$data = $_POST;
			$data['id'] = $_GET['id'];
			$supplier_id = $this->supplier->update($data);

			if ($supplier_id) {

                header("Location: " . VIEWS . "Suppliers");
			}
			
			$_SESSION['succes'] = "Les informations du fournisseur ont été mise à jour avec succès";
		}

		$supplier = $this->supplier->getById($_GET['id']);

		$GLOBALS['supplier'] = $supplier;

		// Check if form data is cached
		$formdata = Session::consume('__formdata__');
		if(!empty($formdata)) {
			$GLOBALS['form_data'] = json_decode($formdata, true);
		}
	}

	public function view()
	{
		if (!isset($_GET['id'])) {
			header('Location: '.VIEWS . 'Suppliers');
			exit;
		}

		$auth_user = (new Auth())->getAuthUser();
		if (empty($auth_user)) {

			header('Location: ' . AuthController::UNAUTHORIZED_REDIRECT . '?redirect=' . $_SERVER['REQUEST_URI']);
			exit;
		}

		$supplier = $this->supplier->getById($_GET['id']);

		if (empty($supplier)) {

			header('Location: '.VIEWS . 'Suppliers');
			exit;
		}

		$GLOBALS['supplier'] = $supplier;
	}


	public function delete()
	{

		if(!isset($_GET['id']) || empty($_GET['id'])) {
			header('Location: ' . VIEWS . 'Suppliers');
			exit;
		}

		// check if the employee exists
		$checkSupplier = $this->supplier->getById($_GET['id']);
		if(!$checkSupplier) {
			if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {
				header('Content-Type: application/json');
				echo json_encode(['status' => 'success', 'message' => "Aucun fournisseur trouvé avec l'id ". $_GET['id']]);
	
				exit;
			}

			header('Location: '.VIEWS . 'Suppliers');	
		}

		$deleted = $this->supplier->delete((int)$_GET['id']);
			
		$_SESSION['succes'] = "Ce fournisseur à été supprimé avec succès";

		if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {
			header('Content-Type: application/json');
			echo json_encode(['status' => 'success', 'message' => 'Supplier supprimé avec succès.']);

			exit;
		}

		header('Location: ' . VIEWS . 'Suppliers');
	}

}