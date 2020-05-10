<?php

use yii\db\Migration;

/**
 * Class m200510_000330_create_article
 */
class m200510_000330_create_article extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'title' => $this->string()->notNull(),
            'content' => $this->text()->notNull(),
            'is_publish' => $this->boolean()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex(
            'idx-article-user_id',
            'article',
            'user_id'
        );

        $this->addForeignKey(
            'fk__article__user_id__to__user__id',
            'article',
            'user_id',
            'user',
            'id'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk__article__user_id__to__user__id',
            'article'
        );
        $this->dropIndex(
            'idx-article-user_id',
            'article'
        );
        $this->dropTable('article');
    }
}
