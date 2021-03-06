<?php
/**
 * Part of Phoenix project.
 *
 * @copyright  Copyright (C) 2016 LYRASOFT. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Phoenix\Repository;

use Windwalker\Core\Repository\DatabaseRepository;
use Windwalker\Data\DataInterface;
use Windwalker\Event\Event;
use Windwalker\Ioc;
use Windwalker\Record\Exception\NoResultException;
use Windwalker\Record\Record;

/**
 * The AbstractFormModel class.
 *
 * @since  1.0
 */
class ItemRepository extends DatabaseRepository
{
    /**
     * getItem
     *
     * @param   mixed $conditions
     *
     * @return  Record
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function getItem($conditions = null)
    {
        $state = $this->state;

        $conditions = $conditions ?: $state['load.conditions'];

        return $this->once('item.' . json_encode($conditions), function () use ($conditions, $state) {
            if (!$conditions) {
                return $this->getRecord()->reset(false);
            }

            $item = $this->registerRecordEvents($this->getRecord());

            $this->triggerEvent('BeforeLoad', [
                'conditions' => $conditions,
                'item' => $item
            ]);

            $this->prepareGetItem($conditions);

            try {
                $item->load($conditions);

                $this->postGetItem($item);
            } catch (NoResultException $e) {
                return $item->reset(false);
            }

            $this->triggerEvent('AfterLoad', [
                'conditions' => $conditions,
                'item' => $item
            ]);

            return $item;
        });
    }

    /**
     * prepareGetItem
     *
     * @param array $conditions
     *
     * @return  void
     *
     * @since  1.6
     */
    protected function prepareGetItem($conditions)
    {
        //
    }

    /**
     * postGetItem
     *
     * @param DataInterface $item
     *
     * @return  void
     */
    protected function postGetItem(DataInterface $item)
    {
        //
    }

    /**
     * onBeforeLoad
     *
     * @param Event $event
     *
     * @return  void
     *
     * @since  1.6
     */
    protected function onBeforeLoad(Event $event)
    {
        //
    }

    /**
     * onAfterLoad
     *
     * @param Event $event
     *
     * @return  void
     *
     * @since  1.6
     */
    public function onAfterLoad(Event $event)
    {
        //
    }

    /**
     * triggerCrudEvent
     *
     * @param string $action
     * @param array  $params
     *
     * @return  \Windwalker\Event\EventInterface
     *
     * @since  1.6
     */
    protected function triggerEvent($action, array $params = [])
    {
        $dispatcher = Ioc::getDispatcher();

        $params['model'] = $this;
        $params['repository'] = $this;

        $selfEvent = 'on' . $action;

        if (method_exists($this, $selfEvent)) {
            $this->$selfEvent(new Event($selfEvent, $params));
        }

        $dispatcher->triggerEvent('onModel' . $action, $params);

        return $dispatcher->triggerEvent('onRepository' . $action, $params);
    }

    /**
     * registerRecordEvents
     *
     * @param Record $record
     *
     * @return  Record
     *
     * @since  1.8.13
     */
    public function registerRecordEvents(Record $record): Record
    {
//        $record->getDispatcher()->listen(
//            'onBeforeLoad',
//            function (Event $event) use ($record) {
//                $this->prepareGetItem($event['conditions']);
//            }
//        );
//
//        $record->getDispatcher()->listen(
//            'onAfterLoad',
//            function (Event $event) use ($record) {
//                $this->postGetItem($record);
//            }
//        );

        return $record;
    }
}
