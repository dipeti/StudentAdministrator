<?php


namespace AppBundle;


final class Events
{
    /**
     * @Event("Symfony\Component\EventDispatcher\GenericEvent")
     */
    const DATA_MODIFIED = 'data.modified';
}