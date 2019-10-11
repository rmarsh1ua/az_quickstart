<?php

namespace Drupal\azqs_core\Routing;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Route;

class Routes implements ContainerInjectionInterface {

  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Instantiates a Routes object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function routes() {
    $routes = [];

    $config = $this->configFactory->get('azqs_core.settings');
    if ($config->get('monitoring_page.enabled')) {
      $path = $config->get('monitoring_page.path');
      $routes['azqs_core.monitoring_page'] = new Route(
        $path,
        [
          '_controller' => 'Drupal\azqs_core\Controller\MonitoringPageController::deliver',
          '_title' => 'Monitoring Page',
        ],
        [
          '_access' => 'TRUE',
        ]
      );
    }

    return $routes;
  }

}
