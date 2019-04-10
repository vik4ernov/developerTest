<?php

use \Bitrix\Main\Application;
use AB\Iblock\Element;
use Bitrix\Main\Loader;
use \Bitrix\Main\Data\Cache;

class VikIBlockElement
{
    const CACHE_TIME = 7200;

    public function GetList($order = [], $filter = [], $select = [], $cacheTime = 0)
    {
        $arResult = array();
        if ($cacheTime <= 0) $cacheTime = self::CACHE_TIME;
        $cacheId = serialize([$order, $filter, $select]);

        // получаем экземпляр класса
        $cache = Cache::createInstance();
        // проверяем кеш и задаём настройки
        if ($cache->initCache($cacheTime, $cacheId)) {
            $arResult = $cache->getVars();
        } else if ($cache->startDataCache()) {
            Loader::includeModule("iblock");

            $dbItems = \Bitrix\Iblock\ElementTable::getList(array(
                'order' => $order,
                'filter' => $filter,
                'select' => $select
            ));
            while ($arItem = $dbItems->fetch()) {
                $arResult[] = $arItem;
            }
            $cache->endDataCache($arResult); // записываем в кеш
        }

        return $arResult;
    }
}