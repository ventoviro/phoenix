<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace {$package.namespace$}{$package.name.cap$};

use Symfony\Component\Yaml\Yaml;
use Windwalker\Core\Package\AbstractPackage;
use Windwalker\Event\Dispatcher;
use Windwalker\Filesystem\File;
use Windwalker\Filesystem\Folder;

/**
 * The {$package.name.cap$}Package class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class {$package.name.cap$}Package extends AbstractPackage
{
	/**
	 * initialise
	 *
	 * @throws  \LogicException
	 * @return  void
	 */
	public function initialise()
	{
		parent::initialise();
	}

	/**
	 * prepareExecute
	 *
	 * @return  void
	 */
	protected function prepareExecute()
	{
		$this->checkAccess();
	}

	/**
	 * checkAccess
	 *
	 * @return  void
	 */
	protected function checkAccess()
	{

	}

	/**
	 * postExecute
	 *
	 * @param string $result
	 *
	 * @return  string
	 */
	protected function postExecute($result = null)
	{
		return $result;
	}

	/**
	 * registerListeners
	 *
	 * @param Dispatcher $dispatcher
	 *
	 * @return  void
	 */
	public function registerListeners(Dispatcher $dispatcher)
	{
		parent::registerListeners($dispatcher);
	}

	/**
	 * loadRouting
	 *
	 * @return  mixed
	 */
	public function loadRouting()
	{
		$files = Folder::files(__DIR__ . '/Resources/routing');
		$routes = array();

		foreach ($files as $file)
		{
			$ext = File::getExtension($file);

			if ($ext != 'yml')
			{
				continue;
			}

			$routes = array_merge($routes, Yaml::parse(file_get_contents($file)));
		}

		return $routes;
	}
}
