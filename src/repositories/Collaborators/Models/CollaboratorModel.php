<?php

namespace Vertuoza\Repositories\Collaborators\Models;

use stdClass;

class CollaboratorModel
{
  public function __construct(
    public readonly string $id,
    public readonly string $name,
    public readonly string $first_name,
    public readonly ?bool $is_system,
    public readonly ?string $tenant_id,
    public readonly ?string $deleted_at
  ) {
  }

  public static function fromStdclass(stdClass $data): self
  {
    return new self(
      $data->id,
      $data->name,
      $data->first_name,
      $data->is_system ?? false,
      $data->tenant_id ?? null,
      $data->deleted_at ?? null
    );
  }

  public static function getTableName(): string
  {
    return 'collaborators';
  }

  public static function getPkColumnName(): string
  {
    return 'id';
  }

  public static function getTenantColumnName(): string
  {
    return 'tenant_id';
  }
}
