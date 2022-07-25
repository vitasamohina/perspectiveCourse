<?php
namespace Samohina\Sales\Controller\Index;
class Sales extends \Magento\Framework\App\Action\Action
{
    private $pageFactory;
    private $salesFactory;
    private $salesResource;
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Samohina\Sales\Model\SalesFactory $salesFactory,
        \Samohina\Sales\Model\ResourceModel\Sales $salesResource
    )
    {
        $this->pageFactory = $pageFactory;
        $this->salesFactory = $salesFactory;
        $this->salesResource = $salesResource;
        return parent::__construct($context);
    }
    public function execute()
    {
       /* $salesModel = $this->salesFactory->create();
        $sampleData = [
            [
                'product_name' => 'Преобразователь UKC авто инвертор 12V-220V',
                'qnt' => '2',
                'date' => '2022-05-07',
                'price' => '500',
                'bonus' => '0.7',
            ],
            [
                'product_name' => 'Кофе в зернах Ferarra',
                'qnt' => '10',
                'date' => '2022-04-05',
                'price' => '500',
                'bonus' => '0.1',
            ]
            ];
        foreach ($sampleData as $data){
            $salesModel->setData($data);
            $this->salesResource->save($salesModel);
        }*/
        return $this->pageFactory->create();
    }
}
