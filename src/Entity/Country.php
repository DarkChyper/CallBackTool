<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Class Country
 * @ORM\Entity
 * @package App\Entity
 */
class Country
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @ORM\Column(name="code", type="string", length=2)
     */
    protected $code;

    /**
     * @ORM\Column(name="dial", type="string", length=10)
     */
    protected $dial;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code): void
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getDial()
    {
        return $this->dial;
    }

    /**
     * @param mixed $dial
     */
    public function setDial($dial): void
    {
        $this->dial = $dial;
    }


}