<?php

namespace Lmr\AutoTranslator;

use Craft;
use craft\base\{Event, Model, Plugin as BasePlugin};
use craft\elements\Entry;
use craft\events\ModelEvent;
use Lmr\AutoTranslator\Contracts\FieldResolverInterface;
use Lmr\AutoTranslator\Contracts\PolicyInterface;
use Lmr\AutoTranslator\Contracts\TranslationServiceInterface;
use Lmr\AutoTranslator\Fields\Resolver;
use Lmr\AutoTranslator\Models\Settings;
use Lmr\AutoTranslator\Translator\Translator;

class Plugin extends BasePlugin
{
    /**
     * @var string $schemaVersion
     */
    public string $schemaVersion = '1.0.0';

    /**
     * @var bool $hasCpSettings
     */
    public bool $hasCpSettings = true;

    /**
     * @return array[]
     */
    public static function config(): array
    {
        return [
            'components' => [
                'translator' => [
                    'class' => Translator::class,
                ],
            ],
        ];
    }

    /**
     * @return void
     */
    public function init(): void
    {
        parent::init();

        Craft::$app->onInit(function() {
            $this->bindDependencies();
            $this->attachEventHandlers();
        });
    }

    /**
     * @return void
     */
    private function bindDependencies(): void
    {
        $config = $this->getSettings();

        Craft::$container->set(FieldResolverInterface::class, Resolver::class);
        Craft::$container->set(PolicyInterface::class, $config->policy);
        Craft::$container->set(TranslationServiceInterface::class, $config->services[$config->service]);
    }

    /**
     * @return void
     */
    private function attachEventHandlers(): void
    {
        Event::on(Entry::class, Entry::EVENT_AFTER_PROPAGATE, function (ModelEvent $event) {

            $config = $this->getSettings();

            $entry = $event->sender;
            $translatableSections = $config->translate;
            $sectionHandle = $entry->section->handle;

            if (! $config->enabled || ! isset($translatableSections[$sectionHandle])) {
                return;
            }

            $this->translator->queueTranslation($event->sender);
        });
    }

    /**
     * @return \craft\base\Model|null
     */
    protected function createSettingsModel(): ?Model
    {
        return new Settings();
    }

    /**
     * @return string|null
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \yii\base\Exception
     */
    protected function settingsHtml(): ?string
    {
        $config = $this->getSettings();
        $services = $config->services;

        $serviceSelect = array_combine(array_keys($services), array_map(function ($value) {
            return ucfirst($value);
        }, array_keys($services)));

        $languages = array_unique(array_map(function ($site) {
            return $site->language;
        }, Craft::$app->sites->getAllSites()));


        return Craft::$app->getView()->renderTemplate(
            'auto-translator/settings',
            [
                'settings' => $this->getSettings(),
                'serviceOptions' => $serviceSelect,
                'languageOptions' => array_combine($languages, $languages),
            ],
        );
    }
}
