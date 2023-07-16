<?php

declare(strict_types=1);

namespace App\Service;

require_once dirname(dirname(__DIR__)) . DS . DS . 'autoload.php';

use Core\Database\ConnectionManager;
use App\Entity\Service;
use App\Entity\Article;

/**
 * Service Services
 */
class ServiceServices
{
	/**
	 * @var ConnectionManager $connectionManager
	 */
	private $connectionManager;

	/**
	 * Default configuration for queries
	 * @var array $query_default_config
	 */
	private $query_default_config = [
		'joinRole' => false,
		'limit' => 50,
		'offset' => 0,
		'conditions' => [],
		'order' => 'first_name',
		'order_dir' => 'DESC',
	];

	function __construct()
	{
		$this->connectionManager = new ConnectionManager();
	}

	/**
	 * Get All service
	 * @param  bool|boolean $joinRole Determines if roles should be joined
	 * @return array                  Array of Service or empty array
	 * @throw \Exception When error occurs
	 */
	public function getAll(bool $joinRole = false)
	{
		$result = [];
		$services = [];

		$select = "SELECT e.id AS Service_id, e.unique_id AS Service_unique_id, e.libelle AS Service_libelle, e.deleted AS Service_deleted";

		$sql = $select . " FROM services e WHERE e.deleted = ?";

		try {
			$query = $this->connectionManager->getConnection()->prepare($sql);

			$query->execute([0]);

			$result = $query->fetchAll(\PDO::FETCH_ASSOC);
		} catch (\PDOException $e) {
			throw new \Exception("SQL Exception: " . $e->getMessage(), 1);
		}

		if (empty($result)) {
			return [];
		}

		foreach ($result as $row) {
			$service = new Service();
			$service->setId($row['Service_id']);
			$service->setUniqueId($row['Service_unique_id']);
			$service->setLibelle($row['Service_libelle']);
			$service->setDeleted($row['Service_deleted']);


			$services[] = $service;
		}

		return $services;
	}

	public function countAll(): int
	{
		$count = 0;
		$join = '';

		$sql = "SELECT COUNT(*) AS count FROM services e WHERE e.deleted = ?";

		try {
			$query = $this->connectionManager->getConnection()->prepare($sql);

			$query->execute([0]);

			$result = $query->fetch(\PDO::FETCH_ASSOC);

			$count = (int)$result['count'];
		} catch (\PDOException $e) {
			throw new \Exception("SQL Exception: " . $e->getMessage(), 1);
		}

		return $count;
	}

	public function getById($id): ?Service
	{
		$result = [];

		$sql = "SELECT e.id AS Service_id, e.unique_id AS Service_unique_id, e.libelle AS Service_libelle, e.deleted AS Service_deleted 
			FROM services e 
			WHERE e.id = ? AND e.deleted = ?";

		try {
			$query = $this->connectionManager->getConnection()->prepare($sql);

			$query->execute([$id, 0]);

			$result = $query->fetch(\PDO::FETCH_ASSOC);
		} catch (\PDOException $e) {
			throw new \Exception("SQL Exception: " . $e->getMessage(), 1);
		}

		if (empty($result)) {
			return null;
		}

		$service = new Service();
		$service->setId($result['Service_id']);
		$service->setUniqueId($result['Service_unique_id']);
		$service->setLibelle($result['Service_libelle']);
		$service->setDeleted($result['Service_deleted']);

		return $service;
	}


	/**
	 * Add new service
	 *
	 * @param arrayService $service service data
	 * @return integer|bool Returns the id of the service on success, false otherwise
	 */
	public function save()
	{
		if (isset($_GET['id'])) {

			$id = $_GET['id'];
			$service_id = htmlspecialchars($_POST['service']);

			$query = $this->connectionManager->getConnection()->prepare("SELECT * FROM articles WHERE id = ?");

			$query->execute(array($id));

			foreach ($query as $quer) {

				$supplier_id = $quer['supplier_id'];
				$date = $quer['date'];
				$libelle = $quer['libelle'];
				$volume = $quer['volume'];
				$quantity = $quer['quantity'];
				$status = $quer['status'];

				$q = $this->connectionManager->getConnection()->prepare("UPDATE articles SET service_id = ?, status = ? WHERE id = ?");
				$q->execute(array($service_id, 'Enregistrée', $id));

				header("Location: " . VIEWS . "Commands");
			}
		}
	}

	/**
	 * Add new service
	 *
	 * @param arrayService $service service data
	 * @return integer|bool Returns the id of the service on success, false otherwise
	 */
	public function add()
	{

		$uniq = rand(time(), 10000000);

		$libelle = htmlspecialchars($_POST['libelle']);

		$sql = $this->connectionManager->getConnection()->prepare('SELECT * FROM services WHERE libelle = ?');
		$sql->execute(array($libelle));

		if ($sql->rowcount() > 0) {

			$_SESSION['error'] = "Un service avec les mêmes informations existe déjà.";
			return false;
		} else {

			$query = $this->connectionManager->getConnection()->prepare('INSERT INTO services(unique_id, libelle) VALUES (?,?)');
			$query->execute(array($uniq, $libelle));
		}
	}

	/**
	 * Update service
	 *
	 * @param array|Service $service Service data
	 * @return bool Returns true if the service was updated, false otherwise
	 */
	public function update(array|Service $service): bool
	{
		if (is_array($service)) {
			$service = $this->toEntity($service);
		}

		$existedService = $this->getById($service->getId());

		$sql = "UPDATE services SET libelle = ? WHERE id = ?";

		try {

			$this->connectionManager->getConnection()->beginTransaction();

			$query = $this->connectionManager->getConnection()->prepare($sql);

			if (empty($service->getLibelle())) {
				$query->bindValue(1, $existedService->getLibelle(), \PDO::PARAM_STR);
			} else {
				$query->bindValue(1, $service->getLibelle(), \PDO::PARAM_STR);
			}
			$query->bindValue(2, $service->getId(), \PDO::PARAM_INT);

			$updated = $query->execute();

			$this->connectionManager->getConnection()->commit();

			return $updated;
		} catch (\PDOException $e) {
			throw new \Exception("SQL Exception: " . $e->getMessage(), 1);
		}
	}

	/**
	 * Parse service data to entity
	 *
	 * @param array $data Service data
	 * @return Service|null Return Service entity if success, null otherwise.
	 */
	public function toEntity(array $data): ?Service
	{
		$id = $data['id'] ? (int)$data['id'] : null;
		$unique_id = $data['unique_id'] ? (int)$data['unique_id'] : null;
		$libelle = !empty($data['libelle']) ? htmlentities($data['libelle']) : null;
		$deleted = !empty($data['deleted']) ? htmlentities($data['deleted']) : null;

		$service = new Service();
		$service->setId($id);
		$service->setUniqueId($unique_id);
		$service->setLibelle($libelle);
		$service->setDeleted($deleted);

		return $service;
	}

	/**
	 * Delete service method
	 *
	 * @param integer $id Service id
	 * @return boolean Returns true if service was deleted, false otherwise.
	 */
	public function delete(int $id): bool
	{
		$existedService = $this->getById($id);
		if (empty($existedService)) {

			return false;
		}

		$sql = "UPDATE services SET deleted = ? WHERE id = ?";

		try {
			$query = $this->connectionManager->getConnection()->prepare($sql);

			$query->bindValue(1, 1, \PDO::PARAM_BOOL);
			$query->bindValue(2, $id, \PDO::PARAM_INT);

			$deleted = $query->execute();

			return $deleted;
		} catch (\PDOException $e) {
			throw new \Exception("SQL Exception: " . $e->getMessage(), 1);
		}
	}
}
