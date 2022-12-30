<?php
namespace Samohina\PurchaseOneClick\Controller\Index;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Samohina\PurchaseOneClick\Model\CreateOrder;
use Magento\Framework\Controller\Result\RawFactory;


class Index extends Action
{
    /**
     * @var CreateOrder
     */
    protected $createOrder;

    /**
     * @var RawFactory
     */
    protected $resultRawFactory;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param CreateOrder $createOrder
     * @param RawFactory $resultRawFactory
     */
    public function __construct(
        Context $context,
        CreateOrder $createOrder,
        RawFactory $resultRawFactory
    )
    {
        $this->createOrder = $createOrder;
        $this->resultRawFactory = $resultRawFactory;

        return parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        $productId = (int)$this->getRequest()->getPost('product_id');
        $name = $this->getRequest()->getPost('name');
        $surname = $this->getRequest()->getPost('surname');
        $email = $this->getRequest()->getPost('email');
        $telephone = $this->getRequest()->getPost('telephone');

        if ($productId && $email) {
            $isCreated = $this->createOrder->createOrder($productId, $name, $surname, $email, $telephone);

            if ($isCreated) {
                $this->messageManager->addSuccessMessage(__('Thank you for your purchase! Your order # is: %1 .', $isCreated));
                $resultRedirect->setRefererOrBaseUrl();
            } else {
                $this->messageManager->addError(__('Something happened, please try again later.'));
                $resultRedirect->setRefererOrBaseUrl();
            }
        }

        return $resultRedirect;
    }
}
