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
 * @ORM\Table(name="users")
 */
class Token extends \Kdyby\Doctrine\Entities\BaseEntity{


    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    public $id;

    /**
     * Sloupec pro token.
     * @ORM\Column(name="`token`", type="string")
     */
    protected $token;

    /**
     * Sloupec pro user_id.
     * @ORM\Column(type="integer")
     */
    protected $userId;

    /**
     * Sloupec pro datum registrace.
     * @ORM\Column(name="`created_at`", type="datetime")
     */
    protected $registrationDate;

    /**
     * Sloupec pro datum update.
     * @ORM\Column(name="`update_at`", type="datetime")
     */
    protected $registrationUpdate;

    /**
     * Sloupec pro datum expirace.
     * @ORM\Column(name="`expirate_at`", type="datetime")
     */
    protected $registrationExpirate;

}