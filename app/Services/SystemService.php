<?php

namespace App\Services;

use App\Repositories\SystemRepository;
use Illuminate\Support\Facades\Storage;

class SystemService
{

    protected SystemRepository $systemRepository;

    public function __construct(SystemRepository $systemRepository)
    {
        $this->systemRepository = $systemRepository;
    }

    public function resetEverything()
    {
        $this->systemRepository->truncateAll();
        $this->deleteUploads();
    }

    protected function deleteUploads(): void
    {
        $disk = Storage::disk('public');
        $path = 'uploads';

        if ($disk->exists($path)) {
            $disk->deleteDirectory($path);
            $disk->makeDirectory($path);
        }
    }

}