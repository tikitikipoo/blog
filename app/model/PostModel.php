<?php

class PostModel extends AppModel
{

    public static function get($id)
    {

        $sql = 'SELECT * FROM post WHERE id = ?';
        $row = self::getDB()->row($sql, array($id));
        if (!$row) {
        	return false;
        }
        $row['post']  = new self($row);
        return $row;
    }


    public static function getAll($id = null, $page = 1, $limit = 10)
    {

        $sql = 'SELECT * FROM post ';
        $rows = self::getDB()->rows($sql);
        if (!$rows) {
        	return [];
        }

        $posts = [];
        foreach ($rows as $row) {
        	$row['post'] = $row;
        	$posts[] = new self($row);
        }
        return $posts;
    }

    public static function add($data)
    {
    	$params = [
    		'title' => $data['title'],
    		'body'	=> $data['body']
    	];

    	try {
    		$post = self::getDB()->insert('post', $params);
    	} catch(Exception $e) {
    		return false;
    	}
    	return true;
    }

    public static function edit($data)
    {

    	$params = [
    		'title' => $data['title'],
    		'body'	=> $data['body']
    	];

    	$where = [
    		'id' => $data['id']
    	];

    	try {
    		$post = self::getDB()->update('post', $params, $where);
    	} catch(Exception $e) {
    		return false;
    	}
    	return true;

    }

}
