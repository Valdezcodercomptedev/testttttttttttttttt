<?php

declare(strict_types=1);

namespace App\Service;

require_once dirname(dirname(__DIR__)) . DS . DS . 'autoload.php';

use Core\Database\ConnectionManager;
use Core\Utils\Session;
use Core\Auth\PasswordHasher;
use App\Entity\Supplier;

/**
 * Service Services
 */
class SupplierServices
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
		$suppliers = [];

		$select = "SELECT e.id AS Supplier_id, e.unique_id AS Supplier_unique_id, e.name AS Supplier_name, e.phone AS Supplier_phone, e.email AS Supplier_email, e.ville AS Supplier_ville, e.username AS Supplier_username, e.pwd AS Supplier_pwd, e.role AS Supplier_role, e.created AS Supplier_created, e.deleted AS Supplier_deleted";

		$sql = $select . " FROM employees e WHERE e.role = ? AND e.deleted = ?";

		try {
			$query = $this->connectionManager->getConnection()->prepare($sql);

			$query->execute(['FSR', 0]);

			$result = $query->fetchAll(\PDO::FETCH_ASSOC);
		} catch (\PDOException $e) {
			throw new \Exception("SQL Exception: " . $e->getMessage(), 1);
		}

		if (empty($result)) {
			return [];
		}

		foreach ($result as $row) {
			$supplier = new Supplier();
			$supplier->setId($row['Supplier_id']);
			$supplier->setUniqueId($row['Supplier_unique_id']);
			$supplier->setName($row['Supplier_name']);
			$supplier->setPhone($row['Supplier_phone']);
			$supplier->setEmail($row['Supplier_email']);
			$supplier->setVille($row['Supplier_ville']);
			$supplier->setUsername($row['Supplier_username']);
			$supplier->setPwd($row['Supplier_pwd']);
			$supplier->setRole($row['Supplier_role']);
			$supplier->setCreated($row['Supplier_created']);
			$supplier->setDeleted($row['Supplier_deleted']);


			$suppliers[] = $supplier;
		}

		return $suppliers;
	}

	public function countAll(): int
	{
		$count = 0;
		$join = '';

		$sql = "SELECT COUNT(*) AS count FROM employees e WHERE e.role = ? AND e.deleted = ?";

		try {
			$query = $this->connectionManager->getConnection()->prepare($sql);

			$query->execute(['FSR', 0]);

			$result = $query->fetch(\PDO::FETCH_ASSOC);

			$count = (int)$result['count'];
		} catch (\PDOException $e) {
			throw new \Exception("SQL Exception: " . $e->getMessage(), 1);
		}

		return $count;
	}

	public function getById($id): ?Supplier
	{
		$result = [];

		$sql = "SELECT e.id AS Supplier_id, e.unique_id AS Supplier_unique_id, e.name AS Supplier_name, e.phone AS Supplier_phone, e.email AS Supplier_email, e.ville AS Supplier_ville, e.username AS Supplier_username, e.pwd AS Supplier_pwd, e.role AS Supplier_role, e.created AS Supplier_created, e.deleted AS Supplier_deleted
			FROM employees e 
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

		$supplier = new Supplier();
		$supplier->setId($result['Supplier_id']);
		$supplier->setUniqueId($result['Supplier_unique_id']);
		$supplier->setName($result['Supplier_name']);
		$supplier->setPhone($result['Supplier_phone']);
		$supplier->setEmail($result['Supplier_email']);
		$supplier->setVille($result['Supplier_ville']);
		$supplier->setUsername($result['Supplier_username']);
		$supplier->setPwd($result['Supplier_pwd']);
		$supplier->setRole($result['Supplier_role']);
		$supplier->setCreated($result['Supplier_created']);
		$supplier->setDeleted($result['Supplier_deleted']);

		return $supplier;
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

		$name = htmlspecialchars($_POST['name']);
		$phone = htmlspecialchars($_POST['phone']);
		$email = htmlspecialchars($_POST['email']);
		$city = htmlspecialchars($_POST['city']);
		$username = htmlspecialchars($_POST['username']);
		$password = htmlspecialchars($_POST['cnfpass']);
		$confpass = hash('sha256', '$@LVM' . $_POST['cnfpass'] . '@#');
		$role = 'FSR';

		$query = $this->connectionManager->getConnection()->prepare('INSERT INTO employees(unique_id, name, phone, email, ville, username, pwd, role) VALUES (?,?,?,?,?,?,?,?)');
		$query->execute(array($uniq, $name, $phone, $email, $city, $username, $confpass, $role));

		$sql = $this->connectionManager->getConnection()->prepare("SELECT name FROM company WHERE id = ?");
		$sql->execute(array(1));
		foreach ($sql as $quer) {

			$nameCompany = $quer['name'];
		}

		$header = "MIME-Version: 1.0\r\n";
		$header .= 'From:"' . $nameCompany .'"<support@' . $nameCompany .'.com>' . "\n";
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
		<p style="margin: 0; font-size: 14px; text-align: center; mso-line-height-alt: 16.8px;"><span style="font-size:34px; text-transform: capitalize;">' . $nameCompany .'</span></p>
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
		<p style="margin: 0; font-size: 16px; text-align: left; mso-line-height-alt: 24px;"><span style="font-size:16px;">Vous avez été enregistrer avec succès dans la plate-forme en ligne dans le but de pouvoir améliorer le mécanisme de gestion de notre h&ocirc;tel, ainsi que de nos partenaires.</span></p>
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
		<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-6" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
		<tbody>
		<tr>
		<td>
		<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 680px;" width="680">
		<tbody>
		<tr>
		<td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="25%">
		<div class="spacer_block" style="height:5px;line-height:0px;font-size:1px;"> </div>
		</td>
		<td class="column column-2" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; background-color: #5d77a9; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="50%">
		<table border="0" cellpadding="0" cellspacing="0" class="text_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
		<tr>
		<td class="pad" style="padding-bottom:25px;padding-left:20px;padding-right:20px;padding-top:25px;">
		<div style="font-family: sans-serif">
		<div class="" style="font-size: 14px; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 16.8px; color: #ffffff; line-height: 1.2;">
		<p style="margin: 0; text-align: center; mso-line-height-alt: 16.8px;"><span style="font-size:18px;">Vos informations :</span></p>
		</div>
		</div>
		</td>
		</tr>
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
		<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-7" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
		<tbody>
		<tr>
		<td>
		<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 680px;" width="680">
		<tbody>
		<tr>
		<td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="25%">
		<div class="spacer_block" style="height:5px;line-height:0px;font-size:1px;"> </div>
		</td>
		<td class="column column-2" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; border-bottom: 1px solid #5D77A9; border-left: 1px solid #5D77A9; border-right: 1px solid #5D77A9; border-top: 1px solid #5D77A9; vertical-align: top;" width="50%">
		<table border="0" cellpadding="0" cellspacing="0" class="text_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
		<tr>
		<td class="pad" style="padding-bottom:10px;padding-left:20px;padding-right:20px;padding-top:15px;">
		<div style="font-family: sans-serif">
		<div class="" style="font-size: 14px; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 21px; color: #393d47; line-height: 1.5;">
		<p style="margin: 0; font-size: 16px; mso-line-height-alt: 24px;"><span style="font-size:16px;"><strong><span style="color:#5d77a9;">Nom d\'utilisateur : </span></strong>' . $username . '</span></p>
		<p style="margin: 0; font-size: 16px; mso-line-height-alt: 24px;"><span style="font-size:16px;"><strong><span style="color:#5d77a9;">Mot de passe : </span></strong>' . $password . '</span></p>
		</div>
		</div>
		</td>
		</tr>
		</table>
		<table border="0" cellpadding="10" cellspacing="0" class="divider_block block-3" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
		<tr>
		<td class="pad">
		<div align="center" class="alignment">
		<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
		<tr>
		<td class="divider_inner" style="font-size: 1px; line-height: 1px; border-top: 1px solid #BBBBBB;"><span> </span></td>
		</tr>
		</table>
		</div>
		</td>
		</tr>
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
		<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-8" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
		<tbody>
		<tr>
		<td>
		<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 680px;" width="680">
		<tbody>
		<tr>
		<td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: center; vertical-align: top; padding-top: 0px; padding-bottom: 20px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
		<table border="0" cellpadding="0" cellspacing="0" class="text_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
		<tr>
		<td class="pad" style="padding-bottom:10px;padding-left:30px;padding-right:30px;padding-top:30px;">
		<div style="font-family: sans-serif">
		<div class="" style="font-size: 14px; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 21px; color: #2f2f2f; line-height: 1.5;">
		<p style="margin: 0; font-size: 16px; text-align: center; mso-line-height-alt: 24px;"><span style="font-size:16px;color:#5d77a9;">Ne partagez pas vos informations.</span></p>
		<p style="margin: 0; font-size: 16px; text-align: center; mso-line-height-alt: 24px;">Pour plus d\'informations, rejoignez-nous sur n&ocirc;tre plate-forme en ligne.</p>
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
		<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-9" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
		<tbody>
		<tr>
		<td>
		<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #cbdbef; color: #000000; width: 680px;" width="680">
		<tbody>
		<tr>
		<td class="column column-2" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: center; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="50%">
		<table border="0" cellpadding="10" cellspacing="0" class="button_block block-4" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
		<tr>
		<td class="pad">
		<div align="center" class="alignment">
		<a href="http://localhost:80/pha-manager/src/View/Auth/login.php" style="text-decoration:none;display:inline-block;color:#ffffff;background-color:#2f2f2f;border-radius:10px;width:auto;border-top:1px solid #8a3b8f;font-weight:undefined;border-right:1px solid #8a3b8f;border-bottom:1px solid #8a3b8f;border-left:1px solid #8a3b8f;padding-top:5px;padding-bottom:5px;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;font-size:14px;text-align:center;mso-border-alt:none;word-break:keep-all;"><span style="padding-left:20px;padding-right:20px;font-size:14px;display:inline-block;letter-spacing:1px;"><span style="word-break:break-word;"><span data-mce-style="" style="line-height: 28px;">Cliquer ici pour nous rejoindre</span></span></span></a>
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
		<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-11" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
		<tbody>
		<tr>
		<td>
		<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #5d77a9; color: #000000; width: 680px;" width="680">
		<tbody>
		<tr>
		<td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 0px; padding-bottom: 20px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
		<table border="0" cellpadding="10" cellspacing="0" class="text_block block-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
		<tr>
		<td class="pad">
		<div style="font-family: sans-serif">
		<div class="" style="font-size: 12px; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14.399999999999999px; color: #cfceca; line-height: 1.2;">
		<p style="margin: 0; font-size: 14px; color: #fff; text-align: center; mso-line-height-alt: 16.8px;"><span style="font-size:12px;">© Copyrights Valdez prince, 2023 . Tout droits reservés</span></p>
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

		mail($email,  $nameCompany , $message, $header);
	}

	/**
	 * Update supplier
	 *
	 * @param array|Supplier $supplier supplier data
	 * @return bool Returns true if the supplier was updated, false otherwise
	 */
	public function update(array|Supplier $supplier): bool
	{
		if (is_array($supplier)) {
			$supplier = $this->toEntity($supplier);
		}

		$existedSupplier = $this->getById($supplier->getId());

		if (empty($existedSupplier)) {

			return false;
		}

		if ($this->checkSupplier($supplier)) {

            Session::write('__formdata__', json_encode($_POST));

            return false;
		}

		$sql = "UPDATE employees SET name = ?, phone = ?, email = ?, ville = ?, username = ?, pwd = ? WHERE id = ?";

		try {

			$this->connectionManager->getConnection()->beginTransaction();

			$query = $this->connectionManager->getConnection()->prepare($sql);

			if (empty($supplier->getName())) {
				$query->bindValue(1, $existedSupplier->getName(), \PDO::PARAM_STR);
			} else {
				$query->bindValue(1, $supplier->getName(), \PDO::PARAM_STR);
			}

			if (empty($supplier->getPhone())) {
				$query->bindValue(2, $existedSupplier->getPhone(), \PDO::PARAM_STR);
			} else {
				$query->bindValue(2, $supplier->getPhone(), \PDO::PARAM_STR);
			}

			if (empty($supplier->getEmail())) {
				$query->bindValue(3, $existedSupplier->getEmail(), \PDO::PARAM_STR);
			} else {
				$query->bindValue(3, $supplier->getEmail(), \PDO::PARAM_STR);
			}

			if (empty($supplier->getVille())) {
				$query->bindValue(4, $existedSupplier->getVille(), \PDO::PARAM_STR);
			} else {
				$query->bindValue(4, $supplier->getVille(), \PDO::PARAM_STR);
			}

			if (empty($supplier->getUsername())) {
				$query->bindValue(5, $existedSupplier->getUsername(), \PDO::PARAM_STR);
			} else {
				$query->bindValue(5, $supplier->getUsername(), \PDO::PARAM_STR);
			}

			if (empty($supplier->getPwd())) {
				$query->bindValue(6, $existedSupplier->getPwd(), \PDO::PARAM_STR);
			} else {
				$query->bindValue(6, $supplier->getPwd(), \PDO::PARAM_STR);
			}
			$query->bindValue(7, $supplier->getId(), \PDO::PARAM_INT);

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
	 * @return Supplier|null Return Service entity if success, null otherwise.
	 */
	public function toEntity(array $data): ?Supplier
	{
		$id = $data['id'] ? (int)$data['id'] : null;
		$name = !empty($data['name']) ? htmlentities($data['name']) : null;
		$phone = !empty($data['phone']) ? htmlentities($data['phone']) : null;
		$email = !empty($data['email']) ? htmlentities($data['email']) : null;
		$ville = !empty($data['ville']) ? htmlentities($data['ville']) : null;
		$username = !empty($data['username']) ? htmlentities($data['username']) : null;
		$cnfpass = !empty($data['cnfpass']) ? (new PasswordHasher())->hash(htmlentities($data['cnfpass'])) : null;
		$deleted = !empty($data['deleted']) ? htmlentities($data['deleted']) : null;

		$supplier = new Supplier();
		$supplier->setId($id);
		$supplier->setName($name);
		$supplier->setPhone($phone);
		$supplier->setEmail($email);
		$supplier->setVille($ville);
		$supplier->setUsername($username);
		$supplier->setPwd($cnfpass);
		$supplier->setDeleted($deleted);

		return $supplier;
	}
	
	/**
	 * Check if the supplier already exists
	 *
	 * @param Supplier $supplier Employee
	 * @return boolean Returns true if supplier exists, false otherwise.
	 */
	public function checkSupplier(Supplier $supplier): bool
	{
		$exist = true;

		$sql = "SELECT * FROM employees WHERE name = ? AND phone = ? AND email = ? AND ville = ? AND username = ? AND pwd = ? ";
		if (!is_null($supplier->getId())) {
			$sql .= " AND id != ?";
		}

		$sql .= " LIMIT 0,1";

		try {
			$query = $this->connectionManager->getConnection()->prepare($sql);
			$query->bindValue(1, $supplier->getName());
			$query->bindValue(2, $supplier->getPhone());
			$query->bindValue(3, $supplier->getEmail());
			$query->bindValue(4, $supplier->getVille());
			$query->bindValue(5, $supplier->getUsername());
			$query->bindValue(6, $supplier->getPwd());
			if (!is_null($supplier->getId())) {
				$query->bindValue(7, $supplier->getId(), \PDO::PARAM_INT);
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
	 * Delete supplier method
	 *
	 * @param integer $id Supplier id
	 * @return boolean Returns true if supplier was deleted, false otherwise.
	 */
	public function delete(int $id): bool
	{
		$existedSupplier = $this->getById($id);
		if (empty($existedSupplier)) {

			return false;
		}

		$sql = "UPDATE employees SET deleted = ? WHERE id = ?";

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
