<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            $table->decimal('kinerja_semester_1', 5, 2)->nullable()->after('foto');
            $table->decimal('kinerja_semester_2', 5, 2)->nullable()->after('kinerja_semester_1');
            $table->decimal('disiplin', 5, 2)->nullable()->after('kinerja_semester_2');

            $table->decimal('rohani_semester_1', 5, 2)->nullable()->after('disiplin');
            $table->decimal('rohani_semester_2', 5, 2)->nullable()->after('rohani_semester_1');

            $table->decimal('emental_semester_1', 5, 2)->nullable()->after('rohani_semester_2');
            $table->decimal('emental_semester_2', 5, 2)->nullable()->after('emental_semester_1');

            $table->decimal('kesehatan', 5, 2)->nullable()->after('emental_semester_2');

            $table->decimal('jasmani_semester_1', 5, 2)->nullable()->after('kesehatan');
            $table->decimal('jasmani_semester_2', 5, 2)->nullable()->after('jasmani_semester_1');

            $table->decimal('akademik', 5, 2)->nullable()->after('jasmani_semester_2');

            $table->decimal('nilai_ip_personel', 5, 2)->nullable()->after('akademik');
        });
    }

    public function down(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            $table->dropColumn([
                'kinerja_semester_1',
                'kinerja_semester_2',
                'disiplin',
                'rohani_semester_1',
                'rohani_semester_2',
                'emental_semester_1',
                'emental_semester_2',
                'kesehatan',
                'jasmani_semester_1',
                'jasmani_semester_2',
                'akademik',
                'nilai_ip_personel',
            ]);
        });
    }
};
