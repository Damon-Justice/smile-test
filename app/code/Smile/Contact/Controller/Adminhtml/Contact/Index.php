<?php

namespace Smile\Contact\Controller\Adminhtml\Contact;

class Index extends \Magento\Backend\App\Action
{
    protected $_resultPageFactory = false;
    protected $_resultPage;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $this->_setPageData();
        return $this->getResultPage();
    }

    public function getResultPage()
    {
        if (is_null($this->_resultPage)) {
            $this->_resultPage = $this->_resultPageFactory->create();
        }
        return $this->_resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Smile_Contact::admin');
    }

    protected function _setPageData()
    {
        $resultPage = $this->getResultPage();
        $resultPage->setActiveMenu('Smile_Contact::admin');
        $resultPage->getConfig()->getTitle()->prepend((__('Messages')));
        $resultPage->addBreadcrumb(__('Messages'), __('Messages'));

        return $this;
    }
}
