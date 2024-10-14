<?php
/**
 * Copyright (c) 2024
 * MIT License
 * Module AnassTouatiCoder_LokaliseTranslation
 * Author Anass TOUATI anass1touati@gmail.com
 */

declare(strict_types=1);

namespace AnassTouatiCoder\LokaliseTranslation\Block\Adminhtml\Form\Api;

use Magento\Backend\Block\Widget\Button;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class TestConnectionButton extends Field
{
    /**
     * Retrieve element HTML markup
     *
     * @param AbstractElement $element
     * @return string
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        /** @var \Magento\Backend\Block\Widget\Button $buttonBlock  */
        $buttonBlock = $this->getForm()->getLayout()->createBlock(Button::class);

        $website = $buttonBlock->getRequest()->getParam('website');
        $store   = $buttonBlock->getRequest()->getParam('store');

        $params = [
            'website' => $website,
            'store'   => $store,
        ];
        $data = [
            'label' => $this->getLabel(),
            'onclick' => 'setLocation("' . $this->getTestUrl($params).'")'
        ];
        $html = $buttonBlock->setData($data)->toHtml();

        return $html;
    }

    /**
     * Get button label
     *
     * @return \Magento\Framework\Phrase
     */
    public function getLabel()
    {
        return  __('Test');
    }

    /**
     * Retrieve Button URL
     *
     * @param array $params
     * @return string
     */
    protected function getTestUrl(array $params = []): string
    {
        return $this->getUrl('at_lokalise/apiConnection/testAPI', $params);
    }
}
