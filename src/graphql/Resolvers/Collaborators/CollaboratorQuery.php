<?php

namespace Vertuoza\Api\Graphql\Resolvers\Collaborators;

use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\NonNull;
use Vertuoza\Api\Graphql\Context\RequestContext;
use Vertuoza\Api\Graphql\Types;

class CollaboratorQuery
{
    public static function get()
    {
        return [
            'collaboratorById' => [
                'type' => Types::get(Collaborator::class),
                'args' => [
                    'id' => Types::nonNull(Types::string()),
                ],
                'resolve' => static fn ($rootValue, $args, RequestContext $context)
                => $context->useCases->collaborator
                    ->collaboratorById
                    ->handle($args['id'], $context)
            ],
            'collaborators' => [
                'type' => Types::nonNull(new ListOfType(Types::get(Collaborator::class))),
                'resolve' => static fn ($rootValue, $args, RequestContext $context)
                => $context->useCases->collaborator
                    ->collaboratorsFindMany
                    ->handle($context)
            ],
        ];
    }
}
