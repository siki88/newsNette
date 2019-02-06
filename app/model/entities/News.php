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
 * @ORM\Table(name="news")
 */
class News extends \Kdyby\Doctrine\Entities\BaseEntity{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    public $id;

    /**
     * Sloupec pro short_text.
     * @ORM\Column(name="`short_text`", type="string")
     */
    protected $short_text;

    /**
     * Sloupec pro text.
     * @ORM\Column(name="`text`", type="string")
     */
    protected $text;

    /**
     * Sloupec pro author.
     * @ORM\Column(name="`author`", type="string")
     */
    protected $author;

    /**
     * Sloupec pro user_id.
     * @ORM\Column(name="`users_id`", type="string")
     */
    protected $users_id;

    /**
     * Sloupec pro image.
     * @ORM\Column(name="`image`", type="string")
     */
    protected $image;

    /**
     * Sloupec pro datum registrace.
     * @ORM\Column(name="`created_at`", type="datetime")
     */
    protected $created_at;

}