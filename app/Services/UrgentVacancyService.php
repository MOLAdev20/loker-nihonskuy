<?php

namespace App\Services;

use App\Models\UrgentVacancy;
use App\Models\Vacancy;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class UrgentVacancyService
{
    /**
     * @param array<int, string> $tags
     */
    public function syncFromTags(Vacancy $vacancy, array $tags): void
    {
        if (in_array('urgent', $tags, true)) {
            $this->add($vacancy);
            return;
        }

        $this->removeByVacancy($vacancy);
    }

    public function add(Vacancy $vacancy): UrgentVacancy
    {
        for ($attempt = 1; $attempt <= 3; $attempt++) {
            try {
                return $this->addOnce($vacancy);
            } catch (QueryException $exception) {
                if ($attempt === 3) {
                    throw $exception;
                }
            }
        }

        throw new \RuntimeException('Failed to add urgent vacancy.');
    }

    private function addOnce(Vacancy $vacancy): UrgentVacancy
    {
        return DB::transaction(function () use ($vacancy) {
            $existingUrgentVacancy = UrgentVacancy::query()
                ->where('job_id', $vacancy->id)
                ->lockForUpdate()
                ->first();

            if ($existingUrgentVacancy) {
                $this->addUrgentTag($vacancy);
                return $existingUrgentVacancy;
            }

            $lastOrder = (int) UrgentVacancy::query()
                ->lockForUpdate()
                ->max('order');

            $urgentVacancy = UrgentVacancy::create([
                'job_id' => $vacancy->id,
                'order' => $lastOrder + 1,
            ]);

            $this->addUrgentTag($vacancy);
            $this->normalizeOrder();

            return $urgentVacancy->refresh();
        });
    }

    public function remove(UrgentVacancy $urgentVacancy): void
    {
        DB::transaction(function () use ($urgentVacancy) {
            $urgentVacancy = UrgentVacancy::query()
                ->with('vacancy')
                ->whereKey($urgentVacancy->id)
                ->lockForUpdate()
                ->first();

            if (! $urgentVacancy) {
                return;
            }

            $vacancy = $urgentVacancy->vacancy;

            $urgentVacancy->delete();

            if ($vacancy) {
                $this->removeUrgentTag($vacancy);
            }

            $this->normalizeOrder();
        });
    }

    public function removeByVacancy(Vacancy $vacancy): void
    {
        DB::transaction(function () use ($vacancy) {
            $urgentVacancy = UrgentVacancy::query()
                ->where('job_id', $vacancy->id)
                ->lockForUpdate()
                ->first();

            if ($urgentVacancy) {
                $urgentVacancy->delete();
            }

            $this->removeUrgentTag($vacancy);
            $this->normalizeOrder();
        });
    }

    /**
     * @param array<int, int|string> $orderedIds
     */
    public function reorder(array $orderedIds): void
    {
        $orderedIds = $this->normalizeIds($orderedIds);

        DB::transaction(function () use ($orderedIds) {
            $existingIds = UrgentVacancy::query()
                ->lockForUpdate()
                ->pluck('id')
                ->map(fn ($id) => (int) $id)
                ->all();

            $sortedOrderedIds = $orderedIds;
            sort($sortedOrderedIds);
            sort($existingIds);

            if ($sortedOrderedIds !== $existingIds) {
                throw new \InvalidArgumentException('Invalid urgent vacancy order payload.');
            }

            foreach ($orderedIds as $index => $urgentVacancyId) {
                UrgentVacancy::query()
                    ->where('id', $urgentVacancyId)
                    ->update(['order' => -($index + 1)]);
            }

            foreach ($orderedIds as $index => $urgentVacancyId) {
                UrgentVacancy::query()
                    ->where('id', $urgentVacancyId)
                    ->update(['order' => $index + 1]);
            }
        });
    }

    public function normalizeOrder(): void
    {
        /** @var Collection<int, UrgentVacancy> $urgentVacancies */
        $urgentVacancies = UrgentVacancy::query()
            ->lockForUpdate()
            ->orderBy('order')
            ->orderBy('id')
            ->get();

        foreach ($urgentVacancies as $index => $urgentVacancy) {
            $expectedOrder = $index + 1;

            if ((int) $urgentVacancy->order === $expectedOrder) {
                continue;
            }

            $urgentVacancy->update([
                'order' => $expectedOrder,
            ]);
        }
    }

    /**
     * @param array<int, int|string> $ids
     * @return array<int, int>
     */
    private function normalizeIds(array $ids): array
    {
        return array_values(array_map('intval', $ids));
    }

    private function addUrgentTag(Vacancy $vacancy): void
    {
        $tags = $this->parseTags($vacancy->tags);

        if (! in_array('urgent', $tags, true)) {
            $tags[] = 'urgent';
        }

        $vacancy->forceFill([
            'tags' => $this->formatTags($tags),
        ])->save();
    }

    private function removeUrgentTag(Vacancy $vacancy): void
    {
        $tags = array_values(array_filter(
            $this->parseTags($vacancy->tags),
            fn (string $tag) => $tag !== 'urgent'
        ));

        $vacancy->forceFill([
            'tags' => $this->formatTags($tags),
        ])->save();
    }

    /**
     * @return array<int, string>
     */
    private function parseTags(?string $rawTags): array
    {
        if (! $rawTags) {
            return [];
        }

        return array_values(array_unique(array_filter(
            explode('|', $rawTags),
            fn ($tag) => is_string($tag) && $tag !== ''
        )));
    }

    /**
     * @param array<int, string> $tags
     */
    private function formatTags(array $tags): ?string
    {
        return count($tags) ? implode('|', array_values(array_unique($tags))) : null;
    }
}
