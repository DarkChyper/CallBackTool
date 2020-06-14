<?php


namespace App\Service;


use App\Entity\CallRequest;
use App\Exception\CallAPIException;
use App\Exception\NonLockAPIException;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpClient\CachingHttpClient;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpKernel\HttpCache\Store;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class CallRequestService
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var PaginatorInterface
     */
    protected $paginator;

    private $_apiUser;
    private $_apîPassword;

    const OUTPUT = "output";
    const IS_VALID = "isValid";
    const NATIONAL = "national";
    const INTERNATIONAL = "international";

    /**
     * ValidationService constructor.
     * @param String $apiUser
     * @param String $apiPassword
     * @param EntityManagerInterface $entityManager
     * @param PaginatorInterface $paginator
     */
    public function __construct(String $apiUser, String $apiPassword, EntityManagerInterface $entityManager, PaginatorInterface $paginator)
    {
        $this->_apiUser = $apiUser;
        $this->_apîPassword = $apiPassword;
        $this->em = $entityManager;
        $this->paginator = $paginator;
    }

    /**
     * Validate object CallRequest
     *
     * @param CallRequest $callRequest
     * @return CallRequest
     */
    public function validateCallRequest(CallRequest $callRequest){
        try {
            $response = $this->getPhoneInfoByAPI($callRequest->getCountry(), $callRequest->getPhoneNumber());

            $callRequest->setNational($response[self::OUTPUT][self::NATIONAL]);
            $callRequest->setInternational($response[self::OUTPUT][self::INTERNATIONAL]);
            return $callRequest;
        } catch(NonLockAPIException $nlapie){
            throw new CallAPIException($nlapie);
        }
    }

    /**
     * return true if the phone number is valid,
     * false otherwise
     *
     * @param String $country
     * @param String $phoneNumber
     * @return bool
     */
    public function isPhoneNumberValid(String $country, String $phoneNumber){
        $retour = true;
        try {
            $response = $this->getPhoneInfoByAPI($country, $phoneNumber);
            if(empty($response) || !$response[self::OUTPUT][self::IS_VALID]){
                $retour = false;
            }
        }catch(NonLockAPIException $nlapie){
            $retour = false;
        }

        return $retour;
    }

    /**
     * @param String $country
     * @param String $phoneNumber
     * @return array|mixed
     */
    private function getPhoneInfoByAPI(String $country, String $phoneNumber){

        $store = new Store('/cache/PhoneAPI/');
        $client = HttpClient::createForBaseUri('http://163.172.67.144:8042/',[
            'auth_basic' => $this->_apiUser.":".$this->_apîPassword
        ]);
        $client = new CachingHttpClient($client, $store);

        try {
            $response = $client->request('POST', 'http://163.172.67.144:8042/api/v1/validate', [
                'json' => [array('phoneNumber' => $phoneNumber, "countryCode" => $country)]
            ]);

            if($response->getStatusCode() === 200 && $response->toArray()[0][self::OUTPUT][self::IS_VALID]){
                return $response->toArray()[0];
            }

        }   catch (TransportExceptionInterface |
                ClientExceptionInterface |
                DecodingExceptionInterface |
                RedirectionExceptionInterface |
                ServerExceptionInterface $e) {

            throw new NonLockAPIException("il y a eu un soucis avec la validation, veuillez re essayer dans un instant");
        }

        return array();
    }


    public function validateByAPI(String $country, String $phoneNumber){

        $client = HttpClient::createForBaseUri('http://163.172.67.144:8042/',[
            'auth_basic' => 'api:azpihviyazfb'
        ]);

        try {


            $response = $client->request('POST', 'http://163.172.67.144:8042/api/v1/validate', [
                'json' => [array('phoneNumber' => $phoneNumber, "countryCode" => $country)]
            ]);

            if($response->getStatusCode() === 200 && $response->toArray()[0]["output"]["isValid"]){
                return true;
            }

        }   catch (TransportExceptionInterface |
        ClientExceptionInterface |
        DecodingExceptionInterface |
        RedirectionExceptionInterface |
        ServerExceptionInterface $e) {

            throw new CallAPIException("il y a eu un soucis avec la validation, veuillez re essayer dans un instant");
        }

        var_dump($response->toArray(false));
        return false;

    }

    /**
     * Persist entity CallRequest
     *
     * @param CallRequest $callRequest
     */
    public function save(CallRequest $callRequest){
        $this->em->persist($callRequest);
        $this->em->flush();
    }

    /**
     * @param $page Number by offset $limit
     * @param $limit Number of unit by page
     * @return object[]
     */
    public function getPaginatedRequests($page, $limit){

        $pagination = $this->paginator->paginate(
            $this->em->getRepository(CallRequest::class)->findAll(),
            $page,
            $limit
        );
        $pagination->setTemplate('@KnpPaginator/Pagination/twitter_bootstrap_v4_pagination.html.twig');
        return $pagination;
    }
}