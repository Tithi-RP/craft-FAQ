<?php

namespace faqmanage\craftfaq\services;

use craft\base\Component;
use faqmanage\craftfaq\models\Faq;
use faqmanage\craftfaq\records\FaqRecord;

class FaqService extends Component
{
    public static function getAllFaqs()
    {
        $records = FaqRecord::find()->orderBy(['id' => SORT_DESC])->all();
        $faqs = [];
        foreach ($records as $record) {
            $faqs[] = new Faq($record->toArray());
        }
        return $faqs;
    }
    
    public static function getFaqById($id)
    {
        $record = FaqRecord::findOne($id);
        if ($record) {
            return new Faq($record->toArray());
        }
        return null;
    }

    public static function saveFaq(Faq $faq)
    {
        if ($faq->validate()) {
            if ($faq->id) {
                $record = FaqRecord::findOne($faq->id);
                if (!$record) {
                    throw new \yii\web\NotFoundHttpException("FAQ not found");
                }
            } else {
                $record = new FaqRecord();
            }

            $record->setAttributes($faq->getAttributes(), false);
            return $record->save();
        }
        return false;
    }

    public static function deleteFaqById($id)
    {
        $record = FaqRecord::findOne($id);
        if ($record) {
            return $record->delete();
        }
        return false;
    }
}
