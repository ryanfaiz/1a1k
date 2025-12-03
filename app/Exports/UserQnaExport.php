<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Exportable;

class UserQnaExport implements WithMultipleSheets
{
    use Exportable;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function sheets(): array
    {
        return [
            'Questions' => new QuestionsSheet($this->user),
            'Answers' => new AnswersSheet($this->user),
        ];
    }
}

class QuestionsSheet implements FromCollection, WithHeadings
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function collection()
    {
        return $this->user->questions()
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($q) {
                return [
                    $q->id,
                    $q->title,
                    $q->content,
                    $q->created_at->format('Y-m-d H:i:s'),
                ];
            });
    }

    public function headings(): array
    {
        return ['ID', 'Title', 'Content', 'Created At'];
    }
}

class AnswersSheet implements FromCollection, WithHeadings
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function collection()
    {
        return $this->user->answers()
            ->with('question')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($a) {
                return [
                    $a->id,
                    $a->question ? $a->question->title : '',
                    $a->content,
                    $a->created_at->format('Y-m-d H:i:s'),
                ];
            });
    }

    public function headings(): array
    {
        return ['ID', 'For Question', 'Content', 'Created At'];
    }
}
