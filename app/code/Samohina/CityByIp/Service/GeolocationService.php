<?php
namespace Samohina\CityByIp\Service;
use Exception;
use Magento\Framework\Filesystem\DirectoryList;
use Magento\Framework\HTTP\Client\CurlFactory;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\HTTP\Client\Curl;
use Samohina\CityByIp\Api\GeolocationServiceInterface;
use Samohina\CityByIp\Helper\Data;
class GeolocationService implements GeolocationServiceInterface
{
    /**
     * @var DirectoryList
     */
    private $dir;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var ResourceConnection
     */
    private $resourceConnection;
    /**
     * @var CurlFactory
     */
    private $curlFactory;

    private $helperData;
    /**
     * LocationRepository constructor.
     *
     * @param CurlFactory $curlFactory
     * @param ResourceConnection $resourceConnection
     * @SuppressWarnings(PHPMD.LongVariable)
     */
    public function __construct(
        Data $helperData,
        DirectoryList $dir,
        LoggerInterface $logger,
        CurlFactory $curlFactory,
        ResourceConnection $resourceConnection
    )
    {
        $this->helperData = $helperData;
        $this->resourceConnection = $resourceConnection;
        $this->curlFactory = $curlFactory;
        $this->logger = $logger;
        $this->dir = $dir;
    }
    public function getIpstackKey()
    {
        return $this->helperData->getGeneralConfig('ipstack_key');
    }
    public function getCityByIp(): string
    {
        $ipAddress = $this->getClientIp();
        $this->logger->debug('IP address is: ' . $ipAddress);
        if ($ipAddress !== 'UNKNOWN') {
            return $this->getCityFromIpStack($ipAddress);
        }
        return '';
    }

    public function getCityFromIpStack(string $ipAddress): string
    {
        //$requestUrl = 'http://api.ipstack.com/91.244.56.202?access_key=' . $this->getIpstackKey() . '&language=ru';
        $requestUrl = 'http://api.ipstack.com/'. $ipAddress .'?access_key=' . $this->getIpstackKey() . '&language=ru';
        /** @var Curl $curl */
        $curl = $this->curlFactory->create();
        $curl->setTimeout(5);
        try {
            $curl->get($requestUrl);
            $body = $curl->getBody();
            $response = json_decode($body, true);
            if(isset($response['city'])) {
                $this->logger->debug($body);
                return $response['city'];
            }
        } catch (Exception $ex) {
            return '';
        }
        return '';
    }
    private function getClientIp()
    {
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
}
