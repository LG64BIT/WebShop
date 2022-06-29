<?php
namespace App\controllers;

use App\exceptions\NoPermissionException;
use App\Utils;
use PDO;

class OrderController
{
    public function allOrders($response)
    {
        if(!isset($_SESSION['isAdmin'])) {
            throw new NoPermissionException;
        }
        $orders = Utils::getDb()->query("SELECT user_id, firstName, lastName, email, GROUP_CONCAT(user_orders.quantity, 'x ', name SEPARATOR '<br>') AS productInfo, status, date FROM user_orders LEFT OUTER JOIN users ON user_id=users.id LEFT OUTER JOIN products ON product_id=products.id GROUP BY date ORDER BY date DESC")->fetchAll(PDO::FETCH_CLASS);
        $guestOrders = Utils::getDb()->query("SELECT guest_id, firstName, lastName, email, GROUP_CONCAT(guest_orders.quantity, 'x ', name SEPARATOR '<br>') AS productInfo, status, date FROM guest_orders LEFT OUTER JOIN guests ON guest_id=guests.id LEFT OUTER JOIN products ON product_id=products.id GROUP BY date ORDER BY date DESC")->fetchAll(PDO::FETCH_CLASS);
        return $response->setBody('app/views/OrdersView.php', [
            'orders' => $orders,
            'guestOrders' => $guestOrders
        ]);
    }

    public function showHistory($response)
    {
        if(!isset($_SESSION['id'])) {
            throw new NoPermissionException;
        }
        $userOrders = Utils::getDb()->prepare("SELECT user_id, address, GROUP_CONCAT(user_orders.quantity, 'x ', name SEPARATOR '<br>') AS productInfo, status, date FROM user_orders LEFT OUTER JOIN users ON user_id=users.id LEFT OUTER JOIN products ON product_id=products.id WHERE user_id=:id GROUP BY date ORDER BY date DESC");
        $userOrders->execute(['id' => $_SESSION['id']]);
        $userOrders = $userOrders->fetchAll(PDO::FETCH_CLASS);
        return $response->setBody('app/views/OrderHistoryView.php', [
            'userOrders' => $userOrders
        ]);
    }

    public function updateUserStatus()
    {
        if(!isset($_SESSION['isAdmin'])) {
            throw new NoPermissionException;
        }
        $update = Utils::getDb()->prepare("UPDATE user_orders SET status=:status WHERE user_id=:id AND date=:date");
        $update->execute([
            'id' => $_POST['user_id'],
            'date' => $_POST['date'],
            'status' => $_POST['status']
        ]);
        header("Location: ../allOrders");
    }

    public function updateGuestStatus()
    {
        if(!isset($_SESSION['isAdmin'])) {
            throw new NoPermissionException;
        }
        $update = Utils::getDb()->prepare("UPDATE guest_orders SET status=:status WHERE guest_id=:id AND date=:date");
        $update->execute([
            'id' => $_POST['guest_id'],
            'date' => $_POST['date'],
            'status' => $_POST['status']
        ]);
        header("Location: ../allOrders");
    }
}
