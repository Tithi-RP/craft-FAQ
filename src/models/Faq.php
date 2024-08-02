<?php

namespace faqmanage\craftfaq\models;

use craft\base\Model;

class Faq extends Model
{
    public $id;
    public $question;
    public $answer;
    public $type;
    public $dateCreated;
    public $dateUpdated;
    public $uid;

    public function rules(): array
    {
        return [
            [['question', 'answer', 'type'], 'required'],
            [['id'], 'integer'],
            [['question', 'answer', 'type'], 'string'],
            [['dateCreated', 'dateUpdated', 'uid'], 'safe'],
        ];
    }
}
