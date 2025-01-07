<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use Helpers\Database;
use Classes\Session;

Session::validateSession();

$db = new Database();
$pdo = $db->getConnection();

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'add':
        include('add.php');
        break;
    case 'edit':
        include('edit.php');
        break;
    case 'delete':
        include('delete.php');
        break;
    default:
        include('list.php');
        break;
}