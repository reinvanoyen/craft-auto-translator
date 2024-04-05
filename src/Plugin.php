<?php

namespace Lmr\AutoTranslator;

use Craft;
use craft\base\{Event, Model, Plugin as BasePlugin};
use craft\elements\Entry;
use craft\events\ModelEvent;
use Lmr\AutoTranslator\Contracts\Policy;
use Lmr\AutoTranslator\Contracts\TranslationService;
use Lmr\AutoTranslator\Models\Settings;
use Lmr\AutoTranslator\Translator\DefaultTranslator;

class Plugin extends BasePlugin
{
    /**
     * @var string $schemaVersion
     */
    public string $schemaVersion = '1.0.0';

    /**
     * @return array[]
     */
    public static function config(): array
    {
        return [
            'components' => [
                'translator' => [
                    'class' => DefaultTranslator::class,
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

        Craft::$container->set(Policy::class, $config->policy);
        Craft::$container->set(TranslationService::class, $config->services[$config->service]);
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

            $this->translator->scheduleTranslation($event->sender);
        });
    }

    /**
     * @return \craft\base\Model|null
     */
    protected function createSettingsModel(): ?Model
    {
        // @TODO check if there's no better way in Craft/YII (how to cache, merge, extend???)
        $values = require __DIR__.'/config.php';
        return new Settings($values);
    }
}
