<?php
namespace Smile\Contact\Controller\Adminhtml\Contact;

class Edit extends \Smile\Contact\Controller\Adminhtml\Contact
{
    protected $_resultPageFactory = false;

    protected $_resultPage;

    protected $_contactModel;

    protected $_emailModel;

    protected $_scopeConfig;

    protected $session;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Smile\Contact\Model\Contact $contactModel,
        \Smile\Contact\Model\Email $emailModel,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Customer\Model\Session $session
    ) {
        $this->_resultPageFactory = $resultPageFactory;
        $this->_contactModel = $contactModel;
        $this->_emailModel = $emailModel;
        $this->_scopeConfig = $scopeConfig;
        $this->session = $session;
        parent::__construct($context);
    }

    public function execute()
    {
        $request = $this->getRequest();
        if (!$request->isPost()) {
            $this->_setPageData();
            return $this->getResultPage();
        } else {
            $messageData = $request->getPostValue();
            /* Receiver Detail  */
            $receiverInfo = [
                'name' => 'Name',
                'email' => isset($messageData['email']) ? $messageData['email'] : $this->session->getCustomer()->getEmail()
            ];
            /* Sender Detail  */
            $senderInfo = [
                'name' => $this->_scopeConfig->getValue(
                    'trans_email/ident_general/name',
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                ),
                'email' => $this->_scopeConfig->getValue(
                    'trans_email/ident_general/email',
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                ),
            ];
            $resultRedirect = $this->resultRedirectFactory->create();
            $messageId = $this->getRequest()->getParam('entity_id');
            if ($messageId) {
                $this->_contactModel->load($messageId);
            }
            if ($messageData['send_answer']) {
                $messageData['status'] = '1';
            }
            $this->_contactModel->setData($messageData);
            try {
                $this->_contactModel->save();
                if (($messageId) && ($messageData['send_answer'])) {
                    $emailTemplateVariables = $messageData;
                    $this->_emailModel->sendMail($emailTemplateVariables, $senderInfo, $receiverInfo);
                    $this->messageManager->addSuccess(__('Answer has been sent successfully.'));
                } elseif (($messageId) && !($messageData['send_answer'])) {
                    $this->messageManager->addSuccess(__('Message has been saved successfully.'));
                }
                return $resultRedirect->setPath('*/*/index', array('_current' => true));
            } catch (\Exception $e) {
                $this->messageManager->addException(
                    $e,
                    __('Something went wrong while saving message.')
                );

                return $resultRedirect->setPath('*/*/edit', array('_current' => true));
            }
        }
    }

    public function getResultPage()
    {
        if (is_null($this->_resultPage)) {
            $this->_resultPage = $this->_resultPageFactory->create();
        }
        return $this->_resultPage;
    }

    protected function _setPageData()
    {
        $resultPage = $this->getResultPage();
        $filterId = $this->getRequest()->getParam('id');
        if ($filterId) {
            $resultPage->getConfig()->getTitle()->prepend((__('Message Information')));
            $resultPage->addBreadcrumb(__('Message Information'), __('Message Information'));
        }

        return $this;
    }
}
