<?php

namespace console\components\news;

use yii\helpers\Json;
use yii\httpclient\Client;

/**
 * Class LifeRu
 * @package console\components\news
 */
class LifeRu extends Resource
{
    public $url = 'https://api.corr.life/public/sections/5e01383bf4352e43d960b258/posts?after=1617621518036';
    public $baseArticleUrl = 'https://life.ru/p/';

    /**
     * @return array|Record
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function getRecords(): array
    {
        $client = new Client();
        $client = $client
            ->createRequest()
            ->setMethod('GET')
            ->setUrl($this->url)
            ->setData(['limit' => $this->limit]);

        $response = $client->send();

        if (!$response->isOk) {
            throw new \DomainException('Could not load news');
        }

        $content = $response->getContent();

        $newsList = Json::decode($content, true)['data'];
        foreach ($newsList as $newsRecord) {
            $record = new Record();
            $record->id = $newsRecord['_id'];
            $record->title = $newsRecord['title'];
            $record->url = "{$this->baseArticleUrl}{$newsRecord['index']}";
            $record->image = $newsRecord['cover']['url'];
            $this->records[] = $record;
        }

        return $this->records;
    }
}
