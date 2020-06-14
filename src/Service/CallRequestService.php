<?php


namespace App\Service;


use App\Entity\CallRequest;
use App\Exception\CallAPIException;
use Doctrine\ORM\EntityManagerInterface;
use http\Exception\RuntimeException;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpClient\HttpClient;
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

    /**
     * ValidationService constructor.
     * @param EntityManagerInterface $entityManager
     * @param PaginatorInterface $paginator
     */
    public function __construct(EntityManagerInterface $entityManager, PaginatorInterface $paginator)
    {
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
        //$this->validateByAPI($callRequest->getCountry(), $callRequest->getPhoneNumber());
        $callRequest->setNational($callRequest->getPhoneNumber());
        $callRequest->setInternational($callRequest->getPhoneNumber());
        return $callRequest;
    }

    public function validateByAPI(String $country, String $phoneNumber){
        $client = HttpClient::createForBaseUri('http://163.172.67.144:8042/',[
           'auth_basic' => 'api:azpihviyazfb'
        ]);

        try {
            $response = $client->request('POST', 'http://163.172.67.144:8042/api/v1/validate', [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => ['phoneNumber' => $phoneNumber, "countryCode" => $country]
            ]);
            var_dump($response->toArray());

        } catch (TransportExceptionInterface |
                ClientExceptionInterface |
                DecodingExceptionInterface |
                RedirectionExceptionInterface |
                ServerExceptionInterface $e) {

            throw new CallAPIException($e);
        }

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