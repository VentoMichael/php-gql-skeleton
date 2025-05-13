<?php

namespace Vertuoza\Repositories\Collaborators\Models;

use Vertuoza\Entities\Collaborators\CollaboratorEntity;

class CollaboratorMapper
{
  public static function modelToEntity(CollaboratorModel $model): CollaboratorEntity
  {
    return new CollaboratorEntity(
      $model->id,
      $model->name,
      $model->first_name,
      $model->is_system
    );
  }
}
