<?php
 
namespace Smile\Contact\Ui\Component\Listing\Grid\Columns;
 
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;
 
class Actions extends Column
{
    /** Url path */
    const SMILE_URL_PATH_EDIT = 'smile/contact/edit';
    const SMILE_URL_PATH_DELETE = 'smile/contact/delete';

    /** @var UrlInterface */
    protected $_urlBuilder;
 
    /**
     * @param ContextInterface   $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface       $urlBuilder
     * @param array              $components
     * @param array              $data
     * @param string             $editUrl
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->_urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
 
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');

                if (isset($item['entity_id'])) {
                    $item[$name]['edit']   = [
                        'href'  => $this->_urlBuilder->getUrl(
                            self::SMILE_URL_PATH_EDIT,
                            ['id' => $item['entity_id']]
                        ),
                        'label' => __('Read')
                    ];
                    $item[$name]['delete'] = [
                        'href'    => $this->_urlBuilder->getUrl(
                            self::SMILE_URL_PATH_DELETE,
                            ['id' => $item['entity_id']]
                        ),
                        'label'   => __('Delete'),
                        'confirm' => [
                            'title'   => __('Delete "${ $.$data.title }"'),
                            'message' => __(
                                'Are you sure you wan\'t to delete a "${ $.$data.name }" record?'
                            )
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}
