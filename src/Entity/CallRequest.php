<?php


namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CallRequest
 *
 * @ORM\Table
 * @ORM\Entity(repositoryClass="App\Repository\CallRequestRepository")
 *
 * @package App\Entity
 */
class CallRequest
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $_id;

    /**
     * @var string name
     *
     * @ORM\Column(name="name",type="string",length=255, unique=false)
     * @Assert\NotBlank
     * @Assert\Length(
     *     min        = 2,
     *     max        = 255,
     *     minMessage = "Votre nom doit faire au moins { min } caractères",
     *     maxMessage = "Votre nom ne peut exéder { max } caractères.")
     * @Assert\Regex(
     *     pattern    = "/^[azAZ ]{4,20}$/",
     *     message    = "Votre nom ne peut contenir que des lettres et des espaces."
     * )
     */
    protected $name;

    /**
     * @var string fname
     *
     * @ORM\Column(name="fname",type="string",length=255, unique=false)
     * @Assert\NotBlank
     * @Assert\Length(
     *     min        = 2,
     *     max        = 255,
     *     minMessage = "Votre prénom doit faire au moins { min } caractères",
     *     maxMessage = "Votre prénom ne peut exéder { max } caractères.")
     * @Assert\Regex(
     *     pattern    = "/^[azAZ -]{4,20}$/",
     *     message    = "Votre nom ne peut contenir que des lettres, des '-' et des espaces."
     * )
     */
    protected $fname;

    /**
     * @var string country
     * @ORM\Column(name="country", type="string", length=2)
     * @Assert\Country()
     */
    protected $country;

    /**
     * @var string national format of phone number
     * @ORM\Column(name="national", type="string", length=30)
     * @Assert\NotBlank
     */
    protected $national;

    /**
     * @var string international format of phone number
     * @ORM\Column(name="international", type="string", length=35)
     * @Assert\NotBlank
     */
    protected $international;

    /**
     * @var string phone number given by user
     * not stored like this on database
     *
     * @Assert\NotBlank
     */
    protected $phoneNumber;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->_id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->_id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getFname(): string
    {
        return $this->fname;
    }

    /**
     * @param string $fname
     */
    public function setFname(string $fname): void
    {
        $this->fname = $fname;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getNational(): string
    {
        return $this->national;
    }

    /**
     * @param string $national
     */
    public function setNational(string $national): void
    {
        $this->national = $national;
    }

    /**
     * @return string
     */
    public function getInternational(): string
    {
        return $this->international;
    }

    /**
     * @param string $international
     */
    public function setInternational(string $international): void
    {
        $this->international = $international;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }


}