<?php

namespace Samohina\PurchaseOneClick\Model;

use Magento\Checkout\Model\Session;
use Samohina\PurchaseOneClick\Logger\Logger;
use Magento\Catalog\Model\ProductFactory;
use Magento\Quote\Model\Quote\Address\Rate;
use Magento\Quote\Api\CartManagementInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Quote\Api\CartRepositoryInterface;
use \Samohina\PurchaseOneClick\Helper\Data;

class CreateOrder
{
    const COUNTRY_CODE = 'UA';
    const PAYMENT_METHOD = 'checkmo';
    const SHIPPING_METHOD = 'freeshipping_freeshipping';

    const CUSTOMER_EMAIL = 'user@gmail.com';
    const CUSTOMER_FIRSTNAME = 'Заказ в 1 клик';
    const CUSTOMER_LASTNAME = 'Customer';

    const CUSTOMER_PHONE = '050 111 11 11';
    const SHIPPING_STREET = '-';
    const SHIPPING_CITY = '-';
    const SHIPPING_POSTCODE = '11111';
    const PRODUCT_QTY = 1;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var ProductFactory
     */
    protected $productFactory;

    /**
     * @var CartRepositoryInterface
     */
    protected $cartRepositoryInterface;

    /**
     * @var Rate
     */
    protected $shippingRate;

    /**
     * @var CartManagementInterface
     */
    protected $cartManagementInterface;

    private $helperData;

    private $customerFactory;

    private $addressRepository;
    /**
     * CreateOrder constructor.
     *
     * @param Rate $rate
     * @param Logger $logger
     * @param Session $session
     * @param ProductFactory $productFactory
     * @param StoreManagerInterface $storeManager
     * @param CartManagementInterface $cartManagement
     * @param CartRepositoryInterface $cartRepository
     */
    public function __construct(
        Rate $rate,
        Logger $logger,
        Session $session,
        ProductFactory $productFactory,
        StoreManagerInterface $storeManager,
        CartManagementInterface $cartManagement,
        CartRepositoryInterface $cartRepository,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        Data $helperData,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Customer\Api\AddressRepositoryInterface $addressRepository
    )
    {
        $this->logger = $logger;
        $this->session = $session;
        $this->shippingRate = $rate;
        $this->storeManager = $storeManager;
        $this->productFactory = $productFactory;
        $this->cartRepositoryInterface = $cartRepository;
        $this->cartManagementInterface = $cartManagement;
        $this->helperData = $helperData;
        $this->customerFactory  = $customerFactory;
        $this->customerRepository = $customerRepository;
        $this->addressRepository = $addressRepository;

    }

    /**
     * Create Order
     *
     * @param $productId
     * @param $customerPhone
     * @return bool
     */
    public function createOrder($productId, $customerName, $customerSurname, $customerEmail, $customerPhone )
    {
        try {
            $getCustomer = $this->checkEmail($customerEmail);
            if (!$getCustomer){
                $this->createCustomer($customerName, $customerEmail, $customerSurname);
            }else{
                if (!$customerName){
                    $customerName = $getCustomer->getFirstname();
                }
                if (!$customerSurname){
                    $customerSurname = $getCustomer->getLastname();
                }
                if (!$customerPhone){
                    $billingAddressId = $getCustomer->getDefaultBilling();
                    try {
                        $billingAddress = $this->addressRepository->getById($billingAddressId);
                        $telephone = $billingAddress->getTelephone();
                        $customerPhone = $telephone;
                    } catch (\Exception $e) {
                        $this->logger->info('[CreateOrder] ERROR: ' . $e->getMessage());
                        $this->logger->info('Line - ' . $e->getLine() . ', ' . $e->getFile());
                        $this->logger->info($e->getTraceAsString());
                    }
                }
            }

            $cartId = $this->cartManagementInterface->createEmptyCart();

            /** @var \Magento\Quote\Model\Quote $cart */
            $cart = $this->cartRepositoryInterface->get($cartId)
                ->setCheckoutMethod(CartManagementInterface::METHOD_GUEST)
                ->setStore($this->getStore())
                ->setCurrency()
                ->setCustomerEmail($customerEmail)
                ->setBuyOneClick("Yes")
                ->setCustomerFirstname(self::CUSTOMER_FIRSTNAME)
                ->setCustomerLastname(self::CUSTOMER_LASTNAME);

            $cart->addProduct(
                $this->getProduct($productId),
                self::PRODUCT_QTY
            );
            $address = $this->prepareAddress($customerName, $customerSurname, $customerPhone);
            $cart->getBillingAddress()->addData($address);
            $cart->getShippingAddress()->addData($address);

            $this->shippingRate
                ->setCode($this->getSelectedShipping() ? $this->getSelectedShipping().'_'.$this->getSelectedShipping() : self::SHIPPING_METHOD)
                ->getPrice(1);

            $cart->getShippingAddress()->addShippingRate($this->shippingRate);
            $cart->setPaymentMethod($this->getSelectedPayment() ? $this->getSelectedPayment() : self::PAYMENT_METHOD)
                ->setInventoryProcessed(false);

            $cart->getPayment()->importData(['method' => $this->getSelectedPayment() ? $this->getSelectedPayment() : self::PAYMENT_METHOD]);
            $cart->save();

            $this->session->setStoreLocation($this->getSelectedShipping() ? $this->getSelectedShipping().'_'.$this->getSelectedShipping() : self::SHIPPING_METHOD);

            $cart = $this->cartRepositoryInterface->get($cart->getId());
            //$order=$this->cartManagementInterface->placeOrder($cart->getId());
            $order=$this->cartManagementInterface->submit($cart);
            $increment_id = $order->getIncrementId();


            return $increment_id;
        } catch (\Exception $e) {
            $this->logger->info('[CreateOrder] ERROR: ' . $e->getMessage());
            $this->logger->info('Line - ' . $e->getLine() . ', ' . $e->getFile());
            $this->logger->info($e->getTraceAsString());
        }

        return false;
    }

    /**
     * Prepare address
     *
     * @param $customerPhone
     * @return array
     */
    protected function prepareAddress($customerName, $customerSurname, $customerPhone)
    {
        $address = [
            'firstname' => $customerName ? $customerName : self::CUSTOMER_FIRSTNAME,
            'lastname' => $customerSurname ? $customerSurname : self::CUSTOMER_LASTNAME,
            'street' => self::SHIPPING_STREET,
            'city' => self::SHIPPING_CITY,
            'country_id' => self::COUNTRY_CODE,
            'region' => '',
            'postcode' => self::SHIPPING_POSTCODE,
            'telephone' => $customerPhone ? $customerPhone : self::CUSTOMER_PHONE,
            'fax' => '',
            'save_in_address_book' => 0,
            'shipping_method' => $this->getSelectedShipping() ? $this->getSelectedShipping().'_'.$this->getSelectedShipping() : self::SHIPPING_METHOD
        ];

        return $address;
    }

    /**
     * Retrieve product by id
     *
     * @param $productId
     * @return \Magento\Catalog\Model\Product
     */
    protected function getProduct($productId)
    {
        return $this->productFactory->create()->load($productId);
    }

    /**
     * Retrieve current store
     *
     * @return \Magento\Store\Api\Data\StoreInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function getStore()
    {
        return $this->storeManager->getStore();
    }

    /**
     * Retrieve store currency code
     *
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function getCurrencyCode()
    {
        return $this->getStore()->getCurrentCurrency()->getCode();
    }
    public function getSelectedPayment() {
        return $this->helperData->getGeneralConfig('paymentlist');
    }
    public function getSelectedShipping() {
        return $this->helperData->getGeneralConfig('shipmentlist');
    }
    public function createCustomer($customerName, $customerEmail, $customerSurname)
    {
            $websiteId = $this->storeManager->getStore()->getWebsiteId();
            $customer   = $this->customerFactory->create();
            $customer->setWebsiteId($websiteId);
            $customer->setStore($this->storeManager->getStore());
            $customer->setEmail($customerEmail);
            $customer->setFirstname($customerName ? $customerName : self::CUSTOMER_FIRSTNAME);
            $customer->setLastname($customerSurname ? $customerSurname : self::CUSTOMER_LASTNAME);
            $customer->setPassword("password");
            $customer->save();
    }
    public function checkEmail($customerEmail)
    {
        try {
            $websiteId = $this->storeManager->getStore()->getWebsiteId();
            return $this->customerRepository->get($customerEmail, $websiteId);
        } catch (\Exception $e) {
            $this->logger->info('[CreateOrder] ERROR: ' . $e->getMessage());
            $this->logger->info('Line - ' . $e->getLine() . ', ' . $e->getFile());
            $this->logger->info($e->getTraceAsString());
        }
        return false;
    }
}
