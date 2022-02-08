<?php namespace App\Component\ActionMenu;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class Route extends Action
{
    private string $route;
    private array $parameters;

    public function __construct(string $route, array $parameters = [])
    {
        $this->route = $route;
        $this->parameters = $parameters;
    }

    public static function getRouter(): UrlGeneratorInterface
    {
        return self::$router;
    }

    public static function setRouter(UrlGeneratorInterface $router): void
    {
        self::$router = $router;
    }

    public function getRoute(): string
    {
        return $this->route;
    }

    public function setRoute(string $route): Route
    {
        $this->route = $route;
        return $this;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function setParameters(array $parameters): Route
    {
        $this->parameters = $parameters;
        return $this;
    }

    public function generateUrl(): string
    {
        return static::getRouter()->generate(
            $this->getRoute(),
            $this->getParameters()
        );
    }

    protected static UrlGeneratorInterface $router;
}
