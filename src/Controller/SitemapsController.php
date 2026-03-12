<?php

namespace App\Controller;

use Cake\Cache\Cache;
use Cake\Http\Response;
use Cake\Routing\Router;
use Cake\View\XmlView;

class SitemapsController extends AppController
{
    protected array $viewClasses = [XmlView::class];

    public function initialize(): void
    {
        parent::initialize();
        $this->Authentication->allowUnauthenticated(['index']);
        $this->Authorization->skipAuthorization();
    }

    public function index(): Response
    {
        $cacheKey    = __METHOD__;
        $cacheConfig = 'sitemap';

        $urls = Cache::remember($cacheKey, function (): array {
            $urls = [];

            $latestModifiedCat = $this->fetchTable('Cats')->find(fields: ['modified'])->orderByDesc('modified')->first();
            if ($latestModifiedCat) {
                $urls[] = [
                    'loc'     => Router::url([
                        'controller' => 'Cats',
                        'action'     => 'index',
                    ], true),
                    'lastmod' => $latestModifiedCat->modified->format('Y-m-d'),
                ];
            }

            $cats = $this->fetchTable('Cats')->find(fields: ['id', 'modified'])->orderByAsc('id')->all();
            foreach ($cats as $cat) {
                $urls[] = [
                    'loc'     => Router::url([
                        'controller' => 'Cats',
                        'action'     => 'view',
                        $cat->id,
                    ], true),
                    'lastmod' => $cat->modified->format('Y-m-d'),
                ];
            }

            return $urls;
        }, $cacheConfig);

        // Define a custom root node in the generated document.
        $this->viewBuilder()->setOption('rootNode', 'urlset')->setOption('serialize', ['@xmlns', 'url']);

        $this->set([
            // Define an attribute on the root node.
            '@xmlns' => 'http://www.sitemaps.org/schemas/sitemap/0.9',
            'url'    => $urls,
        ]);

        return $this->render();
    }
}
