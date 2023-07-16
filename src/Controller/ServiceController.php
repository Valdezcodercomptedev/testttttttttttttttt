<?php

declare(strict_types=1);

namespace App\Controller;

require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'autoload.php';

use Core\Database\ConnectionManager;

use App\Service\ServiceServices;
use Core\Utils\Session;
use Core\Auth\Auth;

/**
 * Employees Controller
 */
class ServiceController
{
	private $service;

	function __construct()
	{
		$this->service = new ServiceServices();
	}

	public function dashboard()
	{

		$_SESSION['title'] = 'Tableau de bord';

		// Set page_title
		$auth_user = (new Auth())->getAuthUser();

		if (empty($auth_user)) {

			header('Location: ' . AuthController::UNAUTHORIZED_REDIRECT . '?redirect=' . $_SERVER['REQUEST_URI']);
			exit;
		}

		$stats = [];

		$nb_services = $this->service->countAll();

		$stats['nb_services'] = $nb_services;

		$GLOBALS['stats'] = $stats;
	}

	public function select()
	{

		$_SESSION['title'] = 'Commandes | Enregistrement';

		$services = $this->service->getAll(true);

		$GLOBALS['services'] = $services;
	}

	public function index()
	{

		$_SESSION['title'] = 'Services';

		$services = $this->service->getAll(true);

		$GLOBALS['services'] = $services;
	}

	public function save()
	{

		$_SESSION['title'] = 'Commandes | Enregistrement';

		if (isset($_POST['add_service'])) {
			$service_id = $this->service->save($_POST);

			if ($service_id) {

				header("Location: " . VIEWS . "Commands");
			}
			$_SESSION['succes'] = "Article enregistré avec succès !";
		}

		// Check if form data is cached
		$formdata = Session::consume('__formdata__');
		if (!empty($formdata)) {
			$GLOBALS['form_data'] = json_decode($formdata, true);
		}
	}

	public function add()
	{

		$_SESSION['title'] = 'Services | Ajout';

		if (isset($_POST['add_service'])) {
			$service_id = $this->service->add($_POST);

			if ($service_id) {

				header("Location: " . VIEWS . "Services");
			}
			$_SESSION['succes'] = "Nouveau service ajouté avec succès !";
		}

		// Check if form data is cached
		$formdata = Session::consume('__formdata__');
		if (!empty($formdata)) {
			$GLOBALS['form_data'] = json_decode($formdata, true);
		}
	}

	public function update()
	{

		// check if the service exists
		$checkService = $this->service->getById($_GET['id']);
		if (!$checkService) {
			header('Location: ' . VIEWS . 'Services');
			exit;
		}

		if (isset($_POST['update_service'])) {
			$data = $_POST;
			$data['id'] = $_GET['id'];
			$service_id = $this->service->update($data);

			if ($service_id) {

				header("Location: " . VIEWS . "Services");
			}

			$_SESSION['succes'] = "Les informations du service ont été mise à jour avec succès !";
		}
		$service = $this->service->getById($_GET['id']);

		$GLOBALS['service'] = $service;

		// Check if form data is cached
		$formdata = Session::consume('__formdata__');
		if (!empty($formdata)) {
			$GLOBALS['form_data'] = json_decode($formdata, true);
		}
	}

	public function updateArticle()
	{
		$_SESSION['title'] = 'Déstockage';

		$connectionManager = new ConnectionManager();

		if (isset($_GET['id'])) {

			$id = $_GET['id'];

			$q = "SELECT * FROM articles e WHERE e.id = ? AND e.deleted = ? ";

			$query = $connectionManager->getConnection()->prepare($q);

			$query->execute([$id, 0]);

			foreach ($query as $quer) {

				$quantity = $quer['quantity'];

				if (isset($_POST['remove_article'])) {

					$qte = ($_POST['qte']);

					if ($qte > $quantity) {
						$_SESSION['error'] = "La quantité d'article que vous souhaitez déstocker est supérieur à notre quantité en stock !";

						// header('Location: ' . VIEWS . 'Employees/remove.php?id=' . $id);
					} else {

						$qtity = $quantity - $qte;

						$sq = "UPDATE articles SET quantity = ? WHERE id = ?";

						$query = $connectionManager->getConnection()->prepare($sq);

						$query->execute([$qtity, $id]);

						$_SESSION['succes'] = "Article déstocker avec succèss !";

						// header('Location: ' . VIEWS . 'Employees/products.php');
					}
				}
			}
		}
	}

	public function view()
	{
		if (!isset($_GET['id'])) {
			header('Location: ' . VIEWS . 'Services');
			exit;
		}

		$auth_user = (new Auth())->getAuthUser();
		if (empty($auth_user)) {

			header('Location: ' . AuthController::UNAUTHORIZED_REDIRECT . '?redirect=' . $_SERVER['REQUEST_URI']);
			exit;
		}

		$service = $this->service->getById($_GET['id']);

		if (empty($service)) {

			header('Location: ' . VIEWS . 'Services');
			exit;
		}

		$GLOBALS['service'] = $service;
	}


	public function delete()
	{

		if (!isset($_GET['id']) || empty($_GET['id'])) {
			header('Location: ' . VIEWS . 'Employees');
			exit;
		}

		// check if the employee exists
		$checkService = $this->service->getById($_GET['id']);
		if (!$checkService) {
			if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {
				header('Content-Type: application/json');
				echo json_encode(['status' => 'success', 'message' => "Aucun service trouvé avec l'id " . $_GET['id']]);

				exit;
			}

			$_SESSION['succes'] = "Service supprimer avec succès !";

			header('Location: ' . VIEWS . 'Services');
		}

		$deleted = $this->service->delete((int)$_GET['id']);

		$_SESSION['succes'] = "Service supprimer avec succès !";

		if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {
			header('Content-Type: application/json');
			echo json_encode(['status' => 'success', 'message' => 'Service supprimé avec succès.']);

			exit;
		}

		header('Location: ' . VIEWS . 'Services');
	}
}
