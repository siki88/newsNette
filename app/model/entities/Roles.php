<?php
/**
 * Created by PhpStorm.
 * User: Programovani
 * Date: 4.2.2019
 * Time: 12:45
 */

namespace App\Model\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="roles")
 */
class Roles extends \Kdyby\Doctrine\Entities\BaseEntity{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    public $id;

    /**
     * Sloupec pro jméno.
     * @ORM\Column(name="`name`", type="string")
     */
    protected $name;

    /**
     * Sloupec pro datum registrace.
     * @ORM\Column(name="`created_at`", type="datetime")
     */
    protected $registrationDate;

}