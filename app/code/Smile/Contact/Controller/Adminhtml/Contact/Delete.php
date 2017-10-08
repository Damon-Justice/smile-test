<?php

namespace Smile\Contact\Controller\Adminhtml\Contact;

class Delete extends \Smile\Contact\Controller\Adminhtml\Contact
{
    protected $_contactModel;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Smile\Contact\Model\Contact $contactModel
    ) {
        parent::__construct($context);
        $this->_contactModel = $contactModel;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');

        if (!($contactModel = $this->_contactModel->load($id))) {
            $this->messageManager->addError(__('Unable to proceed. Please, try again.'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/index', array('_current' => true));
        }
        try {
            $contactModel->delete();
            $this->messageManager->addSuccess(__('This message has been deleted!'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__('Error while trying to delete this message!'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/index', array('_current' => true));
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/index', array('_current' => true));
    }
}
