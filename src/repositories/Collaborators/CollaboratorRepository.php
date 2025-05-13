<?php
namespace Vertuoza\Repositories\Collaborators;

use Overblog\DataLoader\DataLoader;
use Overblog\PromiseAdapter\PromiseAdapterInterface;
use React\Promise\Promise;
use Vertuoza\Repositories\Database\QueryBuilder;
use Vertuoza\Repositories\Collaborators\Models\CollaboratorMapper;
use Vertuoza\Repositories\Collaborators\Models\CollaboratorModel;
use function React\Async\async;

class CollaboratorRepository
{
    protected array $getbyIdsDL;
    private QueryBuilder $db;
    protected PromiseAdapterInterface $dataLoaderPromiseAdapter;

    public function __construct(
        private QueryBuilder $database,
        PromiseAdapterInterface $dataLoaderPromiseAdapter
    ) {
        $this->db = $database;
        $this->dataLoaderPromiseAdapter = $dataLoaderPromiseAdapter;
        $this->getbyIdsDL = [];
    }

    private function fetchByIds(?string $tenantId, array $ids)
    {
        return async(function () use ($tenantId, $ids) {
            $query = $this->getQueryBuilder();
            
            if ($tenantId !== null) {
                $query->where(function ($query) use ($tenantId) {
                    $query->where([CollaboratorModel::getTenantColumnName() => $tenantId])
                        ->orWhere(CollaboratorModel::getTenantColumnName(), null);
                });
            }
            
            $query->whereNull('deleted_at');
            $query->whereIn(CollaboratorModel::getPkColumnName(), $ids);

            $entities = $query->get()->mapWithKeys(function ($row) {
                $entity = CollaboratorMapper::modelToEntity(CollaboratorModel::fromStdclass($row));
                return [$entity->id => $entity];
            });

            // Map the IDs to the corresponding entities, preserving the order of IDs.
            return collect($ids)
                ->map(fn ($id) => $entities->get($id))
                ->toArray();
        })();
    }

    protected function getDataloader(?string $tenantId = 'global'): DataLoader
    {
        $cacheKey = $tenantId ?? 'global';
        
        if (!isset($this->getbyIdsDL[$cacheKey])) {
            $dl = new DataLoader(function (array $ids) use ($tenantId) {
                return $this->fetchByIds($tenantId, $ids);
            }, $this->dataLoaderPromiseAdapter);
            $this->getbyIdsDL[$cacheKey] = $dl;
        }

        return $this->getbyIdsDL[$cacheKey];
    }

    protected function getQueryBuilder()
    {
        return $this->db->getConnection()->table(CollaboratorModel::getTableName());
    }

    public function getByIds(array $ids, ?string $tenantId = null): Promise
    {
        return $this->getDataloader($tenantId)->loadMany($ids);
    }

    public function getById(string $id, ?string $tenantId = null): Promise
    {
        return $this->getDataloader($tenantId)->load($id);
    }

    public function findMany(?string $tenantId = null)
    {
        return async(
            function () use ($tenantId) {
                $query = $this->getQueryBuilder()
                    ->whereNull('deleted_at');
                
                if ($tenantId !== null) {
                    // Only filter by tenant if a tenantId is provided
                    $query->where(function ($query) use ($tenantId) {
                        $query->where(CollaboratorModel::getTenantColumnName(), '=', $tenantId)
                            ->orWhereNull(CollaboratorModel::getTenantColumnName());
                    });
                }
                
                return $query->get()
                    ->map(function ($row) {
                        return CollaboratorMapper::modelToEntity(CollaboratorModel::fromStdclass($row));
                    });
            }
        )();
    }
}