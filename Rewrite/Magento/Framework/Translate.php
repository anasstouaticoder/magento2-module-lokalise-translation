<?php
/**
 * Copyright (c) 2024
 * MIT License
 * Module AnassTouatiCoder_LokaliseTranslation
 * Author Anass TOUATI anass1touati@gmail.com
 */

declare(strict_types=1);

namespace AnassTouatiCoder\LokaliseTranslation\Rewrite\Magento\Framework;

use AnassTouatiCoder\LokaliseTranslation\Model\APIService;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\View\DesignInterface;
use Magento\Framework\Cache\FrontendInterface;
use Magento\Framework\View\FileSystem;
use Magento\Framework\Module\ModuleList;
use Magento\Framework\Module\Dir\Reader;
use Magento\Framework\App\ScopeResolverInterface;
use Magento\Framework\Translate\ResourceInterface;
use Magento\Framework\Locale\ResolverInterface;
use Magento\Framework\App\State;
use Magento\Framework\Filesystem as FrameworkFilesystem;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\File\Csv;
use Magento\Framework\App\Language\Dictionary;
use Magento\Framework\Translate as MagentoTranslate;
use Magento\Framework\Filesystem\DriverInterface;

class Translate extends MagentoTranslate
{
    /**
     * @var APIService
     */
    protected APIService $APIService;

    /**
     * @param DesignInterface $viewDesign
     * @param FrontendInterface $cache
     * @param FileSystem $viewFileSystem
     * @param ModuleList $moduleList
     * @param Reader $modulesReader
     * @param ScopeResolverInterface $scopeResolver
     * @param ResourceInterface $translate
     * @param ResolverInterface $locale
     * @param State $appState
     * @param FrameworkFilesystem $filesystem
     * @param RequestInterface $request
     * @param Csv $csvParser
     * @param Dictionary $packDictionary
     * @param APIService $APIService
     * @param DriverInterface|null $fileDriver
     */
    public function __construct(
        DesignInterface        $viewDesign,
        FrontendInterface      $cache,
        FileSystem             $viewFileSystem,
        ModuleList             $moduleList,
        Reader                 $modulesReader,
        ScopeResolverInterface $scopeResolver,
        ResourceInterface      $translate,
        ResolverInterface      $locale,
        State                  $appState,
        FrameworkFilesystem    $filesystem,
        RequestInterface       $request,
        Csv                    $csvParser,
        Dictionary             $packDictionary,
        APIService             $APIService,
        DriverInterface        $fileDriver = null
    ) {
        $this->APIService = $APIService;

        parent::__construct(
            $viewDesign,
            $cache,
            $viewFileSystem,
            $moduleList,
            $modulesReader,
            $scopeResolver,
            $translate,
            $locale,
            $appState,
            $filesystem,
            $request,
            $csvParser,
            $packDictionary,
            $fileDriver
        );
    }

    /**
     * Load data including translations from Lokalise
     *
     * @param string|null $area
     * @param bool $forceReload
     * @return $this
     */
    public function loadData($area = null, $forceReload = false): self
    {
        $this->_data = [];
        if ($area === null) {
            $area = $this->_appState->getAreaCode();
        }
        $this->setConfig([self::CONFIG_AREA_KEY => $area]);

        if (!$forceReload) {
            $data = $this->_loadCache();
            if ($data !== false) {
                $this->_data = $data;
                return $this;
            }
        }

        $this->_loadModuleTranslation();
        $this->_loadPackTranslation();
        $this->_loadThemeTranslation();
        $this->_loadDbTranslation();

        // add Lokalise Translation
        $this->loadLokaliseTranslations();

        if (!$forceReload) {
            $this->_saveCache();
        }

        return $this;
    }

    /**
     * Load data including translations from Lokalise
     *
     * @return void
     * @throws LocalizedException
     */
    protected function loadLokaliseTranslations(): void
    {
        $data = $this->APIService->getLokaliseTranslations($this->getLocale(), $this->_appState->getAreaCode());
        $this->_addData($data);
    }
}
