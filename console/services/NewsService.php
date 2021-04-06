<?php

namespace console\services;

use console\components\news\Parser;

/**
 * Class NewsService
 * @package console\services
 */
class NewsService
{
    /**
     * @param string $newsResource
     * @return Parser
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function import(string $newsResource): Parser
    {
        $parser = new Parser($newsResource);
        return $parser->parse();
    }
}
