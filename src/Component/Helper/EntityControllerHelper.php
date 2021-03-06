<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 26.08.2018
 * Time: 12:03
 */

namespace App\Component\Helper;


use App\Component\ActionMenu\ActionMenu;
use App\Component\ActionMenu\ActionMenuManager;
use App\Component\ActionMenu\Exception;
use App\Component\Launcher\Launcher;
use App\Component\Toolbar\Toolbar;
use App\Component\Toolbar\ToolbarManager;
use App\Util\HtmlTitle;
use Doctrine\Common\Annotations\Reader;
use RuntimeException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class EntityControllerHelper
{
    protected Launcher $launcher;
    protected ActionMenuManager $actionMenuManager;
    protected ToolbarManager $toolbarManager;
    protected RequestStack $requestStack;
    protected Reader $annotationsReader;
    protected HtmlTitle $htmlTitle;
    protected SessionInterface $session;

    /**
     * AdminControllerHelper constructor.
     * @param Launcher $launcher
     * @param ActionMenuManager $actionMenuManager
     * @param ToolbarManager $toolbarManager
     * @param RequestStack $requestStack
     * @param Reader $annotations_reader
     * @param SessionInterface $session
     * @param HtmlTitle $html_title
     */
    public function __construct(Launcher $launcher,
                                ActionMenuManager $actionMenuManager,
                                ToolbarManager $toolbarManager,
                                RequestStack $requestStack,
                                Reader $annotations_reader,
                                SessionInterface $session,
                                HtmlTitle $html_title)
    {
        $this->annotationsReader = $annotations_reader;
        $this->launcher = $launcher;
        $this->actionMenuManager = $actionMenuManager;
        $this->toolbarManager = $toolbarManager;
        $this->requestStack = $requestStack;
        $this->session = $session;
        $this->htmlTitle = $html_title;
    }

    /**
     * @return Launcher
     */
    public function getLauncher(): Launcher
    {
        return $this->launcher;
    }

    /**
     * @return ActionMenuManager
     */
    public function getActionMenuManager(): ActionMenuManager
    {
        return $this->actionMenuManager;
    }

    /**
     * @return ToolbarManager
     */
    public function getToolbarManager(): ToolbarManager
    {
        return $this->toolbarManager;
    }

    /**
     * @param null $id
     * @return Toolbar
     * @throws \App\Component\Toolbar\Exception
     */
    public function getToolbar($id = null)
    {
        if (is_null($id)) {
            return $this->toolbarManager->getInstance();
        }
        return $this->toolbarManager->getInstance($id);
    }

    /**
     * @param null $id
     * @return ActionMenu
     * @throws Exception
     */
    public function getActionMenu($id = null)
    {
        if (is_null($id)) {
            return $this->actionMenuManager->getInstance();
        }
        return $this->actionMenuManager->getInstance($id);
    }

    public function getRequestStack(): RequestStack
    {
        return $this->requestStack;
    }

    /**
     * @return null|Request
     */
    public function getMasterRequest()
    {
        return $this->requestStack->getMasterRequest();
    }

    /**
     * @param null|string $suffix
     * @return string
     */
    public function getModulePath(?string $suffix = null): string
    {
        if (is_scalar($suffix)) {
            $suffix = ltrim($suffix, '/');
        }
        $data = explode('/', '/' . trim($this->getMasterRequest()->getPathInfo(), '/'));
        if (sizeof($data) < 2) {
            throw new RuntimeException('unable to get module path not from a module');
        }
        $data = array_slice($data, 0, 2);
        if ($suffix) {
            $data[] = $suffix;
        }
        return join('/', $data);
    }

    /**
     * @return string
     */
    public function getBundlePath()
    {
        $data = explode('/', '/' . trim($this->getMasterRequest()->getPathInfo(), '/'));
        if (sizeof($data) < 2) {
            throw new RuntimeException('unable to get bundle path not from a bundle');
        }
        return join('/', array_slice($data, 0, 2));
    }

    /**
     * @return Reader
     */
    public function getAnnotationsReader(): Reader
    {
        return $this->annotationsReader;
    }

    /**
     * @return HtmlTitle
     */
    public function getHtmlTitle(): HtmlTitle
    {
        return $this->htmlTitle;
    }

    /**
     * @param HtmlTitle $htmlTitle
     * @return EntityControllerHelper
     */
    public function setHtmlTitle(HtmlTitle $htmlTitle): EntityControllerHelper
    {
        $this->htmlTitle = $htmlTitle;
        return $this;
    }

    /**
     * @return SessionInterface
     */
    public function getSession(): SessionInterface
    {
        return $this->session;
    }
}
