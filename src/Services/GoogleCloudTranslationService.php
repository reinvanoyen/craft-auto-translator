<?php

namespace Lmr\AutoTranslator\Services;

use Google\Cloud\Translate\V3\Client\TranslationServiceClient;
use Google\Cloud\Translate\V3\TranslateTextRequest;
use Lmr\AutoTranslator\Contracts\TranslationService;

class GoogleCloudTranslationService implements TranslationService
{
    /**
     * @var TranslationServiceClient $client
     */
    private TranslationServiceClient $client;

    /**
     * @var string $project
     */
    private string $project;

    /**
     * @var string $location
     */
    private string $location;

    /**
     * @param TranslationServiceClient $client
     * @param string $project
     * @param string $location
     */
    public function __construct(TranslationServiceClient $client, string $project, string $location)
    {
        $this->client = $client;
        $this->project = $project;
        $this->location = $location;
    }

    /**
     * @param string $input
     * @param string $fromLanguage
     * @param string $toLanguage
     * @return string
     * @throws \Google\ApiCore\ApiException
     */
    public function translate(string $input, string $fromLanguage, string $toLanguage): string
    {
        // Build the request
        $formattedParent = TranslationServiceClient::locationName($this->project, $this->location);
        $contents = [$input,];
        $request = (new TranslateTextRequest())
            ->setContents($contents)
            ->setSourceLanguageCode($fromLanguage)
            ->setTargetLanguageCode($toLanguage)
            ->setParent($formattedParent);

        // Send the request
        $response = $this->client->translateText($request);

        return $response->getTranslations()[0]->getTranslatedText();
    }
}
