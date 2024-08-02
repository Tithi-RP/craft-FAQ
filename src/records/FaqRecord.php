<?php

namespace faqmanage\craftfaq\records;

use craft\db\ActiveRecord;

class FaqRecord extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%faqmanager_faqs}}';
    }
}
