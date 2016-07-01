<?php
/**
 * Part of {$package.name.cap$} project.
 *
 * @copyright  Copyright (C) 2016 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace {$package.namespace$}{$package.name.cap$}\Controller\{$controller.list.name.cap$};

use {$package.namespace$}{$package.name.cap$}\Model\{$controller.list.name.cap$}Model;
use {$package.namespace$}{$package.name.cap$}\View\{$controller.list.name.cap$}\{$controller.list.name.cap$}HtmlView;
use Phoenix\Controller\Display\DisplayController;
use Windwalker\Core\Model\ModelRepository;

/**
 * The GetController class.
 * 
 * @since  1.0
 */
class GetController extends DisplayController
{
	/**
	 * Property name.
	 *
	 * @var  string
	 */
	protected $name = '{$controller.list.name.lower$}';

	/**
	 * Property itemName.
	 *
	 * @var  string
	 */
	protected $itemName = '{$controller.item.name.lower$}';

	/**
	 * Property listName.
	 *
	 * @var  string
	 */
	protected $listName = '{$controller.list.name.lower$}';

	/**
	 * Property model.
	 *
	 * @var  {$controller.list.name.cap$}Model
	 */
	protected $model;

	/**
	 * Property view.
	 *
	 * @var  {$controller.list.name.cap$}HtmlView
	 */
	protected $view;

	/**
	 * Property ordering.
	 *
	 * @var  string
	 */
	protected $defaultOrdering = null;

	/**
	 * Property direction.
	 *
	 * @var  string
	 */
	protected $defaultDirection = null;

	/**
	 * prepareExecute
	 *
	 * @return  void
	 */
	protected function prepareExecute()
	{
		parent::prepareExecute();
	}

	/**
	 * prepareUserState
	 *
	 * @param   ModelRepository $model
	 *
	 * @return  void
	 */
	protected function prepareUserState(ModelRepository $model)
	{
		parent::prepareUserState($model);
	}

	/**
	 * postExecute
	 *
	 * @param mixed $result
	 *
	 * @return  mixed
	 */
	protected function postExecute($result = null)
	{
		return parent::postExecute($result);
	}
}
