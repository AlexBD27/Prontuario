<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;


class SystemRepository
{

    public function truncateAll()
    {
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            $tables = [
                'area_group_types',
                'areas',
                'attachments',
                'cache',
                'cache_locks',
                'doc_type_giro_type',
                'doc_types',
                'entities',
                'failed_jobs',
                'giro_types',
                'group_types',
                'groups',
                'job_batches',
                'jobs',
                'migrations',
                'password_reset_tokens',
                'prontuario_initial_numbers',
                'prontuarios',
                'public_types',
                'subgroups',
                'workers',
            ];

            foreach ($tables as $table) {
                DB::statement("TRUNCATE TABLE `" . $table . "`");
            }

            DB::table('users')->where('role', '!=', 'ADMIN')->delete();

            $maxUserId = DB::table('users')->max('id');
            if (is_null($maxUserId)) {
                DB::statement("ALTER TABLE users AUTO_INCREMENT = 1");
            }

            DB::statement('SET FOREIGN_KEY_CHECKS=1');

        } catch (\Throwable $e) {
            \Log::error('Error al reiniciar: ' . $e->getMessage());
            throw $e;
        }
    }

}