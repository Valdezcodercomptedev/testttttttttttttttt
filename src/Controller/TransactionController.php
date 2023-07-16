<?php

declare(strict_types=1);

namespace App\Controller;

require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'autoload.php';

use Core\Database\ConnectionManager;

use App\Service\TransactionServices;
use Core\Utils\Session;
use Core\Auth\Auth;

/**
 * Employees Controller
 */
class TransactionController
{
	private $transaction;

	function __construct()
	{
		$this->transaction = new TransactionServices();
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

		$strats = [];

		$nb_transactions = $this->transaction->countAll();

		$strats['nb_transactions'] = $nb_transactions;

		$GLOBALS['strats'] = $strats;
	}

	
}
