<?php
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();
$collection->add('add', new Route('/weatherconditionvalue/add', array(
    '_controller' => 'TransportBundle:WeatherConditionValue:add',
)));

$collection->add('update', new Route('/weather/conditionvalue/update', array(
    '_controller' => 'TransportBundle:WeatherConditionValue:update',
)));

$collection->add('delete', new Route('/weatherconditionvalue/delete', array(
    '_controller' => 'TransportBundle:WeatherConditionValue:delete',
)));

return $collection;