<?php

namespace LaravelRouteCoverage\Report\Html;

use LaravelRouteCoverage\RouteCollection;
use LaravelRouteCoverage\Report\AbstractReport;

/**
 *
 */
class Reporter extends AbstractReport
{
    /**
     * @param RouteCollection $routeCollection
     *
     * @return void
     */
    public function generate(RouteCollection $routeCollection)
    {
        $this->makeResources();
        $this->generateAllRoutes($routeCollection);
        $this->generateGroupByController($routeCollection);
    }

    /**
     * @return void
     */
    public function makeResources(): void
    {
        if (!file_exists($this->basePath . '/public/route-coverage/css')) {
            mkdir($this->basePath . '/public/route-coverage/css', 0755);
        }
        if (!file_exists($this->basePath . '/public/route-coverage/js')) {
            mkdir($this->basePath . '/public/route-coverage/js', 0755);
        }

        copy(__DIR__ . '/template/css/bootstrap.min.css', $this->basePath . '/public/route-coverage/css/bootstrap.min.css');
        copy(__DIR__ . '/template/js/bootstrap.bundle.min.js', $this->basePath . '/public/route-coverage/js/bootstrap.bundle.min.js');
    }

    /**
     * @param RouteCollection $routeCollection
     *
     * @return void
     * @throws \Exception
     */
    public function generateAllRoutes(RouteCollection $routeCollection)
    {
        $content = '<html><title>Route coverage report</title>';
        $content .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
        $content .= '<script src="js/bootstrap.bundle.min.js"></script>';
        $content .= '<body>';
        $content .= '<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
  <symbol id="home" viewBox="0 0 16 16" fill="currentColor">
    <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5z"></path>
  </symbol>
</svg>';

        $content .= $this->getNavbar();
        $content .= '<div class="container-fluid"><div class="row">';
        $content .= $this->getSidebarMenu('all-routes');
        $content .= '<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">';
        $content .= '<h2>Coverage ' . $routeCollection->getCoveragePercent() . '% </h2>';
        $content .= '<h4>All routes ' . $routeCollection->count() . ' </h4>';
        $content .= '<h4>Tested routes ' . $routeCollection->getTestedRouteStatistic()->count() . ' </h4>';

        $content .= '<div class="table-responsive">';
        $content .= '<table class="table">';
        $content .= '<thead class="table-light"><td>URL</td><td>Methods</td><td>Controller</td><td>Action</td><td>Number of tests</td><td></td></thead>';
        $content .= '<tbody>';
        foreach ($routeCollection->sortRotesByTests()->get() as $route) {
            $hash = uniqid();

            $methods = '';
            foreach ($route['methods'] as $method) {
                $methods .= '<span class="btn btn-primary btn-sm">' . $method . '</span>';
            }
            $content .= '<tr>';
            $content .= '<td>' . $route['url'] . ' </td>';
            $content .= '<td class="methods">' . $methods . ' </td>';
            $content .= '<td><div>' . $route['controller'] . '</div><div class="fw-lighter mt-1" style="font-size: 12px;">' . $route['namespace'] . '</div> </td>';
            $content .= '<td>' . $route['action'] . ' </td>';
            $content .= '<td class="count">' . $route['count'] . ' </td>';

            if (isset($route['files'])) {
                $content .= '<td>
                    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' . $hash . '" aria-expanded="false" aria-controls="collapse' . $hash . '">
                        Files
                    </button>
                </td>';
            } else {
                $content .= '<td/>';
            }
            $content .= '</tr>';

            if (isset($route['files'])) {
                $content .= '<tr id="collapse' . $hash . '" class="collapse" style="background-color: lavender;">';

                $content .= '<td colspan="6">';

                $content .= '<table class="table">';
                $content .= '<thead class="table-light"><td>File</td></thead>';
                $content .= '<tbody>';
                foreach ($route['files'] as $file) {
                    $content .= '<tr>';
                    $content .= '<td>' . $file . ' </td>';
                    $content .= '</tr>';
                }
                $content .= '</tbody></table>';
                $content .= '</td></tr>';
            }
        }
        $content .= '</tbody></table>';

        $content .= '</div></main></div></div></body></html>';

        $this->saveFile('all-routes.html', $content);
    }

    /**
     * @param RouteCollection $routeCollection
     *
     * @return void
     * @throws \Exception
     */
    public function generateGroupByController(
        RouteCollection $routeCollection
    ) {
        $content = '<html><title>Route coverage report</title>';
        $content .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
        $content .= '<script src="js/bootstrap.bundle.min.js"></script>';
        $content .= '<body>';
        $content .= '<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
  <symbol id="home" viewBox="0 0 16 16" fill="currentColor">
    <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5z"></path>
  </symbol>
</svg>';

        $content .= $this->getNavbar();
        $content .= '<div class="container-fluid"><div class="row">';
        $content .= $this->getSidebarMenu('controllers');
        $content .= '<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">';
        $content .= '<h2>Coverage ' . $routeCollection->getCoveragePercent() . '% </h2>';
        $content .= '<h4>All routes ' . $routeCollection->count() . ' </h4>';
        $content .= '<h4>Tested routes ' . $routeCollection->getTestedRouteStatistic()->count() . ' </h4>';

        $content .= '<table class="table">';
        $content .= '<thead class="table-light"><td>Controller</td><td>Tested / All</td><td></td></thead>';
        $content .= '<tbody>';
        foreach ($routeCollection->groupByController()->sortControllerByTests()->get() as $controller) {
            $content .= '<tr>';
            $content .= '<td><div>' . $controller['controller'] . '</div><div class="fw-lighter mt-1" style="font-size: 12px;">' . $controller['namespace'] . '</div> </td>';
            $content .= '<td>' . $controller['testedActions'] . ' / ' . $controller['countActions'] . ' </td>';
            $content .= '<td>
<button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' . $controller['controller'] . '" aria-expanded="false" aria-controls="collapse' . $controller['controller'] . '">
    More
  </button>
</td>';
            $content .= '</tr>';
            $content .= '<tr id="collapse' . $controller['controller'] . '" class="collapse" style="background-color: lavender;">';

            $content .= '<td colspan="3">';

            $content .= '<table class="table">';
            $content .= '<thead class="table-light"><td>URL</td><td>Methods</td><td>Action</td><td>Count</td></thead>';
            $content .= '<tbody>';
            foreach ($controller['actions'] as $route) {
                $content .= '<tr>';
                $content .= '<td>' . $route['url'] . ' </td>';
                $content .= '<td class="methods">' . implode(', ', $route['methods']) . ' </td>';
                $content .= '<td>' . $route['action'] . ' </td>';
                $content .= '<td class="count">' . $route['count'] . ' </td>';
                $content .= '</tr>';
            }
            $content .= '</tbody></table>';

            $content .= '</td></tr>';
        }
        $content .= '</tbody></table>';

        $content .= '</main></div></div></body></html>';

        $this->saveFile('group-by-controller.html', $content);
    }

    /**
     * @param string $route
     *
     * @return string
     */
    public function getSidebarMenu(string $route): string
    {
        return '<nav id="sidebarMenu" class="col-md-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav nav-pills flex-column mb-auto">
          <li class="link-dark nav-item">
            <a href="all-routes.html" class="' . ($route === 'all-routes' ? 'active' : '') . ' nav-link" aria-current="page">
              <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
              All routes
            </a>
      </li>
      <li>
        <a href="group-by-controller.html" class="' . ($route === 'controllers' ? 'active' : '') . ' nav-link" aria-current="page">
          <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
          Controllers
        </a>
      </li>
        </ul>
      </div>
    </nav>';
    }

    /**
     * @return string
     */
    public function getNavbar(): string
    {
        return '
        <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
            <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">RouteCoverage</a>
            <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </header>';
    }
}
