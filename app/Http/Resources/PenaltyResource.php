<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PenaltyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $lang = $request->header('lang', 'ar');

        $reasonField = $lang === 'en' ? 'reason_en' : 'reason_ar';

        return [
            'penalty_id' => $this->id,
            'reason_id' => $this->reason->id ?? null,
            'reason' => $this->reason->{$reasonField} ?? null,
            'employee_id' => $this->employee->id ?? null,
            'employee' => trim($this->employee->first_name . ' ' . $this->employee->last_name),
            'note' => $this->note,
        ];
    }
}
