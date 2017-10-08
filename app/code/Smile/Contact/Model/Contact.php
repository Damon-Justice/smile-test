<?php

namespace Smile\Contact\Model;

class Contact extends \Magento\Framework\Model\AbstractModel
{
    const CACHE_TAG = 'contact_us';

    protected function _construct()
    {
        $this->_init('Smile\Contact\Model\ResourceModel\Contact');
    }
}
