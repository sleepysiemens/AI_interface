<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('settings')->insert([
            ['name' => 'gpt-4_openai_key','value' => ''],
            ['name' => 'gpt-3_openai_key','value' => ''],
            ['name' => 'gpt-3_16k_openai_key','value' => ''],
            ['name' => 'midjorney_key','value' => ''],
            ['name' => 'claude3_key','value' => ''],
            ['name' => 'stab_diff_key','value' => ''],
            ['name' => 'ideogram_key','value' => ''],
            ['name' => 'runway_key','value' => ''],
            ['name' => 'deepfake_key','value' => ''],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
