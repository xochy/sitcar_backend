<?php

namespace App\JsonApi\Roles;

use Neomerx\JsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'roles';

    /**
     * @param \App\Models\Role $resource
     *      the domain record being serialized.
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\Models\Role $resource
     *      the domain record being serialized.
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'name'         => $resource->name,
            'display_name' => $resource->display_name,
            'created_at'   => $resource->created_at->format('Y-m-d H:i:s'),
            'updated_at'   => $resource->updated_at->format('Y-m-d H:i:s'),
        ];
    }

    public function getRelationships($role, $isPrimary, array $includeRelationships)
    {
        return [
            'users' => [
                self::SHOW_RELATED => true,
                self::SHOW_SELF => true,
                self::SHOW_DATA => isset($includeRelationships['users']),
                self::DATA => function () use ($role) {
                    return $role->users;
                }
            ],
        ];
    }
}
