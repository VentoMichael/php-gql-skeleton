<?php

namespace Vertuoza\Usecases\Collaborators;

class CollaboratorUseCases
{
  public function __construct(
    public readonly CollaboratorById $collaboratorById,
    public readonly CollaboratorsFindMany $collaboratorsFindMany
  ) {
  }
}
