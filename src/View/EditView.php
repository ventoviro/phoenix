<?php
/**
 * Part of Phoenix project.
 *
 * @copyright  Copyright (C) 2016 LYRASOFT. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Phoenix\View;

use Phoenix\Repository\FormAwareRepositoryInterface;
use Windwalker\Form\Form;

/**
 * The EditView class.
 *
 * @since  1.0
 */
class EditView extends ItemView
{
    /**
     * Property formDefinition.
     *
     * @var  string
     */
    protected $formDefinition = 'edit';

    /**
     * Property formControl.
     *
     * @var  string
     */
    protected $formControl = 'item';

    /**
     * Property formLoadData.
     *
     * @var  boolean
     */
    protected $formLoadData = true;

    /**
     * setTitle
     *
     * @param string $title
     *
     * @return  static
     */
    public function setTitle($title = null)
    {
        $title = $title ?: __('phoenix.title.edit', __($this->langPrefix . $this->getName() . '.title'));

        return parent::setTitle($title);
    }

    /**
     * prepareRender
     *
     * @param \Windwalker\Data\Data $data
     *
     * @return  void
     * @throws \UnexpectedValueException
     */
    protected function prepareData($data)
    {
        parent::prepareData($data);

        $data->form = $data->form ?: $this->getForm();
    }

    /**
     * getForm
     *
     * @return  Form
     *
     * @since  1.8
     */
    protected function getForm()
    {
        $repository = $this->repository->getRepository();

        if (!$repository instanceof FormAwareRepositoryInterface) {
            throw new \UnexpectedValueException(
                'You must use a Repository implemented ' . FormAwareRepositoryInterface::class . ' in EditView'
            );
        }

        return $repository->getForm($this->formDefinition, $this->formControl, $this->formLoadData);
    }
}
