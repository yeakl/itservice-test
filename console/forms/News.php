<?php

namespace console\forms;

use yii\base\Model;

/**
 * Class News
 * @package console\forms
 */
class News extends Model
{
    public string $title;
    public ?string $image;
    public string $url;
    public string $id;

    /**
     * News constructor.
     * @param $id
     * @param $title
     * @param $url
     * @param $image
     * @param array $config
     */
    public function __construct($id, $title, $url, $image, $config = [])
    {
        $this->id = $id;
        $this->title = $title;
        $this->image = $image;
        $this->url = $url;
        parent::__construct($config);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['title', 'url'], 'required'],
            [['image'], 'string'],
            [['id'], 'unique', 'targetClass' => \common\models\News::class, 'targetAttribute' => 'external_id'],
        ];
    }
}
