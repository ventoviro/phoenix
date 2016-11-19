<?php
/**
 * Part of Phoenix project.
 *
 * @copyright  Copyright (C) 2016 LYRASOFT. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Phoenix\Controller;

use Phoenix\Model\CrudModel;
use Phoenix\Model\CrudRepositoryInterface;
use Windwalker\Core\Frontend\Bootstrap;
use Windwalker\Data\Data;
use Windwalker\Data\DataInterface;
use Windwalker\DataMapper\Entity\Entity;
use Windwalker\Http\Response\HtmlResponse;
use Windwalker\Http\Response\RedirectResponse;
use Windwalker\Uri\Uri;

/**
 * The AbstractAdminController class.
 *
 * @method  CrudModel  getModel($name = null, $source = null, $forceNew = false)
 *
 * @since  1.0
 */
abstract class AbstractPostController extends AbstractPhoenixController
{
	/**
	 * Property model.
	 *
	 * @var  CrudModel
	 */
	protected $model;

	/**
	 * Property data.
	 *
	 * @var  array
	 */
	protected $data = [];

	/**
	 * Property task.
	 *
	 * @var  string
	 */
	protected $task;

	/**
	 * Property entity.
	 *
	 * @var  DataInterface|Entity
	 */
	protected $dataObject;

	/**
	 * Property keyName.
	 *
	 * @var  string
	 */
	protected $keyName = null;

	/**
	 * Property allowRedirectQuery.
	 *
	 * @var  array
	 */
	protected $redirectQueryFields = array(
		'return'
	);

	/**
	 * init
	 *
	 * @return  void
	 */
	protected function init()
	{
		parent::init();
	}

	/**
	 * prepareExecute
	 *
	 * @return  void
	 *
	 * @throws \LogicException
	 * @throws \DomainException
	 */
	protected function prepareExecute()
	{
		parent::prepareExecute();

		$this->model      = $this->getModel();
		$this->dataObject = $this->getDataObject();
		$this->task       = $this->input->get('task');

		// Determine model
		if (!$this->model instanceof CrudRepositoryInterface)
		{
			throw new \DomainException(sprintf(
				'%s model should be instance of %s, class: %s',
				$this->model->getName(),
				CrudRepositoryInterface::class, get_class($this->model)
			));
		}

		// Determine the name of the primary key for the data.
		if (empty($this->keyName))
		{
			$this->keyName = $this->model->getKeyName(false) ? : 'id';
		}

		$this->checkAccess($this->dataObject);
	}

	/**
	 * processSuccess
	 *
	 * @param mixed  $result
	 *
	 * @return mixed
	 */
	public function processSuccess($result)
	{
		$this->removeUserState($this->getContext('edit.data'));

		$entity = $this->getDataObject();

		$this->addMessage($this->getSuccessMessage($entity), Bootstrap::MSG_SUCCESS);

		$this->setRedirect($this->getSuccessRedirect($entity));

		if (!$this->response instanceof HtmlResponse && !$this->response instanceof RedirectResponse)
		{
			return $entity->dump(true);
		}

		return $result;
	}

	/**
	 * Process failure.
	 *
	 * @param \Exception $e
	 *
	 * @return bool
	 */
	public function processFailure(\Exception $e = null)
	{
		$this->setUserState($this->getContext('edit.data'), $this->data);

		$this->addMessage($e->getMessage(), Bootstrap::MSG_WARNING);

		$this->setRedirect($this->getFailRedirect($this->getDataObject()));

		return false;
	}

	/**
	 * getSuccessMessage
	 *
	 * @param Data $data
	 *
	 * @return  string
	 */
	public function getSuccessMessage($data = null)
	{
		return '';
	}

	/**
	 * getSuccessRedirect
	 *
	 * @param  DataInterface|Entity $data
	 *
	 * @return  string
	 */
	protected function getSuccessRedirect(DataInterface $data = null)
	{
		$uri = new Uri($this->app->uri->full);

		foreach ($this->getRedirectQuery() as $field => $value)
		{
			$uri->setVar($field, $value);
		}

		return $uri->toString();
	}

	/**
	 * getFailRedirect
	 *
	 * @param  DataInterface $data
	 *
	 * @return  string
	 */
	protected function getFailRedirect(DataInterface $data = null)
	{
		return $this->getSuccessRedirect($data);
	}

	/**
	 * getRedirectQuery
	 *
	 * @param array $query
	 *
	 * @return  array
	 */
	protected function getRedirectQuery($query = array())
	{
		foreach ((array) $this->redirectQueryFields as $field)
		{
			$query[$field] = $this->input->getString($field);
		}

		return $query;
	}

	/**
	 * Method to get property Data
	 *
	 * @return  array
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * Method to set property data
	 *
	 * @param   array $data
	 *
	 * @return  static  Return self to support chaining.
	 */
	public function setData($data)
	{
		$this->data = $data;

		return $this;
	}

	/**
	 * Method to get property Entity
	 *
	 * @return  DataInterface|Entity
	 */
	public function getDataObject()
	{
		if (!$this->dataObject)
		{
			return $this->dataObject = new Data;
		}

		return $this->dataObject;
	}

	/**
	 * Method to set property entity
	 *
	 * @param   DataInterface|Entity $dataObject
	 *
	 * @return  static  Return self to support chaining.
	 */
	public function setDataObject(DataInterface $dataObject)
	{
		$this->dataObject = $dataObject;

		return $this;
	}
}
