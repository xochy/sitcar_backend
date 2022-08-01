<?php

namespace App\JsonApi\Cars;

use Neomerx\JsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'cars';

    /**
     * @param \App\Models\Car $resource
     *      the domain record being serialized.
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\Models\Car $resource
     *      the domain record being serialized.
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'name'       => $resource->name,
            'price'      => $resource->price,
            'trademark'  => $resource->trademark,
            'year'       => $resource->year,
            'sold'       => $resource->sold,
            'slug'       => $resource->slug,
            'created_at' => $resource->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $resource->updated_at->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * Get the car relationships
     *
     * @param \App\Models\Car $car
     * @param boolean $isPrimary
     * @param array $includeRelationships
     * @return array
     */
    public function getRelationships($car, $isPrimary, array $includeRelationships)
    {
        return [
            'images' => [
                self::SHOW_RELATED => true,
                self::SHOW_SELF => true,
                self::SHOW_DATA => isset($includeRelationships['images']),
                self::DATA => function () use ($car) {
                    return $car->images;
                }
            ],
        ];
    }
}
