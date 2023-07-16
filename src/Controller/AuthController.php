<?php

declare(strict_types=1);

namespace App\Controller;

require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Service\AuthServices;
use Core\Auth\Auth;
use Core\Auth\PasswordHasher;


/**
 * Authentication Controller
 */
class AuthController
{
	const UNAUTHORIZED_REDIRECT = VIEWS . 'Auth/login.php';
	const AUTHORIZED_REDIRECT = BASE_URL;

	public function login()
	{
		$_SESSION['title'] = 'Se connecter';

		if (Auth::isConnected()) {
			header("Location: " . self::AUTHORIZED_REDIRECT);
			exit;
		}

		if (isset($_POST['login'])) {
			$username = htmlentities($_POST['username']);
			$password = htmlentities($_POST['password']);

			$employee = (new AuthServices())->login($username, $password);

			if (empty($employee)) {

				$_SESSION['error'] = "Le nom d'utilisateur ou le mot de passe est incorrect.";
			} else {

				Auth::setUser($employee);

				$_SESSION['succes'] = "Connexion réussie !";

				header("Location: " . self::AUTHORIZED_REDIRECT);
			}
		}
	}

	public static function logout()
	{
		Auth::unsetUser();

		$_SESSION['succes'] = "A bientôt !";

		header('Location: ' . self::UNAUTHORIZED_REDIRECT);
	}

	public static function require_auth()
	{
		if (!Auth::isConnected()) {

			$_SESSION['succes'] = "Veuillez vous connecter avant de continuer.";

			header('Location: ' . self::UNAUTHORIZED_REDIRECT . '?redirect=' . $_SERVER['REQUEST_URI']);
			exit;
		}

		$GLOBALS['auth_user'] = (new Auth())->getAuthUser();
	}

	public static function profile()
	{
		
		$_SESSION['title'] = 'Profil';
		
		$auth_user = (new Auth())->getAuthUser();
		if (empty($auth_user)) {
			$_SESSION['succes'] = "Veuillez vous connecter avant de continuer.";

			header('Location: ' . AuthController::UNAUTHORIZED_REDIRECT . '?redirect=' . $_SERVER['REQUEST_URI']);
			exit;
		}
		
		$employee = (new AuthServices())->getById($auth_user->getId());

		if (empty($employee)) {
			$_SESSION['error'] = "Une erreur est survenue. Veuillez vous reconnecter.";
			header("Location: " . BASE_URL);
		}

		if (isset($_POST['edit_profile'])) {
			$passwordHasher = new PasswordHasher();
			$data = $_POST;

			// check password
			if (!$passwordHasher->check($data['oldpass'], $employee->getPwd())) {
				$_SESSION['error'] =  "Mot de passe incorrect";
			} elseif(!empty($data['newpass']) && $data['newpass'] != $data['cnfpass']) {
				$_SESSION['error'] = "Les mots de passe ne correspondent pas";
			} else {
				$data['id'] = $employee->getId();
				$updated = (new AuthServices())->update($data);

				if ($updated) {
					$_SESSION['succes'] = "Vos informations ont été mis à jour avec succès. Veuillez vous reconnecter pour appliquer les modifications.";
				}
			}
			
		}

		$GLOBALS['employee'] = $employee;
	}
}
