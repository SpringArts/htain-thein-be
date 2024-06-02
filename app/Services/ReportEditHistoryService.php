<?php

// ReportEditHistoryService.php
namespace App\Services;

use App\Exceptions\CustomErrorException;
use Carbon\Carbon;
use App\Models\ReportEditHistory;

class ReportEditHistoryService
{
    public function editHistory(array $oldData, array $newData): void
    {
        try {
            $history = new ReportEditHistory();
            $history->editor_id = getAuthUserOrFail()->id;
            $history->report_id = $oldData['id'];

            $oldDataChangeFields = [];
            $newDataChangeFields = [];

            foreach ($newData as $key => $value) {
                if (isset($oldData[$key]) && $oldData[$key] !== $value) {
                    $oldDataChangeFields[$key] = $oldData[$key];
                    $newDataChangeFields[$key] = $value;
                }
            }
            if (!empty($newDataChangeFields)) {
                // Parse 'updated_at' timestamp using Carbon to make it human-readable in new data
                if (isset($newDataChangeFields['updated_at'])) {
                    $newDataChangeFields['updated_at'] = Carbon::parse($newDataChangeFields['updated_at'])->format('Y-d-M h:i A');
                }

                // Parse 'updated_at' timestamp using Carbon to make it human-readable in old data
                if (isset($oldDataChangeFields['updated_at'])) {
                    $oldDataChangeFields['updated_at'] = Carbon::parse($oldDataChangeFields['updated_at'])->format('Y-d-M h:i A');
                }

                $history->old_data = json_encode($oldDataChangeFields, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
                $history->new_data = json_encode($newDataChangeFields, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
                $history->save();
            }
        } catch (\Throwable $th) {
            throw new CustomErrorException($th->getMessage(), 500);
        }
    }
}
