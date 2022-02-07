<?php namespace App\Component\ActionMenu;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ActionMenuManager
{
    private UrlGeneratorInterface $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
        Route::setRouter($router);
    }

    const DEFAULT_INSTANCE_NAME = 'apl-admin-action-menu';

    /** @var ActionMenu[] */
    private array $instances = [];

    /** @throws Exception */
    public function getInstance(string $id = self::DEFAULT_INSTANCE_NAME): ActionMenu
    {
        if (!isset($this->instances[$id])) {
            $this->instances[$id] = new ActionMenu($id);
            if ($id === static::DEFAULT_INSTANCE_NAME) {
                $this->preconfigureDefaultInstance($this->instances[$id]);
            }
        }
        return $this->instances[$id];
    }

    private function preconfigureDefaultInstance(ActionMenu $menu)
    {
        /** @noinspection SpellCheckingInspection */
        $menu->addItem((new MenuItem('toggle_fullscreen', 'Toggle fullscreen'))
            ->setAction(new Handler('screenfull.toggle();'))
            ->addIcon(new Icon('far fa-window-maximize')));
        $menu->addItem((new MenuItem('admin_logout', 'Logout'))
            ->setAction(new Route('security_logout'))
            ->addIcon(new Icon('fas fa-sign-out-alt')));
    }

    public function getRouter(): UrlGeneratorInterface
    {
        return $this->router;
    }

    public function setRouter(UrlGeneratorInterface $router): ActionMenuManager
    {
        $this->router = $router;
        return $this;
    }
}
