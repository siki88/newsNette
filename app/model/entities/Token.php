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
 * @ORM\Table(name="tokens")
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
     * @ORM\Column(name="`user_id`",type="integer")
     */
    protected $user_id;

    /**
     * Sloupec pro datum registrace.
     * @ORM\Column(name="`create_at`", type="datetime")
     */
    protected $create_at;

    /**
     * Sloupec pro datum update.
     * @ORM\Column(name="`update_at`", type="datetime")
     */
    protected $update_at;

    /**
     * Sloupec pro datum expirace.
     * @ORM\Column(name="`expirate_at`", type="datetime")
     */
    protected $expirate_at;

}