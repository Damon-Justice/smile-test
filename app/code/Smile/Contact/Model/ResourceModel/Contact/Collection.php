<?php

namespace Smile\Contact\Model\ResourceModel\Contact;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';

    protected function _construct()
    {
        $this->_init('Smile\Contact\Model\Contact', 'Smile\Contact\Model\ResourceModel\Contact');
    }
}
