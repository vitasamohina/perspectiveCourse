<?php
namespace Samohina\ShipPay\Observer;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
class PaymentMethodDisable implements ObserverInterface {
    private $_customerSession;

    private $shipPayTerms;

    private $checkoutSession;

    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \Samohina\ShipPay\Model\ShipPayTerms $shipPayTerms,
        \Magento\Checkout\Model\Session $checkoutSession
    ) {
        $this->_customerSession = $customerSession;
        $this->shipPayTerms = $shipPayTerms;
        $this->checkoutSession = $checkoutSession;
    }
    public function execute(Observer $observer) {
        $this->shipPayTerms->getSelectedPayment();
        $baseSubtotalWithDiscount = $this->checkoutSession->getQuote()->getBaseSubtotalWithDiscount();
        $quoteItemsQty=$this->checkoutSession->getQuote()->getItemsQty();
        $payment_method_code = $observer->getEvent()->getMethodInstance()->getCode();

        if (($this->shipPayTerms->getIsEnable() && $this->shipPayTerms->isLargeWholesale() && (int)$baseSubtotalWithDiscount > (int)$this->shipPayTerms->getTotal() && $payment_method_code !== $this->shipPayTerms->getSelectedPayment())
            || ($this->shipPayTerms->getIsEnable() && $this->shipPayTerms->isWholesale() && (int)$quoteItemsQty > (int)$this->shipPayTerms->getQuantity() && $payment_method_code !== $this->shipPayTerms->getSelectedPayment())
        ) {
            $result = $observer->getEvent()->getResult();

                    $result->setData('is_available', false);

        }
    }
}
