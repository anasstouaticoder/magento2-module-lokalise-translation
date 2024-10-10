<?php
/**
 * Copyright (c) 2024
 * MIT License
 * Module AnassTouatiCoder_LokaliseTranslation
 * Author Anass TOUATI anass1touati@gmail.com
 */

declare(strict_types=1);

namespace AnassTouatiCoder\LokaliseTranslation\Model;

use Exception;
use Magento\Framework\App\Area;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\Serialize\Serializer\Json;
use Psr\Log\LoggerInterface;

class APIService
{
    private const LOKALISE_ENDPOINT_URL = 'https://api.lokalise.com/api2/projects/';
    private const LANGUAGE_URI = '/languages';
    private const KEY_URI = '/keys';
    /**
     * @var Curl
     */
    private Curl $curl;
    /**
     * @var Config
     */
    private Config $config;
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;
    /**
     * @var Json
     */
    private Json $json;

    /**
     * @param Curl $curl
     * @param Config $config
     * @param LoggerInterface $logger
     * @param Json $json
     */
    public function __construct(
        Curl $curl,
        Config $config,
        LoggerInterface $logger,
        Json $json,
    ) {
        $this->curl = $curl;
        $this->config = $config;
        $this->logger = $logger;
        $this->json = $json;
    }

    /**
     * Main entry
     *
     * @param string $locale
     * @param string $areaCode
     * @return array
     */
    public function getLokaliseTranslations(string $locale, string $areaCode): array
    {
        if ($areaCode !== Area::AREA_FRONTEND) {
            return [];
        }
        try {
            $translations = [];
            if ($this->config->isEnabled()) {
                $languageId = null;
                foreach ($this->getLanguagesList()['languages'] as $language) {
                    if ($locale === $language['lang_iso']) {
                        $languageId = $language['lang_id'];
                        break;
                    }
                }

                if ($languageId !== null) {
                    foreach ($this->getKeyList($languageId)['keys'] as $key) {
                        $translations[$key['key_name']['web']] = $key['translations'][0]['translation'];
                    }
                } else {
                    $this->addLog(
                        'Language locale '. $locale .' not found in Lokalise',
                        ['project_id' => $this->config->getProjectId(), 'api_token' => $this->config->getApiToken()]
                    );
                }
            }
        } catch (LocalizedException|Exception $exception) {
            $translations = [];
        }
        return $translations;
    }

    /**
     * REST API Call
     *
     * @param string $uri
     * @param array $additionalHeaders
     * @param string $params
     * @return array|null
     * @throws LocalizedException
     */
    public function execute(
        string $uri,
        array $additionalHeaders = [],
        string $params = ''
    ): ?array {
        // constructing API URL
        $url = self:: LOKALISE_ENDPOINT_URL . $this->config->getProjectId() . $uri;
        $headers = [
            'X-Api-Token' => $this->config->getApiToken(),
            'accept' => 'application/json',
        ];
        if (!empty($additionalHeaders)) {
            $headers = array_merge($headers, $additionalHeaders);
        }
        if (!empty($params)) {
            $url .= $params;
        }

        $this->curl->setHeaders($headers);
        $this->curl->get($url);

        $response = $this->curl->getBody();

        $responseData = $this->json->unserialize($response);
        if (!$this->isResponseValid($responseData)) {
            $errorData = array_merge(
                ['project_id' => $this->config->getProjectId(), 'api_token' => $this->config->getApiToken()],
                $responseData['error']
            );
            $this->addLog('Connection Error', $errorData);
            throw new LocalizedException(__('Lokalise API Error'));
        }
        return $responseData;
    }

    /**
     * Get languages from Lokalise
     *
     * @return array|null
     * @throws LocalizedException
     */
    protected function getLanguagesList()
    {
        return $this->execute(self::LANGUAGE_URI);
    }

    /**
     * Get keys by language from Lokalise
     *
     * @param int $languageId
     * @return array|null
     * @throws LocalizedException
     */
    protected function getKeyList(int $languageId): ?array
    {
        $queryString = "?filter_translation_lang_ids=$languageId&include_translations=1";

        return $this->execute(self::KEY_URI, [], $queryString);
    }

    /**
     * Check response
     *
     * @param array $response
     * @return bool
     */
    protected function isResponseValid(array $response): bool
    {
        return !isset($response['error']);
    }

    /**
     * Add log for Debugging
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    protected function addLog(string $message, array $context = []): void
    {
        if ($this->config->isDebug()) {
            $this->logger->error($message, $context);
        }
    }
}
