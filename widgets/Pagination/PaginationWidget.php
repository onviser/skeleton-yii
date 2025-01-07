<?php declare(strict_types=1);

namespace app\widgets\Pagination;

use yii\base\Widget;
use yii\data\Pagination;

class PaginationWidget extends Widget
{
    protected const LIMIT_DEFAULT = 10;

    public Pagination $pagination;
    public int $limit = self::LIMIT_DEFAULT;
    public string $view = 'index';
    public string $url = '/';
    public array $params = [];

    /**
     * @return string
     */
    public function run(): string
    {
        $page = $this->pagination->getPage();
        $pageTotal = $this->pagination->getPageCount();

        return $this->render($this->view, [
            'pagePrev'   => $this->getUrlPrev($page, $pageTotal),
            'pageNext'   => $this->getUrlNext($page, $pageTotal),
            'pages'      => $this->getPages($page, $pageTotal),
            'pagination' => $this->pagination
        ]);
    }

    /**
     * @param int $page
     * @param int $pageTotal
     * @return array
     */
    protected function getPages(int $page, int $pageTotal): array
    {
        $pages = [];
        if ($pageTotal > $this->limit) {
            $interval = 3;
            if ($page <= $interval || $page > $pageTotal - $interval) {
                for ($i = 1; $i <= $interval + 1; $i++) {
                    $pages[$i] = $this->getUrl($i);
                }
                $pages['...'] = '';
                for ($i = $pageTotal - $interval; $i <= $pageTotal; $i++) {
                    $pages[$i] = $this->getUrl($i);
                }
            } else {
                $pages[1] = $this->getUrl(1);
                $pages['..<'] = '';
                $pages[$page - 1] = $this->getUrl($page - 1);
                $pages[$page] = $this->getUrl($page);
                $pages[$page + 1] = $this->getUrl($page + 1);
                $pages['..>'] = '';
                $pages[$pageTotal] = $this->getUrl($pageTotal);
            }

        } else {
            for ($i = 1; $i <= min($this->limit, $pageTotal); $i++) {
                $pages[$i] = $this->getUrl($i);
            }
        }
        return $pages;
    }

    /**
     * @param int $page
     * @param int $pageTotal
     * @return string
     */
    protected function getUrlPrev(int $page, int $pageTotal): string
    {
        if ($pageTotal <= $this->limit) {
            return '';
        }
        return $page > 1 ? $this->getUrl($page - 1) : '';
    }

    /**
     * @param int $page
     * @param int $pageTotal
     * @return string
     */
    protected function getUrlNext(int $page, int $pageTotal): string
    {
        if ($pageTotal <= $this->limit) {
            return '';
        }
        return $page < $pageTotal ? $this->getUrl($page + 1) : '';
    }

    /**
     * @param int $page
     * @return string
     */
    protected function getUrl(int $page): string
    {
        $this->params['page'] = $page;
        if ($page === 1) {
            unset($this->params['page']);
        }
        $query = http_build_query($this->params);
        return $this->url . ($query === '' ? '' : '?' . $query);
    }
}