<?php

namespace Vertuoza\Usecases\Collaborators;

use Vertuoza\Repositories\Collaborators\CollaboratorRepository;

class CollaboratorsFindMany
{
    public function __construct(private CollaboratorRepository $repository)
    {
    }

    public function handle($context)
    {
        return $this->repository->findMany(null);
    }
}