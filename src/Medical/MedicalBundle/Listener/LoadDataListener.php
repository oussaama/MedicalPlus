<?php
namespace Medical\MedicalBundle\Listener;

use AncaRebeca\FullCalendarBundle\Event\CalendarEvent;
use Medical\MedicalBundle\Entity\CalendarEvent as Event;

class LoadDataListener
{
    /**
     * @param CalendarEvent $calendarEvent
     *
     * @return EventInterface[]
     */
    public function loadData(CalendarEvent $calendarEvent)
    {
         $startDate = $calendarEvent->getStart();
         $endDate = $calendarEvent->getEnd();
         $filters = $calendarEvent->getFilters();

         //You may want do a custom query to populate the events

         $calendarEvent->addEvent(new Event('Event Title 1', new \DateTime()));
         $calendarEvent->addEvent(new Event('Event Title 2', new \DateTime()));
    }
}
