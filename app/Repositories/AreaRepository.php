<?php

namespace App\Repositories;

use App\Models\Area;

class AreaRepository extends BaseRepository
{
    public  function __construct(Area $area)
    {
        parent::__construct($area);
    }

    public function getWithRelations()
    {
        return $this->model->where('active', 1)
            ->with([
                'groupTypes' => function ($query) {
                    $query->where('group_types.active', 1)->with([
                        'areaGroupTypes' => function ($query) {
                            $query->where('area_group_types.active', 1)->with([
                                'groups' => function ($query) {
                                    $query->where('groups.active', 1)->with([
                                        'subGroups' => function ($query) {
                                            $query->where('subgroups.active', 1);
                                        }
                                    ]);
                                }
                            ]);
                        }
                    ]);
                }
            ])->get();
    }

    public function getAreasWithRelations(array $relations)
    {
        return $this->model->where('active', 1)->with($relations)->get();
    }

    public function getAreaRelations($areaId)
    {
        $area = $this->model->with([
            'groupTypes' => function ($query) use ($areaId) {
                $query->with([
                    'groups' => function ($query) use ($areaId) {
                        $query->whereHas('areaGroupType', function ($query) use ($areaId) {
                            $query->where('area_id', $areaId);
                        })->with('subGroups');
                    }
                ]);
            }
        ])
        ->where('id', $areaId)
        ->first();

        return $area;
    }






}