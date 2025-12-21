<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        $tables = ['employees', 'trainings', 'categories'];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                // FIX: Yahan $tableName (string) use karein, $table (object) nahi
                if (!Schema::hasColumn($tableName, 'tenant_id')) {
                    $table->string('tenant_id')->after('id')->nullable()->index();
                }
            });
        }
    }

    public function down()
    {
        $tables = ['employees', 'trainings', 'categories'];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (Schema::hasColumn($tableName, 'tenant_id')) {
                    $table->dropColumn('tenant_id');
                }
            });
        }
    }
};