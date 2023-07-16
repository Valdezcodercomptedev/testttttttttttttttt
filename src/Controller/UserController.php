<?php
declare(strict_types=1);

namespace App\Controller;

require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Service\UserServices;
use App\Service\ServiceServices;
use Core\Utils\Session;
use Core\Auth\Auth;

/**
 * Employees Controller
 */
class UserController
{
	private $user;

	function __construct()
	{
		$this->user = new UserServices();
	}

	public function dashboard()
	{
		// Set page_title
		$auth_user = (new Auth())->getAuthUser();

		if (empty($auth_user)) {

			header('Location: ' . AuthController::UNAUTHORIZED_REDIRECT . '?redirect=' . $_SERVER['REQUEST_URI']);
			exit;
		}

		$sts = [];

		$nb_users = $this->user->countAll();

		$sts['nb_users'] = $nb_users;

		$GLOBALS['sts'] = $sts; 
	}

	public function index()
	{

		$users = $this->user->getByServices(true);

		$GLOBALS['users'] = $users;

		$_SESSION['title'] = 'Employées';
	}

	public function add()
	{

		$_SESSION['title'] = 'Employées | Ajout';

		if (isset($_POST['add_user'])) {
			$data = $_POST;
			$data['id'] = $_GET['id'];

			$user_id = $this->user->add($_POST);

			if ($user_id) {

                header("Location: " . VIEWS . "Services/view.php?id=" . $_GET['id'] );
			}
			$_SESSION['succes'] = "Utilisateur ajouté avec succès !";
		}

		// Check if form data is cached
		$formdata = Session::consume('__formdata__');
		if(!empty($formdata)) {
			$GLOBALS['form_data'] = json_decode($formdata, true);
		}
	}

	public function view()
	{
		if (!isset($_GET['id'])) {
			header('Location: '.VIEWS . 'Services/view.php?id=' . $_GET["id"] );
			exit;
		}

		$auth_user = (new Auth())->getAuthUser();
		if (empty($auth_user)) {

			header('Location: ' . AuthController::UNAUTHORIZED_REDIRECT . '?redirect=' . $_SERVER['REQUEST_URI']);
			exit;
		}

		$user = $this->user->getById($_GET['id']);

		if (empty($user)) {

			header('Location: '.VIEWS . 'Services/view.php?id=' . $_GET["id"] );
			exit;
		}

		$GLOBALS['user'] = $user;
	}


	public function delete()
	{

		if(!isset($_GET['id']) || empty($_GET['id'])) {
			header('Location: ' . VIEWS . 'Services/view.php?id=' . $_GET["id"] );
			exit;
		}

		// check if the employee exists
		$checkUser = $this->user->getById($_GET['id']);
		if(!$checkUser) {
			if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {
				header('Content-Type: application/json');
				echo json_encode(['status' => 'success', 'message' => "Aucun fournisseur trouvé avec l'id ". $_GET['id']]);
	
				exit;
			}

			header('Location: '.VIEWS . 'Services/view.php?id=' . $_GET["id"] );
			exit;
		}

		$deleted = $this->user->delete((int)$_GET['id']);

		if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {
			header('Content-Type: application/json');
			echo json_encode(['status' => 'success', 'message' => 'Supplier supprimé avec succès.']);

			exit;
		}

		$_SESSION['succes'] = "Utilisateur supprimer avec succès !";

		header('Location: ' . VIEWS . 'Services/view.php?id=' . $_GET["id"] );
	}

}