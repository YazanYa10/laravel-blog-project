<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Spatie\Activitylog\Models\Activity;

class PostLogsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Activity::where('subject_type', \App\Models\Post::class)->get();
    }
    // الأسطر الأولى
    public function headings(): array
    {
        return [
            'User',
            'Action',
            'Old Title',
            'New Title',
            'Old Content',
            'New Content',
            'Date',
        ];
    }

    public function map($activity): array
    {
        $properties = $activity->properties;

        return [
            optional($activity->causer)->name ?? 'System', // User
            $activity->description,                        // Description
            $properties['old']['title'] ?? '',              // Old Title
            $properties['new']['title'] ?? '',              // New Title
            $properties['old']['content'] ?? '',            // Old Content
            $properties['new']['content'] ?? '',            // New Content
            $activity->created_at->format('Y-m-d H:i:s'),   // Date
        ];
    }
}
