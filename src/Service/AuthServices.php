<?php

declare(strict_types=1);

namespace App\Service;

require_once dirname(dirname(__DIR__)) . DS . 'autoload.php';

use Core\Database\ConnectionManager;
use Core\Utils\Session;
use App\Entity\Employee;
use Core\Auth\PasswordHasher;

class AuthServices
{

    public function login(string $username, string $password): ?Employee
    {
        $connectionManager = new ConnectionManager();

        $hashedPassword = (new PasswordHasher())->hash($password);

        $result = [];

        $sql = "SELECT e.id AS Employee_id, e.unique_id AS Employee_unique_id, e.service_id AS Employee_service_id, e.name AS Employee_name, e.phone AS Employee_phone, e.email AS Employee_email, e.ville AS Employee_ville, e.username AS Employee_username, e.pwd AS Employee_pwd, e.role AS Employee_role, e.created AS Employee_created, e.deleted AS Employee_deleted
            FROM employees e 
            WHERE e.username = ? AND e.pwd = ? AND e.deleted = ?";

        try {
            $query = $connectionManager->getConnection()->prepare($sql);

            $query->execute([$username, $hashedPassword, 0]);

            $result = $query->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception("SQL Exception: " . $e->getMessage(), 1);
        }

        if (empty($result)) {
            return null;
        }

        $employee = new Employee();
        $employee->setId($result['Employee_id']);
        $employee->setUniqueId($result['Employee_unique_id']);
        $employee->setServiceId($result['Employee_service_id']);
        $employee->setName($result['Employee_name']);
        $employee->setPhone($result['Employee_phone']);
        $employee->setEmail($result['Employee_email']);
        $employee->setVille($result['Employee_ville']);
        $employee->setUsername($result['Employee_username']);
        $employee->setPwd($result['Employee_pwd']);
        $employee->setRole($result['Employee_role']);
        $employee->setCreated($result['Employee_created']);
        $employee->setDeleted($result['Employee_deleted']);

        return $employee;
    }

    public function getById($id): ?Employee
    {
        $connectionManager = new ConnectionManager();

        $result = [];

        $sql = "SELECT e.id AS Employee_id, e.unique_id AS Employee_unique_id, e.service_id AS Employee_service_id, e.name AS Employee_name, e.phone AS Employee_phone, e.email AS Employee_email, e.username AS Employee_username, e.pwd AS Employee_pwd, e.role AS Employee_role, e.created AS Employee_created, e.deleted AS Employee_deleted
			FROM employees e 
			WHERE e.id = ? AND e.deleted = ?";

        try {
            $query = $connectionManager->getConnection()->prepare($sql);

            $query->execute([$id , 0]);

            $result = $query->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception("SQL Exception: " . $e->getMessage(), 1);
        }

        if (empty($result)) {
            return null;
        }

        $employee = new Employee();
        $employee->setId($result['Employee_id']);
        $employee->setUniqueId($result['Employee_unique_id']);
        $employee->setServiceId($result['Employee_service_id']);
        $employee->setName($result['Employee_name']);
        $employee->setPhone($result['Employee_phone']);
        $employee->setEmail($result['Employee_email']);
        $employee->setUsername($result['Employee_username']);
        $employee->setPwd($result['Employee_pwd']);
        $employee->setRole($result['Employee_role']);
        $employee->setCreated($result['Employee_created']);
        $employee->setDeleted($result['Employee_deleted']);

        return $employee;
    }



	/**
	 * Update user
	 *
	 * @param array|Employee $user user data
	 * @return bool Returns true if the user was updated, false otherwise
	 */
	public function update(array|Employee $user): bool
	{
        $connectionManager = new ConnectionManager();

		if (is_array($user)) {
			$user = $this->toEntity($user);
		}

		$existedUser = $this->getById($user->getId());

		if (empty($existedUser)) {

			return false;
		}

		if ($this->checkUser($user)) {

            Session::write('__formdata__', json_encode($_POST));

            return false;
		}

		$sql = "UPDATE employees SET name = ?, phone = ?, email = ?, username = ?, pwd = ? WHERE id = ?";

		try {

			$connectionManager->getConnection()->beginTransaction();

			$query = $connectionManager->getConnection()->prepare($sql);

			if (empty($user->getName())) {
				$query->bindValue(1, $existedUser->getName(), \PDO::PARAM_STR);
			} else {
				$query->bindValue(1, $user->getName(), \PDO::PARAM_STR);
			}

			if (empty($user->getPhone())) {
				$query->bindValue(2, $existedUser->getPhone(), \PDO::PARAM_STR);
			} else {
				$query->bindValue(2, $user->getPhone(), \PDO::PARAM_STR);
			}

			if (empty($user->getEmail())) {
				$query->bindValue(3, $existedUser->getEmail(), \PDO::PARAM_STR);
			} else {
				$query->bindValue(3, $user->getEmail(), \PDO::PARAM_STR);
			}

			if (empty($user->getUsername())) {
				$query->bindValue(4, $existedUser->getUsername(), \PDO::PARAM_STR);
			} else {
				$query->bindValue(4, $user->getUsername(), \PDO::PARAM_STR);
			}

			if (empty($user->getPwd())) {
				$query->bindValue(5, $existedUser->getPwd(), \PDO::PARAM_STR);
			} else {
				$query->bindValue(5, $user->getPwd(), \PDO::PARAM_STR);
			}
			$query->bindValue(6, $user->getId(), \PDO::PARAM_INT);

			$updated = $query->execute();

			$connectionManager->getConnection()->commit();

			return $updated;
		} catch (\PDOException $e) {
			throw new \Exception("SQL Exception: " . $e->getMessage(), 1);
		}
	}

	/**
	 * Parse service data to entity
	 *
	 * @param array $data Service data
	 * @return Employee|null Return Service entity if success, null otherwise.
	 */
	public function toEntity(array $data): ?Employee
	{
		$id = $data['id'] ? (int)$data['id'] : null;
		$name = !empty($data['name']) ? htmlentities($data['name']) : null;
		$phone = !empty($data['phone']) ? htmlentities($data['phone']) : null;
		$email = !empty($data['email']) ? htmlentities($data['email']) : null;
		$username = !empty($data['username']) ? htmlentities($data['username']) : null;
		$cnfpass = !empty($data['cnfpass']) ? (new PasswordHasher())->hash(htmlentities($data['cnfpass'])) : null;
		$deleted = !empty($data['deleted']) ? htmlentities($data['deleted']) : null;

		$user = new Employee();
		$user->setId($id);
		$user->setName($name);
		$user->setPhone($phone);
		$user->setEmail($email);
		$user->setUsername($username);
		$user->setPwd($cnfpass);
		$user->setDeleted($deleted);

		return $user;
	}
	
	/**
	 * Check if the user already exists
	 *
	 * @param Employee $user Employee
	 * @return boolean Returns true if user exists, false otherwise.
	 */
	public function checkUser(Employee $user): bool
	{
        $connectionManager = new ConnectionManager();
		$exist = true;

		$sql = "SELECT * FROM employees WHERE name = ? AND phone = ? AND email = ? AND username = ? AND pwd = ? ";
		if (!is_null($user->getId())) {
			$sql .= " AND id != ?";
		}

		$sql .= " LIMIT 0,1";

		try {
			$query = $connectionManager->getConnection()->prepare($sql);
			$query->bindValue(1, $user->getName());
			$query->bindValue(2, $user->getPhone());
			$query->bindValue(3, $user->getEmail());
			$query->bindValue(4, $user->getUsername());
			$query->bindValue(5, $user->getPwd());
			if (!is_null($user->getId())) {
				$query->bindValue(6, $user->getId(), \PDO::PARAM_INT);
			}

			$query->execute();

			$result = $query->fetch(\PDO::FETCH_ASSOC);

			if (empty($result)) {
				$exist = false;
			} else {
				$exist = true;
			}
		} catch (\PDOException $e) {
			throw new \Exception("SQL Exception: " . $e->getMessage(), 1);
		}

		return $exist;
	}
}
