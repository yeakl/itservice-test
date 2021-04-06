<?php

namespace console\components\news;

use console\forms\News as NewsForm;
use common\models\News;

class Parser
{
    public int $errors = 0;
    public int $success = 0;
    public int $skipped = 0;

    /**
     * @var Resource $resource
     */
    public $resource;

    /**
     * Parser constructor.
     * @param string $resource
     */
    public function __construct(string $resource)
    {
        switch ($resource) {
            case 'liferu':
                $this->resource = new LifeRu();
                break;
            default:
                throw new \RuntimeException("Resource {$resource} is not supported!\n");
        }
    }

    /**
     * @return self
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function parse(): self
    {
        $records = $this->resource->getRecords();

        /**
         * @var $records Record[]
         */
        foreach ($records as $record) {
            $form = new NewsForm($record->id, $record->title, $record->url, $record->image);
            if (!$form->validate()) {
                $this->skipped++;
                continue;
            }

            try {
                News::createFromImport($form);
                $this->success++;
            } catch (\RuntimeException $e) {
                $this->errors++;
            }

        }

        return $this;
    }
}
