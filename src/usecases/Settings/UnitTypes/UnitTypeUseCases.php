<?php

namespace Vertuoza\Usecases\Settings\UnitTypes;

use Vertuoza\Api\Graphql\Context\UserRequestContext;
use Vertuoza\Repositories\RepositoriesFactory;
use Vertuoza\Usecases\Settings\UnitTypes\UnitTypeCreate;

class UnitTypeUseCases
{
  public UnitTypeByIdUseCase $unitTypeById;
  public UnitTypesFindManyUseCase $unitTypesFindMany;
  public UnitTypeCreate $unitTypeCreate;

  public function __construct(UserRequestContext $userContext, RepositoriesFactory $repositories)
  {
    $this->unitTypeById = new UnitTypeByIdUseCase($repositories, $userContext);
    $this->unitTypesFindMany = new UnitTypesFindManyUseCase($repositories, $userContext);
    $this->unitTypeCreate = new UnitTypeCreate($repositories->unitType);
  }
}
