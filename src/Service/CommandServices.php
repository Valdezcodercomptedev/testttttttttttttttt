<?php

declare(strict_types=1);

namespace App\Service;

require_once dirname(dirname(__DIR__)) . DS . DS . 'autoload.php';

use Core\Database\ConnectionManager;
use App\Entity\Article;

/**
 * Service Services
 */
class CommandServices
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
		$articles = [];

		$select = "SELECT e.id AS Article_id, e.supplier_id AS Article_supplier_id, e.service_id AS Article_service_id, e.date AS Article_date, e.libelle AS Article_libelle, e.volume AS Article_volume, e.quantity AS Article_quantity, e.pu AS Article_pu, e.status AS Article_status, e.reading AS Article_reading, e.deleted AS Article_deleted";

		$sql = $select . " FROM articles e ORDER BY e.id DESC";

		try {
			$query = $this->connectionManager->getConnection()->prepare($sql);

			$query->execute();

			$result = $query->fetchAll(\PDO::FETCH_ASSOC);
		} catch (\PDOException $e) {
			throw new \Exception("SQL Exception: " . $e->getMessage(), 1);
		}

		if (empty($result)) {
			return [];
		}
		foreach ($result as $row) {
			$article = new Article();
			$article->setId($row['Article_id']);
			$article->setSupplierId($row['Article_supplier_id']);
			$article->setServiceId($row['Article_service_id']);
			$article->setDate($row['Article_date']);
			$article->setLibelle($row['Article_libelle']);
			$article->setVolume($row['Article_volume']);
			$article->setQuantity($row['Article_quantity']);
			$article->setPu($row['Article_pu']);
			$article->setStatus($row['Article_status']);
			$article->setReading($row['Article_reading']);
			$article->setDeleted($row['Article_deleted']);

			$articles[] = $article;
		}

		return $articles;
	}

	public function countAll(): int
	{

		$count = 0;
		$join = '';

		$sql = "SELECT COUNT(*) AS count FROM articles e WHERE e.status = ? AND e.deleted = ?";

		try {
			$query = $this->connectionManager->getConnection()->prepare($sql);

			$query->execute(['En attente', 0]);

			$result = $query->fetch(\PDO::FETCH_ASSOC);

			$count = (int)$result['count'];
		} catch (\PDOException $e) {
			throw new \Exception("SQL Exception: " . $e->getMessage(), 1);
		}

		return $count;
	}

	/**
	 * Get All service
	 * @param  bool|boolean $joinRole Determines if roles should be joined
	 * @return array                  Array of Service or empty array
	 * @throw \Exception When error occurs
	 */
	public function getByServices(bool $joinRole = false)
	{
		$result = [];
		$users = [];

		$select = "SELECT e.id AS Article_id, e.supplier_id AS Article_supplier_id, e.service_id AS Article_service_id, e.date AS Article_date, e.libelle AS Article_libelle, e.volume AS Article_volume, e.quantity AS Article_quantity, e.puv AS Article_puv, e.pu AS Article_pu, e.status AS Article_status, e.reading AS Article_reading, e.deleted AS Article_deleted";

		$sql = $select . " FROM articles e WHERE e.service_id = ? AND e.status = ? AND e.deleted = ? ORDER BY e.libelle ASC";

		try {
			$query = $this->connectionManager->getConnection()->prepare($sql);

			$query->execute([$_GET['id'], 'Enregistrée', 0]);

			$result = $query->fetchAll(\PDO::FETCH_ASSOC);
		} catch (\PDOException $e) {
			throw new \Exception("SQL Exception: " . $e->getMessage(), 1);
		}

		if (empty($result)) {
			return [];
		}

		foreach ($result as $row) {
			$article = new Article();
			$article->setId($row['Article_id']);
			$article->setSupplierId($row['Article_supplier_id']);
			$article->setServiceId($row['Article_service_id']);
			$article->setDate($row['Article_date']);
			$article->setLibelle($row['Article_libelle']);
			$article->setVolume($row['Article_volume']);
			$article->setQuantity($row['Article_quantity']);
			$article->setPuv($row['Article_puv']);
			$article->setPu($row['Article_pu']);
			$article->setStatus($row['Article_status']);
			$article->setReading($row['Article_reading']);
			$article->setDeleted($row['Article_deleted']);


			$commands[] = $article;
		}

		return $commands;
	}

	public function countAllApproved(): int
	{

		$count = 0;
		$join = '';

		$sql = "SELECT COUNT(*) AS count FROM articles e WHERE e.status = ? AND e.deleted = ?";

		try {
			$query = $this->connectionManager->getConnection()->prepare($sql);

			$query->execute(['Enregistrée', 0]);

			$result = $query->fetch(\PDO::FETCH_ASSOC);

			$count = (int)$result['count'];
		} catch (\PDOException $e) {
			throw new \Exception("SQL Exception: " . $e->getMessage(), 1);
		}

		return $count;
	}

	public function getById($id): ?Article
	{
		$result = [];

		$sql = "SELECT e.id AS Article_id, e.supplier_id AS Article_supplier_id, e.service_id AS Article_service_id, e.date AS Article_date, e.libelle AS Article_libelle, e.volume AS Article_volume, e.quantity AS Article_quantity, e.pu AS Article_pu, e.status AS Article_status, e.reading AS Article_reading, e.deleted AS Article_deleted
		FROM articles e 
		WHERE e.id = ? AND e.status = ? AND e.deleted = ?";

		try {
			$query = $this->connectionManager->getConnection()->prepare($sql);

			$query->execute([$id, 'En attente', 0]);

			$result = $query->fetch(\PDO::FETCH_ASSOC);
		} catch (\PDOException $e) {
			throw new \Exception("SQL Exception: " . $e->getMessage(), 1);
		}

		if (empty($result)) {
			return null;
		}

		$article = new Article();
		$article->setId($result['Article_id']);
		$article->setSupplierId($result['Article_supplier_id']);
		$article->setServiceId($result['Article_service_id']);
		$article->setDate($result['Article_date']);
		$article->setLibelle($result['Article_libelle']);
		$article->setVolume($result['Article_volume']);
		$article->setQuantity($result['Article_quantity']);
		$article->setPu($result['Article_pu']);
		$article->setStatus($result['Article_status']);
		$article->setReading($result['Article_reading']);
		$article->setDeleted($result['Article_deleted']);

		return $article;
	}

	/**
	 * Add new service
	 *
	 * @param arrayArticle $service service data
	 * @return integer|bool Returns the id of the service on success, false otherwise
	 */
	public function add()
	{

		$supplier_id = $_GET['id'];

		$libelle = htmlspecialchars($_POST['libelle']);
		$libelleLog = htmlspecialchars($_POST['libelleLog']);
		$libelleAli = htmlspecialchars($_POST['libelleAli']);
		$volume = htmlspecialchars($_POST['volume']);
		$quantity = htmlspecialchars($_POST['quantity']);
		$qteLog = htmlspecialchars($_POST['qteLog']);
		$qteAli = htmlspecialchars($_POST['qteAli']);

		if (empty($_POST['libelleLog']) && empty($_POST['libelleAli']) && empty($_POST['qteLog']) && empty($_POST['qteAli'])) {

			$query = $this->connectionManager->getConnection()->prepare('INSERT INTO articles(supplier_id, libelle, volume, quantity) VALUES (?,?,?,?)');
			$query->execute(array($supplier_id, $libelle, $volume, $quantity));
		} elseif (empty($_POST['libelle']) && empty($_POST['libelleAli']) && empty($_POST['quantity']) && empty($_POST['qteAli'])) {

			$query = $this->connectionManager->getConnection()->prepare('INSERT INTO articles(supplier_id, libelle, quantity) VALUES (?,?,?)');
			$query->execute(array($supplier_id, $libelleLog, $qteLog));
		} elseif (empty($_POST['libelleLog']) && empty($_POST['libelle']) && empty($_POST['qteLog']) && empty($_POST['quantity'])) {

			$query = $this->connectionManager->getConnection()->prepare('INSERT INTO articles(supplier_id, libelle, quantity) VALUES (?,?,?)');
			$query->execute(array($supplier_id, $libelleAli, $qteAli));
		}

		$sql1 = $this->connectionManager->getConnection()->prepare("SELECT name FROM company WHERE id = ?");
		$sql1->execute(array(1));
		foreach ($sql1 as $qr) {

			$nameCompany = $qr['name'];
		}

		$sql = $this->connectionManager->getConnection()->prepare("SELECT email FROM employees WHERE id = ? AND role = ? AND deleted = ?");
		$sql->execute(array($supplier_id, 'FSR', 0));
		foreach ($sql as $quer) {

			$email = $quer['email'];
		}

		$header = "MIME-Version: 1.0\r\n";
		$header .= 'From:"' . $nameCompany . '"<support@' . $nameCompany . '.com>' . "\n";
		$header .= 'Content-Type:text/html; charset="uft-8"' . "\n";
		$header .= 'Content-Transfer-Encoding: 8bit';

		$message = '
		<html lang="en" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">
		<head>
		<title></title>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
		<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
		<!--[if mso]><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch><o:AllowPNG/></o:OfficeDocumentSettings></xml><![endif]-->
		<!--[if !mso]><!-->
		<link href="https://fonts.googleapis.com/css?family=Permanent+Marker" rel="stylesheet" type="text/css"/>
		<!--<![endif]-->
		<style>
				* {
					box-sizing: border-box;
				}

				body {
					margin: 0;
					padding: 0;
				}

				a[x-apple-data-detectors] {
					color: inherit !important;
					text-decoration: inherit !important;
				}

				#MessageViewBody a {
					color: inherit;
					text-decoration: none;
				}

				p {
					line-height: inherit
				}

				.desktop_hide,
				.desktop_hide table {
					mso-hide: all;
					display: none;
					max-height: 0px;
					overflow: hidden;
				}

				@media (max-width:700px) {

					.desktop_hide table.icons-inner,
					.social_block.desktop_hide .social-table {
						display: inline-block !important;
					}

					.icons-inner {
						text-align: center;
					}

					.icons-inner td {
						margin: 0 auto;
					}

					.fullMobileWidth,
					.row-content {
						width: 100% !important;
					}

					.mobile_hide {
						display: none;
					}

					.stack .column {
						width: 100%;
						display: block;
					}

					.mobile_hide {
						min-height: 0;
						max-height: 0;
						max-width: 0;
						overflow: hidden;
						font-size: 0px;
					}

					.desktop_hide,
					.desktop_hide table {
						display: table !important;
						max-height: none !important;
					}
				}
			</style>
		</head>
		<body style="background-color: #f9f9f9; margin: 0; padding: 0; -webkit-text-size-adjust: none; text-size-adjust: none;">
		<table border="0" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f9f9f9;" width="100%">
		<tbody>
		<tr>
		<td>
		<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
		<tbody>
		<tr>
		<td>
		<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #5d77a9; color: #000000; width: 680px;" width="680">
		<tbody>
		<tr>
		<td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 0px; padding-bottom: 0px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
		<div class="spacer_block" style="height:10px;line-height:10px;font-size:1px;"> </div>
		</td>
		</tr>
		</tbody>
		</table>
		</td>
		</tr>
		</tbody>
		</table>
		<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
		<tbody>
		<tr>
		<td>
		</td>
		</tr>
		</tbody>
		</table>
		<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-3" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
		<tbody>
		<tr>
		<td>
		<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #5d77a9; color: #000000; width: 680px;" width="680">
		<tbody>
		<tr>
		<td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 0px; padding-bottom: 0px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
		<div class="spacer_block" style="height:10px;line-height:10px;font-size:1px;"> </div>
		</td>
		</tr>
		</tbody>
		</table>
		</td>
		</tr>
		</tbody>
		</table>
		<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-4" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
		<tbody>
		<tr>
		<td>
		<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px;" width="680">
		<tbody>
		<tr>
		<td class="pad" style="padding-bottom:25px;background-color: #cbdbef;padding-left:20px;padding-right:20px;padding-top:70px;">
		<div style="font-family: Georgia, serif">
		<div class="" style="font-size: 14px; font-family: Georgia, Times, Times New Roman, serif; mso-line-height-alt: 16.8px; color: #2f2f2f; line-height: 1.2;">
		<p style="margin: 0; font-size: 14px; text-align: center; mso-line-height-alt: 16.8px;"><span style="font-size:34px;">' . $nameCompany . '</span></p>
		</div>
		</div>
		</td>
		</tr>
		</table>
		<table border="0" cellpadding="0" cellspacing="0" class="divider_block block-4" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
		<tr>
		<td class="pad">
		<div align="center" class="alignment">
		<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="5%">
		<tr>
		<td class="divider_inner" style="font-size: 1px; line-height: 1px; border-top: 3px solid #2F2F2F;"><span> </span></td>
		</tr>
		</table>
		</div>
		</td>
		</tr>
		</table>
		</td>
		</tr>
		</tbody>
		</table>
		</td>
		</tr>
		</tbody>
		</table>
		<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-5" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
		<tbody>
		<tr>
		<td>
		<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 680px;" width="680">
		<tbody>
		<tr>
		<td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 40px; padding-bottom: 20px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
		<table border="0" cellpadding="0" cellspacing="0" class="text_block block-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
		<tr>
		<td class="pad" style="padding-bottom:10px;padding-left:30px;padding-right:30px;padding-top:10px;">
		<div style="font-family: sans-serif">
		<div class="" style="font-size: 14px; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 21px; color: #393d47; line-height: 1.5;">
		<p style="margin: 0; font-size: 16px; text-align: left; mso-line-height-alt: 24px;"><span style="font-size:16px;">Bienvenu à vous,</span></p>
		<p style="margin: 0; font-size: 16px; text-align: left; mso-line-height-alt: 21px;"> </p>
		<p style="margin: 0; font-size: 16px; text-align: left; mso-line-height-alt: 24px;"><span style="font-size:16px;">Vous venez de recevoir une commande d\'article. Rejoindrez-nous sur notre plateforme en ligne pour plus de détails.</span></p>
		</div>
		</div>
		</td>
		</tr>
		</table>
		</td>
		</tr>
		</tbody>
		</table>
		</td>
		</tr>
		</tbody>
		</table>
		
		</td>
		<td class="column column-3" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="25%">
		<div class="spacer_block" style="height:5px;line-height:0px;font-size:1px;"> </div>
		</td>
		</tr>
		</tbody>
		</table>
		</td>
		</tr>
		</tbody>
		</table>
		</td>
		</tr>
		</tbody>
		</table>
		</td>
		</tr>
		</tbody>
		</table>
		</td>
		</tr>
		</tbody>
		</table>
		</td>
		</tr>
		</tbody>
		</table>
		</td>
		</tr>
		</tbody>
		</table>
		</td>
		</tr>
		</tbody>
		</table><!-- End -->
		</body>
		</html>
		';

		mail($email, $nameCompany, $message, $header);
	}

	/**
	 * Update Article
	 *
	 * @param array|Article $article Article data
	 * @return bool Returns true if the Article was updated, false otherwise
	 */


	/**
	 * Parse service data to entity
	 *
	 * @param array $data Service data
	 * @return Article|null Return Service entity if success, null otherwise.
	 */
	public function toEntity(array $data): ?Article
	{
		$id = $data['id'] ? (int)$data['id'] : null;
		$libelle = !empty($data['libelle']) ? htmlentities($data['libelle']) : null;
		$volume = !empty($data['volume']) ? htmlentities($data['volume']) : null;
		$quantity = !empty($data['quantity']) ? htmlentities($data['quantity']) : null;

		$deleted = !empty($data['deleted']) ? htmlentities($data['deleted']) : null;

		$article = new Article();
		$article->setId($id);
		$article->setLibelle($libelle);
		$article->setVolume($volume);
		$article->setQuantity($quantity);
		$article->setDeleted($deleted);

		return $article;
	}

	/**
	 * Check if the Article already exists
	 *
	 * @param Article $article Employee
	 * @return boolean Returns true if Article exists, false otherwise.
	 */
	public function checkArticle(Article $article): bool
	{
		$exist = true;

		$sql = "SELECT * FROM articles WHERE libelle = ? AND volume = ? AND quantity = ? AND pu = ?";
		if (!is_null($article->getId())) {
			$sql .= " AND id != ?";
		}

		$sql .= " LIMIT 0,1";

		try {
			$query = $this->connectionManager->getConnection()->prepare($sql);
			$query->bindValue(1, $article->getLibelle());
			$query->bindValue(2, $article->getVolume());
			$query->bindValue(3, $article->getQuantity());
			$query->bindValue(4, $article->getPu());
			if (!is_null($article->getId())) {
				$query->bindValue(5, $article->getId(), \PDO::PARAM_INT);
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

	/**
	 * Delete Article method
	 *
	 * @param integer $id Article id
	 * @return boolean Returns true if Article was deleted, false otherwise.
	 */
	public function approv(int $id): bool
	{
		$existedArticle = $this->getById($id);
		if (empty($existedArticle)) {

			return false;
		}

		$sql = "UPDATE articles SET status = :status WHERE id = :id";

		try {
			$query = $this->connectionManager->getConnection()->prepare($sql);

			$query->bindValue(':status', 'Approuvée', \PDO::PARAM_STR);
			$query->bindValue(':id', $id, \PDO::PARAM_INT);

			$deleted = $query->execute();

			return $deleted;
		} catch (\PDOException $e) {
			throw new \Exception("SQL Exception: " . $e->getMessage(), 1);
		}
	}

	/**
	 * Delete Article method
	 *
	 * @param integer $id Article id
	 * @return boolean Returns true if Article was deleted, false otherwise.
	 */
	public function drop(int $id): bool
	{
		$existedArticle = $this->getById($id);
		if (empty($existedArticle)) {

			return false;
		}

		$sql = "UPDATE articles SET status = :status, deleted = :deleted WHERE id = :id";

		try {
			$query = $this->connectionManager->getConnection()->prepare($sql);

			$query->bindValue(':status', 'Annulée', \PDO::PARAM_STR);
			$query->bindValue(':deleted', 1, \PDO::PARAM_BOOL);
			$query->bindValue(':id', $id, \PDO::PARAM_INT);

			$deleted = $query->execute();

			return $deleted;
		} catch (\PDOException $e) {
			throw new \Exception("SQL Exception: " . $e->getMessage(), 1);
		}
	}

	/**
	 * Delete Article method
	 *
	 * @param integer $id Article id
	 * @return boolean Returns true if Article was deleted, false otherwise.
	 */
	public function delete(int $id): bool
	{
		$existedArticle = $this->getById($id);
		if (empty($existedArticle)) {

			return false;
		}

		$sql = "UPDATE articles SET status = :status, deleted = :deleted WHERE id = :id";

		try {
			$query = $this->connectionManager->getConnection()->prepare($sql);

			$query->bindValue(':status', 'Rejetée', \PDO::PARAM_STR);
			$query->bindValue(':deleted', 1, \PDO::PARAM_BOOL);
			$query->bindValue(':id', $id, \PDO::PARAM_INT);

			$deleted = $query->execute();

			return $deleted;
		} catch (\PDOException $e) {
			throw new \Exception("SQL Exception: " . $e->getMessage(), 1);
		}
	}


	/**
	 * Delete Article method
	 *
	 * @param integer $id Article id
	 * @return boolean Returns true if Article was deleted, false otherwise.
	 */
	public function deleteArticle(int $id): bool
	{
		$existedArticle = $this->getById($id);
		if (empty($existedArticle)) {

			return false;
		}

		$sql = "UPDATE articles SET deleted = :deleted WHERE id = :id";

		try {
			$query = $this->connectionManager->getConnection()->prepare($sql);

			$query->bindValue(':deleted', 1, \PDO::PARAM_BOOL);
			$query->bindValue(':id', $id, \PDO::PARAM_INT);

			$deleted = $query->execute();

			return $deleted;
		} catch (\PDOException $e) {
			throw new \Exception("SQL Exception: " . $e->getMessage(), 1);
		}
	}
}
