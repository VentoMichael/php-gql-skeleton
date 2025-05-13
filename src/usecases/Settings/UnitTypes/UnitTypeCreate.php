<?php

namespace Vertuoza\Usecases\Settings\UnitTypes;

use Vertuoza\Api\Graphql\Context\RequestContext;
use Vertuoza\Repositories\Settings\UnitTypes\UnitTypeMutationData;
use Vertuoza\Repositories\Settings\UnitTypes\UnitTypeRepository;

class UnitTypeCreate
{
  public function __construct(
    private UnitTypeRepository $unitTypeRepository
  ) {
  }

  public function handle(string $name, RequestContext $context)
  {
    if (empty($name)) {
      $result = new \stdClass();
      $result->message = "Unit type name cannot be empty.";
      $result->id = null;
      $result->isSystem = false;
      $result->label = null;
      $result->tenantId = null;
      return \React\Promise\resolve($result);
    }

    $tenantId = $context->userContext->getTenantId();
    $data = new UnitTypeMutationData();
    $data->name = $name;
    $id = $this->unitTypeRepository->create($data, $tenantId);
    $result = new \stdClass();
    $result->id = $id;
    $result->label = $name;
    $result->tenantId = $tenantId;
    $result->isSystem = false;
    $result->message = "Unit type '$name' created successfully.";
    return $result;
  }
}