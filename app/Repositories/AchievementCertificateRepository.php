<?php

namespace App\Repositories;

use App\Models\AchievementCertificate;

class AchievementCertificateRepository
{
    public function existsForWorkOrder(int $workOrderId): bool
    {
        return AchievementCertificate::where('work_order_id', $workOrderId)->exists();
    }

    public function create(array $data): AchievementCertificate
    {
        return AchievementCertificate::create($data);
    }

    public function findWithWorkOrder(int $id): ?AchievementCertificate
    {
        return AchievementCertificate::with('workOrder')->find($id);
    }

    public function find(int $id): ?AchievementCertificate
    {
        return AchievementCertificate::find($id);
    }


    public function checkDuplicateWorkOrder(int $workOrderId, int $excludedId): bool
    {
        return AchievementCertificate::where('id', '<>', $excludedId)
            ->where('work_order_id', $workOrderId)
            ->exists();
    }


    public function update(AchievementCertificate $certificate, array $data): bool
    {
        return $certificate->fill($data)->save();
    }

    public function delete(AchievementCertificate $certificate): ?bool
    {
        return $certificate->delete();
    }
}