<?php
namespace app\controllers;

use app\exceptions\NoPermissionException;

class OrderController
{
    protected \PDO $db;
    public function __construct($db)
    {
        $this->db=$db;
    }

    public function allOrders($response)
    {
        if(!isset($_SESSION['isAdmin']))
            throw new NoPermissionException;
        $userOrders = $this->db->query("SELECT user_id, username, GROUP_CONCAT(user_orders.quantity, 'x ', name SEPARATOR '<br>') AS productInfo, status, date FROM user_orders LEFT OUTER JOIN users ON user_id=users.id LEFT OUTER JOIN products ON product_id=products.id GROUP BY date ORDER BY date DESC")->fetchAll(\PDO::FETCH_CLASS);
        $guestOrders = $this->db->query("SELECT guest_id, firstName, lastName, GROUP_CONCAT(guest_orders.quantity, 'x ', name SEPARATOR '<br>') AS productInfo, status, date FROM guest_orders LEFT OUTER JOIN guests ON guest_id=guests.id LEFT OUTER JOIN products ON product_id=products.id GROUP BY date ORDER BY date DESC")->fetchAll(\PDO::FETCH_CLASS);
        return $response->setBody('app/views/OrdersView.php', [
            'userOrders' => $userOrders,
            'guestOrders' => $guestOrders
        ]);
    }
    public function updateUserStatus()
    {
        if(!isset($_SESSION['isAdmin']))
            throw new NoPermissionException;
        $update = $this->db->prepare("UPDATE user_orders SET status=:status WHERE user_id=:id AND date=:date");
        $update->execute([
            'id' => $_POST['user_id'],
            'date' => $_POST['date'],
            'status' => $_POST['status']
        ]);
        header("Location: ../allOrders");
    }

    public function updateGuestStatus()
    {
        if(!isset($_SESSION['isAdmin']))
            throw new NoPermissionException;
        $update = $this->db->prepare("UPDATE guest_orders SET status=:status WHERE guest_id=:id AND date=:date");
        $update->execute([
            'id' => $_POST['guest_id'],
            'date' => $_POST['date'],
            'status' => $_POST['status']
        ]);
        header("Location: ../allOrders");
    }
}