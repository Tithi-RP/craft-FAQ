<?php

namespace faqmanage\craftfaq;

use Craft;
use craft\base\Model;
use craft\base\Plugin as BasePlugin;
use faqmanage\craftfaq\models\Settings;
use craft\events\PluginEvent;
use craft\events\RegisterCpNavItemsEvent;
use craft\events\RegisterUrlRulesEvent;
//use craft\helpers\Cp;
use craft\services\Plugins;
use craft\web\UrlManager;
use faqmanage\craftfaq\services\FaqService;
use yii\base\Event;
use craft\web\twig\variables\Cp;
use craft\web\twig\variables\CraftVariable;
use faqmanage\craftfaq\fields\FaqField;
use faqmanage\craftfaq\variables\FaqVariable;

/**
 * Faq plugin
 *
 * @method static Plugin getInstance()
 * @method Settings getSettings()
 * @author FaqManage <tithi92.rp@gmail.com>
 * @copyright FaqManage
 * @license https://craftcms.github.io/license/ Craft License
 */
class Plugin extends BasePlugin
{
    public $schemaVersion = '1.0.0';

    public bool $hasCpSettings = true;

    public static function config(): array
    {
        return [
            'components' => [
                // Define component configs here...
            ],
        ];
    }

    public static $plugin;
    
    public function init()
    {
        parent::init();
        self::$plugin = $this;

/*         $this->setComponents([
            'faqService' => FaqService::class,
        ]); */

        $this->setComponents([
            'faqService' => [
                'class' => FaqService::class,
            ],
        ]);

                
        // Set alias
        Craft::setAlias('@faqmanage/craftfaq', __DIR__);
        Craft::$app->i18n->translations['faqmanage'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@faqmanage/craftfaq/translations',
            'fileMap' => [
                'faqmanage' => 'faqmanage.php',
            ],
        ];

        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['faq'] = 'faq/faq/index';
                $event->rules['faq/new'] = 'faq/faq/edit';
                $event->rules['faq/edit/<faqId:\d+>'] = 'faq/faq/edit';
                $event->rules['faq/delete/<faqId:\d+>'] = 'faq/faq/delete';
            }
        );

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                    // Plugin has been installed
                }
            }
        );

        Event::on(
            \craft\services\Fields::class,
            \craft\services\Fields::EVENT_REGISTER_FIELD_TYPES,
            function (\craft\events\RegisterComponentTypesEvent $event) {
                $event->types[] = FaqField::class;
            }
        );

        Event::on(
            Cp::class,
            Cp::EVENT_REGISTER_CP_NAV_ITEMS,
            function (RegisterCpNavItemsEvent $event) {
                $event->navItems[] = [
                    'url' => 'admin/faq',
                    'label' => Craft::t('app', 'FAQs'),
                ];
            }
        );

        // Register the variable
        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('faq', FaqVariable::class);
            }
        );
        
        Craft::info('FaqManager plugin loaded', __METHOD__);

    }

    protected function createSettingsModel(): ?Model
    {
        return Craft::createObject(Settings::class);
    }

    protected function settingsHtml(): ?string
    {
        return Craft::$app->view->renderTemplate('faq/_settings.twig', [
            'plugin' => $this,
            'settings' => $this->getSettings(),
        ]);
    }

    private function attachEventHandlers(): void
    {
        // Register event handlers here ...
        // (see https://craftcms.com/docs/5.x/extend/events.html to get started)
    }
}
