<?php

namespace App\Exports;

use App\Models\User\UserEducationHistory;
use App\Models\User\UserProfile;
use App\Models\User\WorkExperience;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ResumeExport implements FromArray, WithColumnWidths, WithDrawings, WithEvents, WithTitle
{
    public function __construct(
        private readonly ?UserProfile $profile,
        private readonly Collection $educationHistories,
        private readonly Collection $workExperiences
    ) {}

    public function array(): array
    {
        return [];
    }

    public function title(): string
    {
        return 'Resume';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 3,
            'B' => 16,
            'C' => 16,
            'D' => 16,
            'E' => 16,
            'F' => 16,
            'G' => 16,
            'H' => 18,
            'I' => 18,
        ];
    }

    public function drawings(): array
    {
        $drawings = [];

        $logoPath = public_path('nihonskuy-cv.png');
        if (is_file($logoPath)) {
            $drawing = new Drawing();
            $drawing->setName('Nihonskuy CV');
            $drawing->setDescription('Nihonskuy CV');
            $drawing->setPath($logoPath);
            $drawing->setCoordinates('H3');
            $drawing->setHeight(48);
            $drawings[] = $drawing;
        }

        $photoPath = $this->resolveProfilePicturePath();
        if ($photoPath !== null) {
            $drawing = new Drawing();
            $drawing->setName('Profile Photo');
            $drawing->setDescription('Foto profile user');
            $drawing->setPath($photoPath);
            $drawing->setCoordinates('H5');
            $drawing->setOffsetX(10);
            $drawing->setOffsetY(10);
            $drawing->setHeight(150);
            $drawings[] = $drawing;
        }

        return $drawings;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $this->prepareSheet($sheet);
                $this->writeHeader($sheet);
                $this->writeProfileBlock($sheet);
                $this->writeEducationBlock($sheet);
                $this->writeWorkBlock($sheet);
            },
        ];
    }

    private function prepareSheet(Worksheet $sheet): void
    {
        $sheet->getParent()->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
        $sheet->getRowDimension(3)->setRowHeight(26);
        $sheet->getRowDimension(4)->setRowHeight(20);
        $sheet->getRowDimension(16)->setRowHeight(22);
        $sheet->getRowDimension(17)->setRowHeight(22);
    }

    private function writeHeader(Worksheet $sheet): void
    {
        $sheet->mergeCells('E3:F3');
        $sheet->setCellValue('E3', '履歴書');
        $sheet->getStyle('E3:F3')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('E3:F3')->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);

        $sheet->setCellValue('G4', 'Tanggal :');
        $sheet->getStyle('G4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        $sheet->mergeCells('H4:I4');
        $sheet->setCellValue('H4', now()->format('d/m/Y'));
        $sheet->getStyle('H4:I4')->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);
    }

    private function writeProfileBlock(Worksheet $sheet): void
    {
        $leftLabels = [
            'フリガナ',
            '氏名',
            '生年月日',
            '国籍',
            '現住所',
            'ヒジャブ*',
            '豚肉への許容度*',
            '入国日**',
            '在留カードの期限**',
            '日本語能力',
            '運転免許有無',
        ];

        $leftFields = [
            'furigana_name',
            'full_name',
            'birth_date',
            'nationality',
            'current_address',
            'is_wearing_hijab',
            'pork_tolerance',
            'entry_date',
            'visa_expiry_date',
            'jlpt_level',
            'has_driver_license',
        ];

        $rightLabels = [
            '性別',
            '婚姻',
            '年齢',
            '出身地',
            '宗教',
            'お祈り*',
            '飲酒への許容度*',
            '現在の在留資格**',
            '就労開始可能日***',
            '技能試験 &技能実習経験',
        ];

        $rightFields = [
            'gender',
            'marital_status',
            'age',
            'place_of_origin',
            'religion',
            'prayer_requirement',
            'alcohol_tolerance',
            'current_visa_type',
            'work_start_date',
            'technical_experience',
        ];

        foreach ($leftLabels as $index => $label) {
            $row = 5 + $index;
            $sheet->setCellValue("B{$row}", $label);
            $sheet->mergeCells("C{$row}:D{$row}");
            $sheet->setCellValue("C{$row}", $this->formatProfileValue($leftFields[$index]));
            $this->styleProfileRow($sheet, $row, 'B', 'D');
        }

        foreach ($rightLabels as $index => $label) {
            $row = 5 + $index;
            $sheet->setCellValue("E{$row}", $label);
            $sheet->mergeCells("F{$row}:G{$row}");
            $sheet->setCellValue("F{$row}", $this->formatProfileValue($rightFields[$index]));
            $this->styleProfileRow($sheet, $row, 'E', 'G');
        }

        $sheet->mergeCells('F15:G15');
        $sheet->setCellValue('F15', '');
        $this->styleProfileRow($sheet, 15, 'F', 'G');

        $sheet->mergeCells('H5:I15');
        $sheet->getStyle('H5:I15')->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FFD1D5DB'],
                ],
            ],
        ]);
    }

    private function writeEducationBlock(Worksheet $sheet): void
    {
        $sheet->mergeCells('B16:I16');
        $sheet->setCellValue('B16', '学歴');
        $this->styleSectionHeader($sheet, 'B16:I16');

        $sheet->mergeCells('B17:C17');
        $sheet->setCellValue('B17', '学校名');
        $sheet->setCellValue('D17', '学校種別');
        $sheet->setCellValue('E17', '学校所在地');
        $sheet->setCellValue('F17', '入学年月');
        $sheet->setCellValue('G17', '卒業年月（中退年月）');
        $sheet->mergeCells('H17:I17');
        $sheet->setCellValue('H17', '状況');
        $this->styleHeaderRow($sheet, 'B17:I17');

        $row = 18;
        foreach ($this->educationHistories as $educationHistory) {
            /** @var UserEducationHistory $educationHistory */
            $sheet->mergeCells("B{$row}:C{$row}");
            $sheet->setCellValue("B{$row}", $this->normalizeText($educationHistory->education));
            $sheet->setCellValue("D{$row}", $this->normalizeText($educationHistory->institution));
            $sheet->setCellValue("E{$row}", $this->normalizeText($educationHistory->location));
            $sheet->setCellValue("F{$row}", $this->formatDate($educationHistory->date_of_entry));
            $sheet->setCellValue(
                "G{$row}",
                $this->formatDate($educationHistory->date_of_graduation ?? $educationHistory->date_of_dropped_out)
            );
            $sheet->mergeCells("H{$row}:I{$row}");
            $sheet->setCellValue("H{$row}", $this->formatEducationStatus($educationHistory->status));
            $this->styleDataRow($sheet, $row, ['B', 'C', 'D', 'E', 'F', 'G', 'H', 'I']);
            $row++;
        }
    }

    private function writeWorkBlock(Worksheet $sheet): void
    {
        $workHeaderRow = max(21, 18 + $this->educationHistories->count());

        $sheet->mergeCells("B{$workHeaderRow}:I{$workHeaderRow}");
        $sheet->setCellValue("B{$workHeaderRow}", '職歴');
        $this->styleSectionHeader($sheet, "B{$workHeaderRow}:I{$workHeaderRow}");

        $headerRow = $workHeaderRow + 1;
        $sheet->mergeCells("B{$headerRow}:C{$headerRow}");
        $sheet->setCellValue("B{$headerRow}", '会社名');
        $sheet->setCellValue("D{$headerRow}", '職種');
        $sheet->setCellValue("E{$headerRow}", '会社所在地');
        $sheet->setCellValue("F{$headerRow}", '入社年月');
        $sheet->setCellValue("G{$headerRow}", '退職年月');
        $sheet->setCellValue("H{$headerRow}", '雇用形態');
        $sheet->setCellValue("I{$headerRow}", '在留資格');
        $this->styleHeaderRow($sheet, "B{$headerRow}:I{$headerRow}");

        $row = $headerRow + 1;
        foreach ($this->workExperiences as $workExperience) {
            /** @var WorkExperience $workExperience */
            $sheet->mergeCells("B{$row}:C{$row}");
            $sheet->setCellValue("B{$row}", $this->normalizeText($workExperience->company_name));
            $sheet->setCellValue("D{$row}", $this->normalizeText($workExperience->field_of_work));
            $sheet->setCellValue("E{$row}", $this->normalizeText($workExperience->location));
            $sheet->setCellValue("F{$row}", $this->formatDate($workExperience->date_of_join));
            $sheet->setCellValue("G{$row}", $this->formatDate($workExperience->date_of_resign));
            $sheet->setCellValue("H{$row}", $this->formatEmploymentStatus($workExperience->employment_status));
            $sheet->setCellValue("I{$row}", $this->formatVisaType($workExperience->visa_type));
            $this->styleDataRow($sheet, $row, ['B', 'C', 'D', 'E', 'F', 'G', 'H', 'I']);
            $row++;
        }
    }

    private function styleProfileRow(Worksheet $sheet, int $row, string $startColumn, string $endColumn): void
    {
        $sheet->getStyle("{$startColumn}{$row}:{$endColumn}{$row}")->applyFromArray([
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FFD1D5DB'],
                ],
            ],
        ]);
    }

    private function styleSectionHeader(Worksheet $sheet, string $range): void
    {
        $sheet->getStyle($range)->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF1F2937'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF111827'],
                ],
            ],
        ]);
    }

    private function styleHeaderRow(Worksheet $sheet, string $range): void
    {
        $sheet->getStyle($range)->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFE2E8F0'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FFD1D5DB'],
                ],
            ],
        ]);
    }

    private function styleDataRow(Worksheet $sheet, int $row, array $columns): void
    {
        foreach ($columns as $column) {
            $sheet->getStyle("{$column}{$row}")->applyFromArray([
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FFD1D5DB'],
                    ],
                ],
            ]);
        }
    }

    private function formatProfileValue(string $field): string
    {
        if ($this->profile === null) {
            return '-';
        }

        return match ($field) {
            'birth_date' => $this->formatDate($this->profile->birth_date),
            'entry_date' => $this->formatDate($this->profile->entry_date),
            'visa_expiry_date' => $this->formatDate($this->profile->visa_expiry_date),
            'jlpt_level' => $this->formatJlptLevel($this->profile->jlpt_level),
            'gender' => $this->formatGender($this->profile->gender),
            'marital_status' => $this->formatMaritalStatus($this->profile->marital_status),
            'age' => $this->formatAge($this->profile->birth_date),
            'current_visa_type' => $this->normalizeText($this->profile->current_visa_type),
            'work_start_date' => $this->formatDate($this->profile->work_start_date),
            default => $this->normalizeText($this->profile->{$field} ?? null),
        };
    }

    private function formatAge(mixed $birthDate): string
    {
        if (blank($birthDate)) {
            return '-';
        }

        return (string) Carbon::parse($birthDate)->age;
    }

    private function formatDate(mixed $value): string
    {
        if (blank($value)) {
            return '-';
        }

        return Carbon::parse($value)->format('d/m/Y');
    }

    private function normalizeText(mixed $value): string
    {
        if (blank($value)) {
            return '-';
        }

        return (string) $value;
    }

    private function formatGender(mixed $value): string
    {
        return match ($value) {
            'male' => 'Laki-laki',
            'female' => 'Perempuan',
            default => $this->normalizeText($value),
        };
    }

    private function formatMaritalStatus(mixed $value): string
    {
        return match ($value) {
            'single' => 'Belum Menikah',
            'married' => 'Menikah',
            'divorce' => 'Cerai',
            default => $this->normalizeText($value),
        };
    }

    private function formatJlptLevel(mixed $value): string
    {
        return match ($value) {
            'none' => 'Tidak ada',
            default => $this->normalizeText($value),
        };
    }

    private function formatEducationStatus(mixed $value): string
    {
        return match ($value) {
            'graduated' => 'Lulus',
            'studying' => 'Masih Sekolah/Berkuliah',
            'droppedOut' => 'Mengundurkan Diri',
            default => $this->normalizeText($value),
        };
    }

    private function formatEmploymentStatus(mixed $value): string
    {
        return match ($value) {
            'permanent' => 'Karyawan Tetap',
            'contract' => 'Karyawan Kontrak',
            'fullTime' => 'Full Time',
            'partTime' => 'Part Time',
            'freelance' => 'Freelance',
            default => $this->normalizeText($value),
        };
    }

    private function formatVisaType(mixed $value): string
    {
        return match ($value) {
            'tokuteiGinou' => 'Tokutei Ginou',
            'gijinkoku' => 'Gijinkoku',
            'magang' => 'Magang',
            default => $this->normalizeText($value),
        };
    }

    private function resolveProfilePicturePath(): ?string
    {
        $profilePicture = $this->profile?->profile_picture;

        if (blank($profilePicture) || $profilePicture === 'default.jpg') {
            return null;
        }

        $candidates = [
            public_path($profilePicture),
            public_path('storage/' . ltrim($profilePicture, '/')),
            storage_path('app/public/' . ltrim($profilePicture, '/')),
        ];

        foreach ($candidates as $candidate) {
            if (is_file($candidate)) {
                return $candidate;
            }
        }

        return null;
    }
}
