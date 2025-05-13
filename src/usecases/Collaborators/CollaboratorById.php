<?php

namespace Vertuoza\Usecases\Collaborators;

use Vertuoza\Repositories\Collaborators\CollaboratorRepository;

class CollaboratorById
{
    public function __construct(private CollaboratorRepository $repository)
    {
    }

    public function handle($id, $context)
    {
        return $this->repository->getById($id, null);
    }
}