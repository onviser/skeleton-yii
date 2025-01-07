<?php declare(strict_types=1);

namespace app\controllers\backend;

use app\models\LogItem;
use Yii;
use yii\data\Pagination;

class LogController extends AbstractBackendController
{
    public function actionIndex(): string
    {
        $params = Yii::$app->request->get();
        $limit = 5;
        $page = array_key_exists('page', $params) ? intval($params['page']) : 1;
        [$total, $items] = (new LogItem())->search($params, $page, $limit);

        $pagination = new Pagination(['totalCount' => $total]);
        $pagination->setPageSize($limit);
        $pagination->setPage($page - 1);

        return $this->render('/backend/log', [
            'pagination' => $pagination,
            'items'      => $items,
        ]);
    }
}