<?php
/**
 * Part of phoenix project.
 *
 * @copyright  Copyright (C) 2017 LYRASOFT.
 * @license    LGPL-2.0-or-later
 */

namespace Phoenix\Form;

use Windwalker\Core\Form\AbstractFieldDefinition;
use Windwalker\Form\Form;

/**
 * The InlineDefinition class.
 *
 * @since  1.4.2
 */
class InlineDefinition extends AbstractFieldDefinition
{
    use PhoenixFieldTrait;

    /**
     * Define the form fields.
     *
     * @param Form $form The Windwalker form object.
     *
     * @return  void
     */
    protected function doDefine(Form $form)
    {
        //
    }
}
