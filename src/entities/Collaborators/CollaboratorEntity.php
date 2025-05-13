<?php

namespace Vertuoza\Entities\Collaborators;

class CollaboratorEntity
{
  public function __construct(
    public readonly string $id,
    public readonly string $name,
    public readonly string $firstName,
    public readonly ?bool $isSystem = false
  ) {
  }
}
