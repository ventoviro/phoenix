<?php
/**
 * Part of {$package.name.cap$} project.
 *
 * @copyright  Copyright (C) 2016 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace {$package.namespace$}{$package.name.cap$}\View\{$controller.item.name.cap$};

use Phoenix\View\ItemView;
use Windwalker\Data\Data;

/**
 * The {$controller.item.name.cap$}HtmlView class.
 *
 * @since  1.0
 */
class {$controller.item.name.cap$}HtmlView extends ItemView
{
    /**
     * Property name.
     *
     * @var  string
     */
    protected $name = '{$controller.item.name.cap$}';

    /**
     * Property langPrefix.
     *
     * @var  string
     */
    protected $langPrefix = '{$project.name.lower$}.';

    /**
     * prepareData
     *
     * @param \Windwalker\Data\Data $data
     *
     * @return  void
     */
    protected function prepareData($data)
    {
        parent::prepareData($data);

        $this->prepareScripts($data);
        $this->prepareMetadata($data);
    }

    /**
     * prepareScripts
     *
     * @param Data $data
     *
     * @return  void
     */
    protected function prepareScripts(Data $data)
    {
    }

    /**
     * prepareMetadata
     *
     * @param Data $data
     *
     * @return  void
     */
    protected function prepareMetadata(Data $data)
    {
        $this->setTitle();
    }
}
