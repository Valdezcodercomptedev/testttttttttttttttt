<?php

declare(strict_types=1);

namespace App\Service;

require_once dirname(dirname(__DIR__)) . DS . DS . 'autoload.php';

use Core\Database\ConnectionManager;
use App\Entity\Transaction;

/**
 * Transaction Services
 */
class TransactionServices
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

	public function countAll(): int
	{
		$count = 0;
		$join = '';
		
		$month = date('m');

		$year = date('Y');

		$sql = "SELECT SUM(amounts) AS sum FROM transactions e WHERE e.month = ? AND e.year = ?";

		try {
			$query = $this->connectionManager->getConnection()->prepare($sql);

			$query->execute([$month , $year]);

			$result = $query->fetch(\PDO::FETCH_ASSOC);

			$count = (int)$result['sum'];
		} catch (\PDOException $e) {
			throw new \Exception("SQL Exception: " . $e->getMessage(), 1);
		}

		return $count;
	}

	
}
