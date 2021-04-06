<?php

namespace common\models;

use Yii;
use console\forms\News as ImportForm;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string $title
 * @property string $url
 * @property string|null $image
 * @property string $external_id
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'news';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'url' => 'Url',
            'image' => 'Image',
            'external_id' => 'External ID',
        ];
    }

    /**
     * @param ImportForm $form
     * @return static
     */
    public static function createFromImport(ImportForm $form): self
    {
        $record = new static();
        $record->title = $form->title;
        $record->image = $form->image;
        $record->external_id = $form->id;
        $record->url = $form->url;

        if (!$record->save()) {
            throw new \RuntimeException('Error saving news record');
        }

        return $record;
    }
}
