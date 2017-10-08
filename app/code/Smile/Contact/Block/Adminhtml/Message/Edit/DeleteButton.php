<?php
namespace Smile\Contact\Block\Adminhtml\Message\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class DeleteButton
 */
class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    protected $request;

    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Request\Http $request
    ) {
        parent::__construct($context, $registry);
        $this->urlBuilder = $context->getUrlBuilder();
        $this->registry = $registry;
        $this->request = $request;
    }

    /**
     * @return array
     */
    public function getButtonData()
    {
        $data = [];
        $params = $this->request->getParams();
        if (isset($params['id'])) {
            $data = [
                'label' => __('Delete Message'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\''
                    . __('Are you sure you want to delete this message?')
                    . '\', \'' . $this->getDeleteUrl() . '\')',
                'sort_order' => 20,
            ];
        }
        return $data;
    }

    /**
     * @return string
     */
    public function getDeleteUrl()
    {
        $data = $this->request->getParams();
        return $this->getUrl('*/*/delete', ['id' => $data['id']]);
    }
}
