<?php
/**
 * Copyright (c) 2024
 * MIT License
 * Module AnassTouatiCoder_LokaliseTranslation
 * Author Anass TOUATI anass1touati@gmail.com
 */

declare(strict_types=1);

namespace AnassTouatiCoder\LokaliseTranslation\Controller\Adminhtml\ApiConnection;

use AnassTouatiCoder\LokaliseTranslation\Model\APIService;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\ScopeInterface;

class TestAPI extends Action
{
    /**
     * @var APIService
     */
    private APIService $APIService;
    /**
     * @var int|null
     */
    private ?int $scopeId = null;
    /**
     * @var string
     */
    private string $scope = 'default';

    /**
     * @param Context $context
     * @param APIService $APIService
     */
    public function __construct(Context $context, APIService $APIService)
    {
        $this->APIService = $APIService;
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $this->initScope();
        try {

            $data = $this->APIService->getProject($this->scopeId, $this->scope);
            $this->messageManager->addSuccessMessage(__('Connected to project %1', $data['name']));
        } catch (LocalizedException | \Exception $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
        }
        return $this->resultRedirectFactory->create()->setUrl($this->_redirect->getRefererUrl());
    }

    /**
     * Init Scope data
     *
     * @return void
     */
    private function initScope(): void
    {
        $params = $this->getRequest()->getParams();
        if (isset($params['store'])) {
            $this->scope = ScopeInterface::SCOPE_STORES;
            $this->scopeId = (int)$params['store'];
        } elseif (isset($params['website'])) {
            $this->scope = ScopeInterface::SCOPE_WEBSITES;
            $this->scopeId = (int)$params['website'];
        }
    }
}
