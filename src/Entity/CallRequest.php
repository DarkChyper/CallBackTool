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
     *     minMessage = "callrequest.name.length.min",
     *     maxMessage = "assert.name.max")
     * @Assert\Regex(
     *     pattern    = "/^[a-zA-Z ]{1,255}$/",
     *     message    = "callrequest.name.regex"
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
     *     minMessage = "callrequest.fname.length.min",
     *     maxMessage = "callrequest.fname.length.max")
     * @Assert\Regex(
     *     pattern    = "/^[a-zA-Z \-]{1,255}$/",
     *     message    = "callrequest.fname.regex"
     * )
     */
    protected $fname;

    /**
     * @var string country
     * @ORM\Column(name="country", type="string", length=2)
     * @Assert\Country(message="callrequest.country.country",)
     */
    protected $country;

    /**
     * @var string national format of phone number
     * @ORM\Column(name="national", type="string", length=30)
     */
    protected $national;

    /**
     * @var string international format of phone number
     * @ORM\Column(name="international", type="string", length=35)
     */
    protected $international;

    /**
     * @var string phone number given by user
     * not stored like this on database
     *
     * @Assert\NotBlank(message="callrequest.phonenumber.not_blank")
     * @Assert\Regex(
     *     pattern    = "/^\+{0,1}[0-9 ]{2,35}$/",
     *     message    = "callrequest.phonenumber.regex"
     * )
     */
    protected $phoneNumber;

    /**
     * CallRequest constructor.
     */
    public function __construct()
    {
    }


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
    public function getName(): ?string
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
    public function getFname(): ?string
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
    public function getCountry(): ?string
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
    public function getNational(): ?string
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
    public function getInternational(): ?string
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
    public function getPhoneNumber(): ?string
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