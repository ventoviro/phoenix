<?php
/**
 * Part of phoenix project.
 *
 * @copyright  Copyright (C) 2017 LYRASOFT.
 * @license    LGPL-2.0-or-later
 */

namespace Phoenix\Form\Filter;

use Windwalker\Core\DateTime\Chronos;

/**
 * The ServerTZFilter class.
 *
 * @since  1.8.13
 */
class ServerTZFilter extends TimezoneFilter
{
    /**
     * TimezoneFilter constructor.
     *
     * @param string $from
     */
    public function __construct($from = null)
    {
        $to = Chronos::getServerDefaultTimezone();

        parent::__construct($from, $to);
    }
}
