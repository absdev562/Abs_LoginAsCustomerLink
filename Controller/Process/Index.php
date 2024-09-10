<?php
declare(strict_types=1);

namespace Abs\LoginAsCustomerLink\Controller\Process;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\Controller\ResultFactory;
use Magento\Store\Model\App\Emulation;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Session as CustomerSession;

/**
 *  Loginas customer main class.
 */

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

     /**
      * @var Magento\Customer\Api\CustomerRepositoryInterface
      */
    protected $customerRepository;

    /**
     * @var Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var Magento\Framework\Controller\ResultFactory
     */
    protected $resultFactory;

    /**
     * Constructor
     * 
     * @param Context                     $context
     * @param Registry                    $coreRegistry
     * @param CustomerRepositoryInterface $customerRepository
     * @param CustomerSession             $customerSession
     * @param ResultFactory               $resultFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        CustomerRepositoryInterface $customerRepository,
        CustomerSession $customerSession,
        ResultFactory $resultFactory
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->customerRepository = $customerRepository;
        $this->customerSession = $customerSession;
        $this->resultFactory = $resultFactory;
    }
    /**
     * Mapped Process List page.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $rowId = $this->getRequest()->getParam('customer_id');
        $redirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);

        if ($rowId) {

            try {

                $customer = $this->customerRepository->getById($rowId);
                $this->customerSession->setCustomerDataAsLoggedIn($customer);
                $this->messageManager->addSuccess(__('You are loggedin as customer : '.$customer->getEmail()));
            
                $redirect->setPath('customer/account');
                return $redirect;

            } catch (\Exception $e) {
                $this->messageManager->addError(__('You can not loggedin as customer'));
                $redirect->setPath('');
                return $redirect;
            }
        }   

        $this->messageManager->addError(__('You can not loggedin as customer'));
        $redirect->setPath('');
        return $redirect;
    }
}
