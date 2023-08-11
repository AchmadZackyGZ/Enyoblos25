<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Throwable;

class ImportPemilih implements ToModel, WithHeadingRow, SkipsOnError
{
    use SkipsErrors;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new User([
            'nim' => $row['nim'],
            'name' => $row['nama'],
            'email' => $row['email'],
            'password' => bcrypt($row['nim'] . '_pemira2023'),
            'angkatan' => $row['angkatan'],
        ]);
    }

    public function onError(Throwable $e)
    {
    }
}
