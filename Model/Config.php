<?php
/**
 * Copyright (c) 2024
 * MIT License
 * Module AnassTouatiCoder_LokaliseTranslation
 * Author Anass TOUATI anass1touati@gmail.com
 */

declare(strict_types=1);

namespace AnassTouatiCoder\LokaliseTranslation\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    protected const XML_PATH_ENABLED = 'lokalise_translation/general/enabled';
    protected const XML_PATH_API_TOKEN = 'lokalise_translation/general/api_token';
    protected const XML_PATH_PROJECT_ID = 'lokalise_translation/general/project_id';
    protected const XML_PATH_DEBUG = 'lokalise_translation/general/debug';

    /**
     * @var ScopeConfigInterface
     */
    protected ScopeConfigInterface $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Get Is enabled
     *
     * @param int $storeId
     * @return bool
     */
    public function isEnabled($storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ENABLED, ScopeInterface::SCOPE_STORE, $storeId);
    }

    /**
     * Get API TOKEN
     *
     * @param int $storeId
     * @return string
     */
    public function getApiToken($storeId = null): string
    {
        return (string)$this->scopeConfig->getValue(self::XML_PATH_API_TOKEN, ScopeInterface::SCOPE_STORE, $storeId);
    }

    /**
     * Get project ID
     *
     * @param int $storeId
     * @return string
     */
    public function getProjectId($storeId = null): string
    {
        return (string)$this->scopeConfig->getValue(self::XML_PATH_PROJECT_ID, ScopeInterface::SCOPE_STORE, $storeId);
    }

    /**
     * Get is Debug
     *
     * @param int $storeId
     * @return bool
     */
    public function isDebug($storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_DEBUG, ScopeInterface::SCOPE_STORE, $storeId);
    }
}
