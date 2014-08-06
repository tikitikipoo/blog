<?php

use cypher\Config;

class UserModel extends AppModel
{


	public static function login($data)
	{
		$username = $data['username'];
		$password = $data['password'];

		$hashpassword = self::hashPassword($password);

		$sql = 'SELECT * FROM user WHERE name = ? AND password = ?';
        $row = self::getDB()->row($sql, array($username, $hashpassword));
     	if (!$row) {
     		return false;
     	}

     	$row['user'] = $row;
     	return new self($row);
	}

	public static function hashPassword($password, $salt = null)
	{
		if (!$salt) {
			$salt = Config::read("salt");
		}
		return sha1($password . $salt);
	}


    public static function getAll()
    {

        $sql = 'SELECT * FROM user ';
        $rows = self::getDB()->rows($sql);

        if (!$rows) {
        	return false;
        }

        $users = [];
        foreach ($rows as $row) {
        	$row['user'] = $row;
        	$users[] = new self($row);
        }

        return $users;
    }

}
