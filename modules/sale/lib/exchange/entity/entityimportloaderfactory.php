<?php
namespace Bitrix\Sale\Exchange\Entity;

use Bitrix\Main;
use Bitrix\Sale\Exchange\EntityType;

/**
 * Class EntityImportLoaderFactory
 * @package Bitrix\Sale\Exchange\Entity
 * @internal
 */
class EntityImportLoaderFactory
{
    /** Create new entity import loader by specified entity type ID.
     * @static
     * @param int $entityTypeID Entity type ID.
     * @return EntityImportLoader
     * @throws Main\ArgumentException
     * @throws Main\NotSupportedException
     */
    public static function create($entityTypeID)
    {
        if(!is_int($entityTypeID))
        {
            $entityTypeID = (int)$entityTypeID;
        }

        if(!EntityType::IsDefined($entityTypeID))
        {
            throw new Main\ArgumentException('Is not defined', 'entityTypeID');
        }

        if($entityTypeID === EntityType::ORDER)
        {
            return new OrderImportLoader();
        }
        elseif($entityTypeID === EntityType::SHIPMENT)
        {
            return new ShipmentImportLoader();
        }
        elseif($entityTypeID === EntityType::PAYMENT_CASH ||
            $entityTypeID === EntityType::PAYMENT_CASH_LESS ||
            $entityTypeID === EntityType::PAYMENT_CARD_TRANSACTION)
        {
            return new PaymentImportLoader();
        }
        elseif($entityTypeID == EntityType::USER_PROFILE)
        {
            return new UserProfileImportLoader();
        }
        else
        {
            throw new Main\NotSupportedException("Entity type: '".EntityType::ResolveName($entityTypeID)."' is not supported in current context");
        }
    }
}