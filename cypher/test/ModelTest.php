<?php
namespace cypher\test;

require_once dirname(__DIR__).'/bootstrap.php';

use cypher\Model;

class ModelTest extends \PHPUnit_Framework_TestCase
{

    public function test_validate()
    {
        $data = array('Player' => array('name' => ''));
        $player = new Player($data);
        $this->assertFalse($player->validate());
        $this->assertTrue($player->hasError());

        $data = array('Player' => array('name' => 'aa'));
        $player = new Player($data);
        $this->assertFalse($player->validate());
        $this->assertTrue($player->hasError());

        $data = array('Player' => array('name' => 'aaa'));
        $player = new Player($data);
        $this->assertTrue($player->validate());
        $this->assertFalse($player->hasError());

        $data = array('Player' => array('name' => '0123456789123456'));
        $player = new Player($data);
        $this->assertTrue($player->validate());
        $this->assertFalse($player->hasError());

        $data = array('Player' => array('name' => '01234567891234567'));
        $player = new Player($data);
        $this->assertFalse($player->validate());
        $this->assertTrue($player->hasError());
    }
}

class Player extends Model
{
    public $validation = array(
        'name' => array(
            'between' => array(
                'rule' => array('lengthRange', array('min' => 3, 'max' => 16))
            )
        ),
    );
}


