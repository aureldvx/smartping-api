<?php

namespace SmartpingApi\Service;

use SmartpingApi\Contract\UseCase\OrganizationInterface;
use SmartpingApi\Enum\OrganizationType;
use SmartpingApi\Model\Organization\Organization;

class OrganizationAPI extends SmartpingCore implements OrganizationInterface
{
    /**
     * @inheritDoc
     */
    public static function findOrganizationsByType(OrganizationType $orgType) : array
    {
        if (empty(SmartpingCore::$organizations)) {
            SmartpingCore::populateOrganizations();
        }

        $results = array_filter(SmartpingCore::$organizations, fn ($org) => $org['type'] === $orgType->value);
        $results = array_values($results);

        return array_map(function($org) {
            return new Organization(
                id: $org['id'],
                name: $org['name'],
                code: $org['code'],
                parentId: $org['parentId']
            );
        }, $results);
    }


    /**
     * @inheritDoc
     */
    public static function getOrganization(int $organizationId) : ?Organization
    {
        if (empty(SmartpingCore::$organizations)) {
            SmartpingCore::populateOrganizations();
        }

        return SmartpingCore::getOrganizationInStore($organizationId);
    }


    /**
     * @inheritDoc
     */
    public static function getOrganizationChildren(int $organizationId) : array
    {
        if (empty(SmartpingCore::$organizations)) {
            SmartpingCore::populateOrganizations();
        }

        $results = array_filter(SmartpingCore::$organizations, fn ($org) => (int) $org['parentId'] === $organizationId);
        $results = array_values($results);
        return array_map(function($org) {
            return new Organization(
                id: $org['id'],
                name: $org['name'],
                code: $org['code'],
                parentId: $org['parentId']
            );
        }, $results);
    }
}
