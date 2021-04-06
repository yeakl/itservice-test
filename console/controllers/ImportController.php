<?php

namespace console\controllers;

use console\services\NewsService;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Class ImportController
 * @package console\controllers
 */
class ImportController extends Controller
{
    /**
     * @var NewsService $service
     */
    private NewsService $service;

    public function __construct($id, $module, NewsService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * @param $resource
     * @return bool|int
     */
    public function actionNews($resource)
    {
        try {
            $import = $this->service->import($resource);
            return $this->stdout(
                'Done! Successful: ' . $import->success . ' | Skipped: ' . $import->skipped . ' | Errors: ' .  $import->errors . "\n",
                Console::FG_GREEN
            );
        } catch (\RuntimeException | \DomainException $exception) {
            return $this->stderr($exception->getMessage(), Console::FG_RED);
        } catch (\Exception $exception) {
            return $this->stderr('Error: Something went wrong', Console::FG_RED);
        }
    }
}
