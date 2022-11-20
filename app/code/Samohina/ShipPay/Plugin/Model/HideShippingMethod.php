<?php
namespace Samohina\ShipPay\Plugin\Model;

class HideShippingMethod
{
    private $shipPayTerms;

    public function __construct(
        \Samohina\ShipPay\Model\ShipPayTerms $shipPayTerms
    )
    {
        $this->shipPayTerms = $shipPayTerms;
    }
    public function aroundCollectCarrierRates(
        \Magento\Shipping\Model\Shipping $subject,
        \Closure $proceed,
                                         $carrierCode,
                                         $request
    )
    {
        $productItems = $request->getAllItems();

        $qntAllItems=0;
        foreach ($productItems as $item){
            $qntAllItems = $qntAllItems + (int)$item->getQty();
        }

        if (($this->shipPayTerms->getIsEnable() && $this->shipPayTerms->isLargeWholesale() && !is_null($this->shipPayTerms->getTotal()) && (int)$request->getBaseSubtotalInclTax() > (int)$this->shipPayTerms->getTotal() && $carrierCode !== 'freeshipping')
            || ($this->shipPayTerms->getIsEnable() && !is_null($this->shipPayTerms->getTotal()) && $this->shipPayTerms->isLargeWholesale() && $carrierCode !== 'freeshipping')
            || ($this->shipPayTerms->getIsEnable() && $this->shipPayTerms->isWholesale() && !is_null($this->shipPayTerms->getQuantity()) && $qntAllItems > (int)$this->shipPayTerms->getQuantity() && $carrierCode !== $this->shipPayTerms->getSelectedShipping())
            || ($this->shipPayTerms->getIsEnable()  && !is_null($this->shipPayTerms->getQuantity()) && $this->shipPayTerms->isWholesale() && $carrierCode == 'freeshipping')
        ) {

            return false;
        }
        return $proceed($carrierCode, $request);
    }
}
