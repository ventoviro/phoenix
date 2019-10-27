<?php
/**
 * Part of Phoenix project.
 *
 * @copyright  Copyright (C) 2016 LYRASOFT. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Phoenix\Listener;

use Phoenix\Minify\CssMinify;
use Windwalker\Event\Event;

/**
 * The CssMinifyListener class.
 *
 * @since  1.0
 */
class CssMinifyListener
{
    /**
     * onPhoenixRenderScripts
     *
     * @param Event $event
     *
     * @return  void
     */
    public function onAssetRenderStyles(Event $event)
    {
        if (!class_exists(CssMinify::class)) {
            throw new \DomainException('Please install asika/minify ~1.0 first');
        }

        $minify = new CssMinify($event['asset']);

        $minify->compress();
    }
}
