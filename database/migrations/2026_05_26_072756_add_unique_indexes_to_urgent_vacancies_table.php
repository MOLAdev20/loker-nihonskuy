<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const UNIQUE_JOB_ID_INDEX = 'urgent_vacancies_job_id_unique';
    private const UNIQUE_ORDER_INDEX = 'urgent_vacancies_order_unique';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('urgent_vacancies')) {
            return;
        }

        $this->removeDuplicateVacancies();
        $this->normalizeOrder();

        Schema::table('urgent_vacancies', function (Blueprint $table) {
            $table->unique('job_id', self::UNIQUE_JOB_ID_INDEX);
            $table->unique('order', self::UNIQUE_ORDER_INDEX);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('urgent_vacancies')) {
            return;
        }

        Schema::table('urgent_vacancies', function (Blueprint $table) {
            $table->dropUnique(self::UNIQUE_JOB_ID_INDEX);
            $table->dropUnique(self::UNIQUE_ORDER_INDEX);
        });
    }

    private function removeDuplicateVacancies(): void
    {
        $rowsToDelete = DB::table('urgent_vacancies')
            ->select('urgent_vacancies.id')
            ->joinSub(
                DB::table('urgent_vacancies')
                    ->selectRaw('MIN(id) as keep_id, job_id')
                    ->groupBy('job_id')
                    ->havingRaw('COUNT(*) > 1'),
                'duplicates',
                'urgent_vacancies.job_id',
                '=',
                'duplicates.job_id'
            )
            ->whereColumn('urgent_vacancies.id', '!=', 'duplicates.keep_id')
            ->pluck('urgent_vacancies.id');

        if ($rowsToDelete->isEmpty()) {
            return;
        }

        DB::table('urgent_vacancies')
            ->whereIn('id', $rowsToDelete->all())
            ->delete();
    }

    private function normalizeOrder(): void
    {
        $urgentVacancyIds = DB::table('urgent_vacancies')
            ->orderBy('order')
            ->orderBy('id')
            ->pluck('id');

        foreach ($urgentVacancyIds as $index => $id) {
            DB::table('urgent_vacancies')
                ->where('id', $id)
                ->update(['order' => $index + 1]);
        }
    }
};
