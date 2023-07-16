<?php

declare(strict_types=1);

namespace App\Controller;

require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'autoload.php';

use Core\Database\ConnectionManager;
use App\Service\CommandServices;
use Core\Utils\Session;
use Core\Auth\Auth;

/**
 * Employees Controller
 */
class CommandController
{
	private $command;

	function __construct()
	{
		$this->command = new CommandServices();
	}

	public function dashboard()
	{
		// Set page_title
		$auth_user = (new Auth())->getAuthUser();

		if (empty($auth_user)) {

			header('Location: ' . AuthController::UNAUTHORIZED_REDIRECT . '?redirect=' . $_SERVER['REQUEST_URI']);
			exit;
		}

		$statics = [];

		$nb_commands = $this->command->countAll();

		$statics['nb_commands'] = $nb_commands;

		$GLOBALS['statics'] = $statics;
	}

	public function dashboardApproved()
	{
		// Set page_title
		$auth_user = (new Auth())->getAuthUser();

		if (empty($auth_user)) {

			header('Location: ' . AuthController::UNAUTHORIZED_REDIRECT . '?redirect=' . $_SERVER['REQUEST_URI']);
			exit;
		}

		$stics = [];

		$nb_commands = $this->command->countAllApproved();

		$stics['nb_commands'] = $nb_commands;

		$GLOBALS['stics'] = $stics;
	}

	public function indexByService()
	{

		$commands = $this->command->getByServices(true);

		$GLOBALS['commands'] = $commands;

		$_SESSION['title'] = 'Employées';
	}

	public function index()
	{
		$_SESSION['title'] = 'Commandes';

		$commands = $this->command->getAll(true);

		$GLOBALS['commands'] = $commands;
	}


	public function addPrice()
	{
		$_SESSION['title'] = 'Articles | Prix';

		$connectionManager = new ConnectionManager();

		if (isset($_GET['id'])) {

			$id = $_GET['id'];

			$q = "SELECT * FROM articles e WHERE e.id = ? AND e.deleted = ? ";

			$query = $connectionManager->getConnection()->prepare($q);

			$query->execute([$id, 0]);

			foreach ($query as $quer) {

				$puv = $quer['puv'];
				$pu = $quer['pu'];

				if (isset($_POST['add_price'])) {

					$prixv = htmlspecialchars($_POST['prixv']);
					$prixb = htmlspecialchars($_POST['prixb']);

					if (empty($puv) && empty($pu)) {

						$id = $_GET['id'];

						$sq = "UPDATE articles SET puv = ? , pu = ? WHERE id = ?";

						$query = $connectionManager->getConnection()->prepare($sq);

						$query->execute([$prixv, $prixb, $id]);

						$_SESSION['succes'] = "Prix de la boisson mise à jour avec succèss !";
					} else {

						$id = $_GET['id'];

						$sq = "UPDATE articles SET puv = ? , pu = ? WHERE id = ?";

						$query = $connectionManager->getConnection()->prepare($sq);

						$query->execute([$prixv, $prixb, $id]);

						$_SESSION['succes'] = "Prix de la boisson mise à jour avec succèss !";
					}
				}
			}
		}
	}

	public function add()
	{
		$_SESSION['title'] = 'Fournisseurs | Commander';

		if (isset($_POST['add_command'])) {
			$command_id = $this->command->add($_POST);

			if ($command_id) {

				header("Location: " . VIEWS . "Suppliers");
				exit;
			}

			$_SESSION['succes'] = "Votre commande à été passée avec succès !";
		}

		// Check if form data is cached
		$formdata = Session::consume('__formdata__');
		if (!empty($formdata)) {
			$GLOBALS['form_data'] = json_decode($formdata, true);
		}
	}

	public function view()
	{
		if (!isset($_GET['id'])) {
			header('Location: ' . VIEWS . 'Suppliers');
			exit;
		}

		$auth_user = (new Auth())->getAuthUser();
		if (empty($auth_user)) {

			header('Location: ' . AuthController::UNAUTHORIZED_REDIRECT . '?redirect=' . $_SERVER['REQUEST_URI']);
			exit;
		}

		$command = $this->command->getById($_GET['id']);

		if (empty($command)) {

			header('Location: ' . VIEWS . 'Suppliers');
			exit;
		}

		$GLOBALS['command'] = $command;
	}

	public function approv()
	{

		if (!isset($_GET['id']) || empty($_GET['id'])) {
			header('Location: ' . VIEWS . 'Suppliers');
			exit;
		}

		// check if the employee exists
		$checkCommand = $this->command->getById($_GET['id']);
		if (!$checkCommand) {
			if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {
				header('Content-Type: application/json');
				echo json_encode(['status' => 'success', 'message' => "Aucun fournisseur trouvé avec l'id " . $_GET['id']]);
			}

			header('Location: ' . VIEWS . 'Suppliers');
			exit;
		}

		$deleted = $this->command->approv((int)$_GET['id']);

		$_SESSION['succes'] = "Cette commande à été approuvée avec succès";

		if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {
			header('Content-Type: application/json');
			echo json_encode(['status' => 'success', 'message' => 'Supplier supprimé avec succès.']);

			exit;
		}

		header('Location: ' . VIEWS . 'Suppliers/view.php');
	}

	public function drop()
	{

		if (!isset($_GET['id']) || empty($_GET['id'])) {
			header('Location: ' . VIEWS . 'Suppliers');
			exit;
		}

		// check if the employee exists
		$checkCommand = $this->command->getById($_GET['id']);
		if (!$checkCommand) {
			if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {
				header('Content-Type: application/json');
				echo json_encode(['status' => 'success', 'message' => "Aucun fournisseur trouvé avec l'id " . $_GET['id']]);
			}

			header('Location: ' . VIEWS . 'Suppliers');
			exit;
		}

		$deleted = $this->command->drop((int)$_GET['id']);

		$_SESSION['succes'] = "Cette commande à été annulée avec succès";

		if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {
			header('Content-Type: application/json');
			echo json_encode(['status' => 'success', 'message' => 'Supplier supprimé avec succès.']);

			exit;
		}

		header('Location: ' . VIEWS . 'Suppliers');
	}


	public function deleteArticle()
	{

		if (!isset($_GET['id']) || empty($_GET['id'])) {
			header('Location: ' . VIEWS . 'Services/view.php?id' . $_GET['id']);
			exit;
		}

		// check if the employee exists
		$checkCommand = $this->command->getById($_GET['id']);
		if (!$checkCommand) {
			if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {
				header('Content-Type: application/json');
				echo json_encode(['status' => 'success', 'message' => "Aucun fournisseur trouvé avec l'id " . $_GET['id']]);
			}

			header('Location: ' . VIEWS . 'Services/view.php?id' . $_GET['id']);
			exit;
		}

		$deleted = $this->command->deleteArticle((int)$_GET['id']);

		$_SESSION['succes'] = "Cet article à été supprimer avec succès";

		if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {
			header('Content-Type: application/json');
			echo json_encode(['status' => 'success', 'message' => 'Supplier supprimé avec succès.']);

			exit;
		}

		header('Location: ' . VIEWS . 'Services/view.php?id' . $_GET['id']);
	}

	public function delete()
	{

		if (!isset($_GET['id']) || empty($_GET['id'])) {
			header('Location: ' . VIEWS . 'Suppliers');
			exit;
		}

		// check if the employee exists
		$checkCommand = $this->command->getById($_GET['id']);
		if (!$checkCommand) {
			if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {
				header('Content-Type: application/json');
				echo json_encode(['status' => 'success', 'message' => "Aucun fournisseur trouvé avec l'id " . $_GET['id']]);
			}

			header('Location: ' . VIEWS . 'Suppliers');
			exit;
		}

		$deleted = $this->command->delete((int)$_GET['id']);

		$_SESSION['succes'] = "Cette commande à été rejétée avec succès";

		if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {
			header('Content-Type: application/json');
			echo json_encode(['status' => 'success', 'message' => 'Supplier supprimé avec succès.']);

			exit;
		}

		header('Location: ' . VIEWS . 'Suppliers');
	}
}
