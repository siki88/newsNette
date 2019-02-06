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
class User extends \Kdyby\Doctrine\Entities\BaseEntity{

    // Pomocné konstanty pro náš model.
    /** Konstanty pro uživatelské role. */
    const ROLE_USER =  1,
          ROLE_ADMIN = 2;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    public $id;

    /**
     * Sloupec pro jméno.
     * @ORM\Column(name="`username`", type="string")
     */
    protected $username;

    /**
     * Sloupec pro email.
     * @ORM\Column(name="`email`", type="string")
     */
    protected $email;

    /**
     * Sloupec pro heslo.
     * @ORM\Column(name="`password`", type="string")
     */
    protected $password;

    /**
     * Sloupec role
     * @ORM\Column(name="`roles_id`", type="integer")
     */
    protected $roles_id;

    /**
     * Sloupec pro datum registrace.
     * @ORM\Column(name="`created_at`", type="datetime")
     */
    protected $created_at;

}