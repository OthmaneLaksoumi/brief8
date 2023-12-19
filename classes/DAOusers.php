<?php
require_once("database.php");
require_once("users.php");

class DAOuser
{
    private $db;

    public function __construct()
    {
        $conn = new database();
        $this->db = $conn->getConn();
    }

    public function get_users($state, $role)
    {
        $query = "SELECT * FROM users WHERE `state` = '$state' AND `role` = '$role'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $resultArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $resultObject = array();
        foreach ($resultArray as $user) {
            $resultObject[] = new users($user['email'], $user['username'], $user['pass'], $user['state'], $user['role']);
        }
        return $resultObject;
    }
    public function change_state($user)
    {
        $query = "UPDATE users SET `state` = 1 WHERE `email` = '" . $user->getEmail() . "'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
    }
    public function change_role($user)
    {
        $query = "UPDATE users SET `role` = 1 WHERE `email` = '" . $user->getEmail() . "'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
    }

    public function delete_user($user)
    {
        $query = "DELETE FROM users WHERE username = '" . $user->getUsername() . "'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
    }
}
