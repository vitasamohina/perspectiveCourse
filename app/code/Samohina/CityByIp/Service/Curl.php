<?php
namespace Samohina\CityByIp\Service;

use Samohina\CityByIp\Helper\Data;
/**
 * Сервисный класс для синхронизации данных с novaposhta.ua
 */
class Curl
{
    private $helperData;
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var \Magento\Framework\HTTP\Client\Curl
     */
    private $curl;

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\HTTP\Client\Curl $curl
     */
    public function __construct(
            Data $helperData,
            \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
            \Magento\Framework\HTTP\Client\Curl $curl
            )
    {
        $this->helperData = $helperData;
        $this->scopeConfig = $scopeConfig;
        $this->curl = $curl;
    }
    public function getNovaPoshtaKey()
    {
        return $this->helperData->getGeneralConfig('novaposhta_key');
    }
    /**
     * @param array $params
     * @return array
     */
    public function getDataImport($params)
    {
        $apiKey = $this->getNovaPoshtaKey();

        $params['apiKey'] = $apiKey;

        $this->curl->setHeaders(["content-type: application/json"]);
        $this->curl->post("https://api.novaposhta.ua/v2.0/json/", json_encode($params));

        $json = $this->curl->getBody();
        $data = json_decode($json, true)['data'];

        return $data;
    }
}
