<?php
/**
 * Part of Phoenix project.
 *
 * @copyright  Copyright (C) 2016 LYRASOFT. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Phoenix\Controller\Batch;

use Phoenix\Repository\FormAwareRepositoryInterface;

/**
 * The BatchController class.
 *
 * @since  1.0.5
 */
abstract class AbstractUpdateController extends AbstractBatchController
{
    /**
     * Property action.
     *
     * @var  string
     */
    protected $action = 'move';

    /**
     * A hook before main process executing.
     *
     * @return  void
     * @throws \ReflectionException
     */
    protected function prepareExecute()
    {
        parent::prepareExecute();

        $this->data = $this->getUpdateData();
    }

    /**
     * getUpdateData
     *
     * @return  array
     * @throws \Exception
     */
    protected function getUpdateData()
    {
        $data = array_merge($this->input->getArray('batch'), (array) $this->data);

        return $this->filter($data);
    }

    /**
     * filter
     *
     * @param array $data
     *
     * @return  array
     *
     * @throws \Exception
     */
    protected function filter($data)
    {
        /** @var FormAwareRepositoryInterface $repository */
        $repository = $this->getRepository($this->getName());

        $form = $repository->getForm('grid');

        $form->bind(['batch' => $data]);

        $form->filter();

        $data = $form->getValues(null, 'batch');

        return $data['batch'];
    }
}
