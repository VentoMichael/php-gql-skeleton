<?php

namespace Vertuoza\Api\Graphql\Resolvers\Settings\UnitTypes;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\NonNull;
use Vertuoza\Api\Graphql\Context\RequestContext;
use Vertuoza\Api\Graphql\Types;
use Vertuoza\Repositories\Settings\UnitTypes\UnitTypeMutationData;
use Vertuoza\Entities\Settings\UnitTypeEntity;

class UnitTypeMutation
{
    public static function get()
    {
        return [
            'unitTypeCreate' => [
                'type' => Types::get(UnitType::class),
                'args' => [
                    'input' => Types::nonNull(new InputObjectType([
                        'name' => 'UnitTypeCreateInput',
                        'fields' => [
                            'name' => [
                                'type' => Types::nonNull(Types::string()),
                                'description' => 'The name of the unit type',
                            ],
                        ],
                    ])),
                ],
                'resolve' => static fn ($rootValue, $args, RequestContext $context)
                => $context->useCases->unitType
                    ->unitTypeCreate
                    ->handle($args['input']['name'], $context)
            ],
        ];
    }
}