<?php

namespace Smile\Contact\Model;

use Smile\Contact\Model\ResourceModel\Contact\CollectionFactory;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $request;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $testCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $testCollectionFactory,
        \Magento\Framework\App\Request\Http $request,
        array $meta = [],
        array $data = []
    ) {
        $this->request = $request;
        $this->collection = $testCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }
        $params = $this->request->getParams();
        if (isset($params['id'])) {
            $items = $this->collection->getItems();
            foreach ($items as $message) {
                $this->_loadedData[$message->getId()] = $message->getData();
            }
            return $this->_loadedData;
        }
    }
}
