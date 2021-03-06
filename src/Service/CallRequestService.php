<?php


namespace App\Service;


use App\Entity\CallRequest;
use App\Exception\CallAPIException;
use App\Exception\NonLockAPIException;
use App\Repository\CallRequestRepository;
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
    const OUTPUT = "output";
    const IS_VALID = "isValid";
    const NATIONAL = "national";
    const INTERNATIONAL = "international";
    const URL_API_PHONE_BASE = 'http://163.172.67.144:8042/';
    const URL_API_PHONE_VALIDATE = 'api/v1/validate';
    const PHONE_NUMBER = "phoneNumber";
    const COUNTRY = 'country';

    /**
     * @var PaginatorInterface
     */
    protected $paginator;

    /**
     * @var CallRequestRepository
     */
    protected $callRequestRepository;

    private $_apiUser;
    private $_apiPassword;


    /**
     * ValidationService constructor.
     * @param String $apiUser
     * @param String $apiPassword
     * @param CallRequestRepository $callRequestRepository
     * @param PaginatorInterface $paginator
     */
    public function __construct(string $apiUser, string $apiPassword, CallRequestRepository $callRequestRepository, PaginatorInterface $paginator)
    {
        $this->_apiUser = $apiUser;
        $this->_apiPassword = $apiPassword;
        $this->paginator = $paginator;
        $this->callRequestRepository = $callRequestRepository;
    }

    /**
     * Validate object CallRequest
     *
     * @param CallRequest $callRequest
     * @return CallRequest
     */
    public function validateCallRequest(CallRequest $callRequest)
    {
        try {
            $response = $this->getPhoneInfoByAPI($callRequest->getCountry(), $callRequest->getPhoneNumber());
            $callRequest->setNational($response[self::OUTPUT][self::NATIONAL]);
            $callRequest->setInternational($response[self::OUTPUT][self::INTERNATIONAL]);
            return $callRequest;
        } catch (NonLockAPIException $nlapie) {
            throw new CallAPIException($nlapie->getMessage());
        }
    }

    /**
     * @param String $country
     * @param String $phoneNumber
     * @return array|mixed
     */
    private function getPhoneInfoByAPI(string $country, string $phoneNumber)
    {

        $store = new Store('/cache/PhoneAPI/');
        $client = HttpClient::createForBaseUri(self::URL_API_PHONE_BASE, [
            'auth_basic' => $this->_apiUser . ":" . $this->_apiPassword
        ]);
        $client = new CachingHttpClient($client, $store);

        try {
            $response = $client->request('POST', self::URL_API_PHONE_BASE . self::URL_API_PHONE_VALIDATE, [
                'json' => [array(self::PHONE_NUMBER => $phoneNumber, "countryCode" => $country)]
            ]);

            if ($response->getStatusCode() === 200) {
                $result = $response->toArray();

                if (!empty($result) && $result[0][self::OUTPUT][self::IS_VALID]) {
                    return $response->toArray()[0];
                }
            }
            throw new NonLockAPIException("Le numéro de téléphone n'est pas valide !");

        } catch (TransportExceptionInterface |
        ClientExceptionInterface |
        DecodingExceptionInterface |
        RedirectionExceptionInterface |
        ServerExceptionInterface $e) {

            throw new NonLockAPIException("il y a eu un soucis avec la validation, veuillez re essayer dans un instant");
        }

    }

    /**
     * return true if the phone number is valid,
     * false otherwise
     *
     * @param array $callRequestArray
     * @return bool
     */
    public function isPhoneNumberValid(array $callRequestArray)
    {
        $retour = $this->checkCallRequestArray($callRequestArray);

        if ($retour) {
            try {
                $response = $this->getPhoneInfoByAPI($callRequestArray[self::COUNTRY], $callRequestArray[self::PHONE_NUMBER]);
                if (empty($response) || !$response[self::OUTPUT][self::IS_VALID]) {
                    $retour = false;
                }
            } catch (NonLockAPIException $nlapie) {
                $retour = false;
            }
        }

        return $retour;
    }

    /**
     * Check the content of the array Call Request
     *
     * @param array $callRequestArray
     * @return bool
     */
    private function checkCallRequestArray(array $callRequestArray)
    {
        $retour = false;

        if (!empty($callRequestArray) &&
            array_key_exists(self::COUNTRY, $callRequestArray) &&
            array_key_exists(self::PHONE_NUMBER, $callRequestArray) &&
            '' !== trim($callRequestArray[self::COUNTRY]) &&
            '' !== trim($callRequestArray[self::PHONE_NUMBER])) {
            $retour = true;
        }

        return $retour;
    }

    /**
     * @param CallRequest $callRequest
     */
    public function save(CallRequest $callRequest)
    {
        $this->callRequestRepository->saveCallRequest($callRequest);
    }

    /**
     * @param $page Number by offset $limit
     * @param $limit Number of unit by page
     * @return object[]
     */
    public function getPaginatedRequests($page, $limit)
    {

        $pagination = $this->paginator->paginate(
            $this->callRequestRepository->getAllCallRequest(),
            $page,
            $limit
        );
        $pagination->setTemplate('@KnpPaginator/Pagination/twitter_bootstrap_v4_pagination.html.twig');
        return $pagination;
    }
}