<?php
declare(strict_types=1);

namespace Abs\LoginAsCustomerLink\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 *  Loginas customer main UI class.
 */

class LoginAsCustomer extends Column
{
    /**
     * @var Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

     /**
      * Constructor
      * 
      * @param ContextInterface      $context
      * @param UiComponentFactory    $uiComponentFactory
      * @param UrlInterface          $urlBuilder
      * @param StoreManagerInterface $storeManager
      * @param array                 $components
      * @param array                 $data
      */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        StoreManagerInterface $storeManager,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->storeManager = $storeManager;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Ui Url For Coloumn.
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                if (array_key_exists('entity_id', $item)) {
                    $entityId = $item['entity_id'];
                    $url =  $storeUrl = $this->storeManager->getStore()->getBaseUrl()."customerlogin/process/index/customer_id/".$entityId;
                    $html = '<a target="_blank" href="'.$url.'" class="adminPassword action-default primary add">Login As Customer</a>';
                        $item[$fieldName] = $html;
                }
            }
        }
        return $dataSource;
    }
}
