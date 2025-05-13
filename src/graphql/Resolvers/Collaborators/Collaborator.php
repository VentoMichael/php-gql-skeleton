<?php

namespace Vertuoza\Api\Graphql\Resolvers\Collaborators;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\NonNull;
use Vertuoza\Api\Graphql\Types;

class Collaborator extends ObjectType
{
  public function __construct()
  {
    $config = [
      'fields' => [
        'id' => [
          'type' => Types::nonNull(Types::id()),
          'description' => 'The unique identifier for the collaborator',
        ],
        'name' => [
          'type' => Types::nonNull(Types::string()),
          'description' => 'The name of the collaborator',
        ],
        'firstName' => [
          'type' => Types::nonNull(Types::string()),
          'description' => 'The first name of the collaborator',
        ],
        'isSystem' => [
          'type' => Types::boolean(),
          'description' => 'Whether the collaborator is a system collaborator',
        ],
      ],
    ];

    parent::__construct($config);
  }
}
