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
 * @ORM\Table(name="evaluation")
 */
class Evaluation extends \Kdyby\Doctrine\Entities\BaseEntity{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * Sloupec pro news_id.
     * @ORM\Column(name="`news_id`", type="integer")
     */
    protected $news_id;

    /**
     * Sloupec pro users_id.
     * @ORM\Column(name="`users_id`", type="integer")
     */
    protected $users_id;

    /**
     * Sloupec pro inch_up.
     * @ORM\Column(name="`inch_up`", type="integer")
     */
    protected $inch_up;

    /**
     * Sloupec pro inch_down.
     * @ORM\Column(name="`inch_down`", type="integer")
     */
    protected $inch_down;

    /**
     * Sloupec pro evaluation.
     * @ORM\Column(name="`evaluation`", type="string")
     */
    protected $evaluation;

    /**
     * Sloupec pro datum registrace.
     * @ORM\Column(name="`created_at`", type="datetime")
     */
    protected $created_at;

}