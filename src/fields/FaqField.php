<?php

namespace faqmanage\craftfaq\fields;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use faqmanage\craftfaq\services\FaqService;

class FaqField extends Field
{
    // Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('faqmanage', 'FAQ Field');
    }

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        $rules = parent::rules();
        $rules[] = [['id'], 'number', 'integerOnly' => true];
        return $rules;
    }

    /**
     * @inheritdoc
     */
/*     public function getInputHtml($value, ?ElementInterface $element = null): string
    {
        // Get our id and namespace
        $id = Craft::$app->getView()->formatInputId($this->handle);
        $namespaceId = Craft::$app->getView()->namespaceInputId($id);

        // Get all FAQs
        $faqs = FaqService::getAllFaqs();

        // Render the input template
        return Craft::$app->getView()->renderTemplate(
            'faq/_components/fields/FaqField_input',
            [
                'name' => $this->handle,
                'value' => $value,
                'faqs' => $faqs,
                'id' => $id,
                'namespaceId' => $namespaceId,
            ]
        );
    }

    /**
     * @inheritdoc
     */
    /*public function serializeValue(mixed $value, ?ElementInterface $element = null): mixed
    {
        return $value ? (int)$value : null;
    } */

    public function getInputHtml($value, ?ElementInterface $element = null): string
    {
        $id = Craft::$app->getView()->formatInputId($this->handle);
        $namespaceId = Craft::$app->getView()->namespaceInputId($id);
        $faqs = FaqService::getAllFaqs();

        return Craft::$app->getView()->renderTemplate(
            'faq/_components/fields/FaqField_input',
            [
                'name' => $this->handle,
                'value' => $value,
                'faqs' => $faqs,
                'id' => $id,
                'namespaceId' => $namespaceId,
            ]
        );
    }
}
