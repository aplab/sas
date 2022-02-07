<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 02.08.2018
 * Time: 10:59
 */

namespace App\Component\InstanceEditor\FieldType;


use App\Entity\Icon;

class FieldTypeRouteVariants extends FieldTypeAbstract
{
    private ?array $data = null;

    const METHOD_GET = 'GET';

    public function getOptionsDataList()
    {
        if (is_null($this->data)) {
            $this->buildData();
        }
        return $this->data;
    }

    private function buildData()
    {
        $router = $this->field->getInstanceEditor()->getInstanceEditorManager()->getRouter();
        $routes = $router->getRouteCollection()->all();
        foreach ($routes as $name => $route) {
            $methods = $route->getMethods();
            if (sizeof($methods) != 1) {
                continue;
            }
            $method = reset($methods);
            if (self::METHOD_GET !== $method) {
                continue;
            }
            $this->data[] = [
                'value' => $route->getPath(),
                'text' => $name,
                'selected' => false,
            ];
        }
    }
}
