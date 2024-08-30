<?php

namespace faqmanage\craftfaq\migrations;

use Craft;
use craft\db\Migration;

/**
 * Install migration.
 */
class Install extends Migration
{
    /**
     * @inheritdoc
     */

        public function safeUp()
        {
            $this->createTable('{{%faqmanager_faqs}}', [
                'id' => $this->primaryKey(),
                'question' => $this->text()->notNull(),
                'answer' => $this->text()->notNull(),
                'type' => $this->string(255)->notNull(),
                'dateCreated' => $this->dateTime()->notNull(),
                'dateUpdated' => $this->dateTime()->notNull(),
                'uid' => $this->uid()->notNull(),
            ]);
        }

    /**
     * @inheritdoc
     */
    public function safeDown(): bool
    {
        $this->removeTables();
        return false;
    }
}
