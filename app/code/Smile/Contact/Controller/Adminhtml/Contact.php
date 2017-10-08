<?php

namespace Smile\Contact\Controller\Adminhtml;

abstract class Contact extends \Magento\Backend\App\Action
{
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(
            'Smile_Contact::messages'
        );
    }
}
